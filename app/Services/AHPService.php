<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;

class AHPService
{
    /**
     * Kriteria SPK Penentuan Stok Prioritas (Metode AHP):
     * 1. Volume Penjualan (C1) - Benefit: 63.7%
     *    Logika: Min-Max Scaling terhadap total penjualan dalam periode
     *    Tujuan: Mencari barang fast-moving
     * 
     * 2. Stok Minimum (C2) - Cost/Urgency: 25.8%
     *    Logika: Rasio Stok (Stok Saat Ini / Ambang Batas Minimum)
     *    Semakin kecil rasio (mendekati 0), semakin tinggi skor prioritas
     *    Tujuan: Prioritas bagi stok yang mendekati atau di bawah ambang batas
     * 
     * 3. Harga Satuan (C3) - Benefit/Investasi: 10.5%
     *    Logika: Normalisasi harga terhadap harga tertinggi dalam kategori/global
     *    Tujuan: Optimalisasi perputaran modal (High Value Investment)
     * 
     * Penanganan Perbedaan Satuan:
     * - Volume Penjualan dinormalisasi per produk relatif terhadap penjualan maksimum.
     * - Stok Minimum dinormalisasi berdasarkan rasio (stok saat ini / stok minimum).
     * - Harga Satuan dinormalisasi relatif terhadap harga maksimum.
     * - Satuan berbeda (Kg, Pcs, Liter, Dus) ditangani melalui normalisasi tanpa konversi absolut.
     */
    protected $weights = [
        'sales_frequency' => 0.637,
        'min_stock_ratio' => 0.258,
        'price' => 0.105
    ];

    /**
     * Hitung prioritas untuk semua produk atau filter berdasarkan kategori
     * 
     * @param int|null $categoryId - ID kategori untuk filter (null = semua kategori)
     * @param bool $globalNormalization - Gunakan normalisasi global atau per kategori
     * @return Collection - Koleksi produk dengan skor AHP
     */
    public function calculatePriorities($categoryId = null, $globalNormalization = true)
    {
        // 1. Ambil data produk berdasarkan filter kategori
        $query = Product::with('category', 'supplier');
        
        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }
        
        $products = $query->get();
        
        if ($products->isEmpty()) {
            return collect();
        }

        // 2. Tentukan scope normalisasi (global atau per kategori)
        if ($globalNormalization) {
            $normalizationScope = $products;
        } else {
            // Jika per kategori, gunakan produk dalam kategori yang sama
            $normalizationScope = $products;
        }

        // 3. Cari nilai max/min untuk normalisasi Min-Max Scaling
        $maxPrice = $normalizationScope->max('price') ?: 1;
        $maxSales = $normalizationScope->max('sales_frequency') ?: 1;
        $minSales = $normalizationScope->min('sales_frequency') ?: 0;

        // 4. Proses perhitungan setiap produk dengan normalisasi yang lebih akurat
        $results = $products->map(function ($product) use ($maxPrice, $maxSales, $minSales) {
            // ========== A. NORMALISASI VOLUME PENJUALAN (Benefit) ==========
            // Min-Max Scaling: (X - Min) / (Max - Min)
            // Mengubah nilai absolut menjadi rentang 0-1 yang fair
            if ($maxSales > $minSales) {
                $salesScore = ($product->sales_frequency - $minSales) / ($maxSales - $minSales);
            } else {
                $salesScore = $maxSales > 0 ? $product->sales_frequency / $maxSales : 0;
            }
            $salesScore = max(0, min(1, $salesScore)); // Pastikan dalam rentang 0-1

            // ========== B. NORMALISASI STOK MINIMUM (Cost/Urgency) ==========
            // Rasio: (Stok Saat Ini / Ambang Batas Minimum)
            // Jika stok <= min_stock, maka sangat mendesak (skor tinggi)
            // Jika stok > min_stock, skor berkurang seiring bertambahnya stok
            $ratio = $product->min_stock > 0 ? $product->stock / $product->min_stock : 1;
            
            if ($ratio <= 1) {
                // Stok kritis atau di bawah minimum: skor 0.8 - 1.0
                // Semakin mendekati 0 stoknya, semakin mendekati 1 skornya
                $stockScore = 1.0 - ($ratio * 0.2);
            } else {
                // Stok aman: skor menurun dari 0.8 ke arah 0
                // Skor 0 jika stok mencapai 5x lipat dari minimum
                $stockScore = max(0, 0.8 - (($ratio - 1) / 4) * 0.8);
            }

            // ========== C. NORMALISASI HARGA SATUAN (Benefit/Investasi) ==========
            // Min-Max Scaling: (X - Min) / (Max - Min)
            // Harga lebih tinggi = prioritas lebih tinggi (High Value Investment)
            $priceScore = $maxPrice > 0 ? $product->price / $maxPrice : 0;
            $priceScore = max(0, min(1, $priceScore)); // Pastikan dalam rentang 0-1

            // ========== D. HITUNG SKOR AKHIR (Weighted Sum) ==========
            $finalScore = ($salesScore * $this->weights['sales_frequency']) + 
                          ($stockScore * $this->weights['min_stock_ratio']) + 
                          ($priceScore * $this->weights['price']);

            // Pastikan skor akhir dalam rentang 0-1
            $finalScore = max(0, min(1, $finalScore));

            return [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name ?? 'Tanpa Kategori',
                'stock' => $product->stock,
                'min_stock' => $product->min_stock,
                'unit' => $product->unit ?: 'unit',
                'sales_frequency' => $product->sales_frequency,
                'price' => $product->price,
                'supplier_id' => $product->supplier_id,
                'supplier_name' => $product->supplier->name ?? 'Tanpa Supplier',
                'scores' => [
                    'sales' => round($salesScore, 4),
                    'stock' => round($stockScore, 4),
                    'price' => round($priceScore, 4),
                ],
                'score' => round($finalScore, 4),
                'priority' => $this->getPriorityLabel($finalScore),
                'stock_ratio' => round($ratio, 2),
                'status_stok' => $product->stock <= $product->min_stock ? 'Kritis' : 'Aman'
            ];
        });

        // 5. Urutkan berdasarkan skor tertinggi (Prioritas Utama)
        return $results->sortByDesc('score')->values();
    }

    /**
     * Dapatkan top N produk berdasarkan skor AHP
     * 
     * @param int $limit - Jumlah produk teratas yang diambil (default: 10)
     * @param int|null $categoryId - ID kategori untuk filter
     * @return Collection
     */
    public function getTopPriorities($limit = 10, $categoryId = null)
    {
        return $this->calculatePriorities($categoryId)->take($limit);
    }

    /**
     * Dapatkan statistik ringkas untuk dashboard
     * 
     * @param int|null $categoryId - ID kategori untuk filter
     * @return array
     */
    public function getStatistics($categoryId = null)
    {
        $priorities = $this->calculatePriorities($categoryId);

        if ($priorities->isEmpty()) {
            return [
                'total_products' => 0,
                'critical_stock' => 0,
                'high_priority' => 0,
                'medium_priority' => 0,
                'low_priority' => 0,
                'avg_score' => 0
            ];
        }

        return [
            'total_products' => $priorities->count(),
            'critical_stock' => $priorities->where('status_stok', 'Kritis')->count(),
            'high_priority' => $priorities->whereIn('priority', ['Sangat Tinggi', 'Tinggi'])->count(),
            'medium_priority' => $priorities->where('priority', 'Sedang')->count(),
            'low_priority' => $priorities->where('priority', 'Rendah')->count(),
            'avg_score' => round($priorities->avg('score'), 4)
        ];
    }

    /**
     * Dapatkan daftar kategori untuk dropdown filter
     * 
     * @return Collection
     */
    public function getCategories()
    {
        return Category::orderBy('name')->get();
    }

    /**
     * Dapatkan label prioritas berdasarkan skor
     * 
     * @param float $score - Skor AHP (0-1)
     * @return string - Label prioritas
     */
    protected function getPriorityLabel($score)
    {
        if ($score >= 0.7) return 'Sangat Tinggi';
        if ($score >= 0.5) return 'Tinggi';
        if ($score >= 0.3) return 'Sedang';
        return 'Rendah';
    }

    /**
     * Dapatkan bobot kriteria AHP
     * 
     * @return array
     */
    public function getWeights()
    {
        return $this->weights;
    }
}
