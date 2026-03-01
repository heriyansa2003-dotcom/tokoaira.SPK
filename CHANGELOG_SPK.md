# Changelog - Sistem Pendukung Keputusan (SPK) AHP

## Version 2.0 - 25 Februari 2026

### 🎉 Fitur Baru

#### 1. Filter Kategori
- Dropdown untuk memilih "Semua Kategori" atau kategori tertentu
- Filter otomatis menghitung ulang skor AHP per kategori
- Tombol "Reset" untuk kembali ke semua kategori

#### 2. Normalisasi Satuan yang Ditingkatkan
- **Min-Max Scaling** untuk Volume Penjualan: `(X - Min) / (Max - Min)`
- **Rasio Stok** untuk Stok Minimum: `Stok Saat Ini / Stok Minimum`
- **Normalisasi Harga** untuk Harga Satuan: `Harga / Harga Maksimum`
- Semua nilai dinormalisasi ke rentang 0-1 untuk perbandingan yang adil

#### 3. Visualisasi Bar Chart
- Chart.js integration untuk menampilkan Top 10 barang prioritas
- Warna berdasarkan level prioritas (Merah, Kuning, Biru, Abu-abu)
- Responsive dan mobile-friendly

#### 4. Statistik Dashboard
- Total Produk Teranalisis
- Jumlah Stok Kritis
- Jumlah Prioritas Tinggi
- Skor Rata-rata AHP

#### 5. Tabel Prioritas Lengkap
- Kolom kategori untuk identifikasi cepat
- Status stok (Kritis/Aman)
- Skor dengan progress bar visual
- Badge prioritas dengan warna berbeda

#### 6. API Endpoint JSON
- `GET /admin/api/ahp-data` untuk integrasi sistem lain
- Support query parameter `category_id` dan `limit`
- Response format JSON terstandar

#### 7. Laporan Cetak Profesional
- Filter kategori terintegrasi di laporan
- Tampilan print-friendly dengan margin 2cm
- Informasi statistik lengkap

### 🔧 Perbaikan Teknis

#### AHPService.php
- Tambahan metode `getTopPriorities($limit, $categoryId)`
- Tambahan metode `getStatistics($categoryId)`
- Tambahan metode `getCategories()`
- Perbaikan logika normalisasi dengan Min-Max Scaling
- Support untuk kategori-specific analysis
- Tambahan field dalam response: `category_name`, `supplier_name`, `stock_ratio`, `status_stok`

#### AHPController.php
- Metode `index()` sekarang support filter kategori
- Metode `print()` sekarang support filter kategori
- Tambahan metode `getAHPData()` untuk API endpoint
- Passing data `topPriorities`, `categories`, `statistics`, `weights` ke view

#### View index.blade.php
- Redesign UI dengan statistik cards
- Tambahan filter kategori dropdown
- Tambahan section kriteria AHP dengan penjelasan
- Tambahan bar chart visualization
- Perbaikan responsive design
- Integrasi Chart.js library

#### View print.blade.php
- Tambahan kolom kategori di tabel
- Tambahan informasi filter kategori di header
- Tambahan skor rata-rata di info section
- Perbaikan layout untuk print-friendly

#### routes/web.php
- Tambahan route: `GET /admin/api/ahp-data`

### 📊 Perubahan Logika Perhitungan

#### Sebelumnya (v1.0):
```php
$salesScore = $product->sales_frequency / $maxSales;
```

#### Sekarang (v2.0):
```php
// Min-Max Scaling
if ($maxSales > $minSales) {
    $salesScore = ($product->sales_frequency - $minSales) / ($maxSales - $minSales);
} else {
    $salesScore = $maxSales > 0 ? $product->sales_frequency / $maxSales : 0;
}
```

**Keuntungan:**
- Lebih akurat untuk dataset dengan range besar
- Lebih fair dalam perbandingan antar kategori
- Menghindari bias dari outlier

### 📚 Dokumentasi

- Tambahan file: `DOKUMENTASI_SPK_AHP.md` (lengkap, 400+ baris)
- Tambahan file: `README_SPK.md` (ringkas, quick reference)
- Tambahan file: `CHANGELOG_SPK.md` (file ini)

### 🐛 Bug Fixes

- Fixed: Kategori null tidak ditampilkan dengan benar
- Fixed: Supplier null tidak ditampilkan dengan benar
- Fixed: Colspan di tabel print tidak sesuai

### ⚠️ Breaking Changes

Tidak ada breaking changes. Semua fitur lama tetap kompatibel.

### 🔄 Migration Guide

Tidak perlu migration database. Semua kolom sudah ada di versi sebelumnya:
- `min_stock` (dari migration 2026_02_18)
- `sales_frequency` (dari migration 2026_02_18)
- `unit` (dari migration 2026_02_19)
- `supplier_id` (dari migration 2026_02_19)

### 📈 Performance

- Menggunakan eager loading: `Product::with('category', 'supplier')`
- Caching bisa diimplementasikan untuk dataset besar
- Pagination bisa ditambahkan untuk tabel lengkap

### 🎯 Testing Checklist

- [x] Filter kategori bekerja dengan benar
- [x] Normalisasi satuan fair untuk semua produk
- [x] Bar chart menampilkan top 10 dengan benar
- [x] Statistik akurat
- [x] API endpoint mengembalikan JSON valid
- [x] Laporan cetak rapi dan lengkap
- [x] Responsive di mobile dan desktop

### 🚀 Fitur Mendatang (Roadmap)

- [ ] Konfigurasi bobot AHP dari UI
- [ ] Export ke Excel/CSV
- [ ] Grafik tren prioritas per bulan
- [ ] Alert otomatis untuk stok kritis
- [ ] Integrasi dengan sistem pemesanan otomatis
- [ ] Analisis perbandingan kategori
- [ ] Prediksi stok menggunakan ML

---

**Released:** 25 Februari 2026
**Author:** Senior Software Architect & Data Scientist
**Status:** Production Ready ✅
