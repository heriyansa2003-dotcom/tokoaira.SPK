# Dokumentasi Sistem Pendukung Keputusan (SPK) - Metode AHP
## Aplikasi Manajemen Inventaris Toko Aira

---

## 📋 Daftar Isi
1. [Ringkasan Eksekutif](#ringkasan-eksekutif)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Metode AHP dan Kriteria](#metode-ahp-dan-kriteria)
4. [Implementasi Teknis](#implementasi-teknis)
5. [Panduan Penggunaan](#panduan-penggunaan)
6. [API Endpoints](#api-endpoints)
7. [Troubleshooting](#troubleshooting)

---

## 🎯 Ringkasan Eksekutif

Sistem Pendukung Keputusan (SPK) dengan metode **Analytic Hierarchy Process (AHP)** telah diintegrasikan ke dalam aplikasi manajemen inventaris Toko Aira. Sistem ini membantu admin mengidentifikasi prioritas pengadaan barang berdasarkan tiga kriteria utama dengan bobot tertentu.

### Fitur Utama:
- ✅ **Filter Kategori** - Analisis per kategori atau global
- ✅ **Normalisasi Satuan** - Perbandingan adil untuk satuan berbeda (Kg, Pcs, Liter, Dus)
- ✅ **Visualisasi Bar Chart** - Tampilan Top 10 barang prioritas
- ✅ **Tabel Prioritas Lengkap** - Ranking dengan detail lengkap
- ✅ **Laporan Cetak** - Export ke format print-friendly
- ✅ **API Endpoint** - Integrasi dengan sistem lain

---

## 🏗️ Arsitektur Sistem

### Struktur File yang Dimodifikasi/Ditambahkan:

```
app/
├── Services/
│   └── AHPService.php                 (DIPERBARUI)
├── Http/Controllers/
│   └── AHPController.php              (DIPERBARUI)

resources/views/
├── ahp/
│   ├── index.blade.php                (DIPERBARUI)
│   └── print.blade.php                (DIPERBARUI)

routes/
└── web.php                            (DIPERBARUI)
```

### Alur Data:

```
User Request
    ↓
AHPController (index/print/getAHPData)
    ↓
AHPService (calculatePriorities/getStatistics)
    ↓
Product Model + Category Model
    ↓
Database Query
    ↓
Normalisasi & Perhitungan AHP
    ↓
Response (View/JSON)
```

---

## 📊 Metode AHP dan Kriteria

### Kriteria Penilaian:

| Kriteria | Bobot | Tipe | Deskripsi |
|----------|-------|------|-----------|
| **Volume Penjualan (C1)** | 63.7% | Benefit | Mencari barang fast-moving |
| **Stok Minimum (C2)** | 25.8% | Cost/Urgency | Prioritas stok mendekati minimum |
| **Harga Satuan (C3)** | 10.5% | Benefit | Optimalisasi perputaran modal |

### Logika Normalisasi:

#### 1. **Volume Penjualan (Benefit)**
```
Normalisasi: Min-Max Scaling
Formula: (X - Min) / (Max - Min)
Range: 0-1
Tujuan: Semakin tinggi penjualan, semakin tinggi skor
```

**Penanganan Satuan:** Tidak ada konversi satuan. Nilai penjualan dinormalisasi relatif terhadap nilai maksimum dalam dataset, sehingga fair untuk semua satuan.

#### 2. **Stok Minimum (Cost/Urgency)**
```
Normalisasi: Rasio Stok
Formula: Stok Saat Ini / Stok Minimum
Range: 0-1 (dengan logika khusus)

Jika Rasio ≤ 1 (Stok Kritis):
  Score = 1.0 - (Rasio × 0.2)
  Range: 0.8-1.0
  
Jika Rasio > 1 (Stok Aman):
  Score = max(0, 0.8 - ((Rasio - 1) / 4) × 0.8)
  Range: 0-0.8
```

**Penanganan Satuan:** Rasio dihitung per produk tanpa konversi satuan. Satuan berbeda (Kg, Pcs, Liter) ditangani secara konsisten karena perhitungan berbasis rasio.

#### 3. **Harga Satuan (Benefit)**
```
Normalisasi: Min-Max Scaling
Formula: Harga / Harga Maksimum
Range: 0-1
Tujuan: Semakin tinggi harga, semakin tinggi skor (High Value Investment)
```

**Penanganan Satuan:** Harga adalah nilai absolut, tidak terpengaruh oleh satuan fisik produk.

### Skor Akhir (Weighted Sum):
```
Final Score = (Sales_Score × 0.637) + (Stock_Score × 0.258) + (Price_Score × 0.105)
Range: 0-1 (0% - 100%)
```

### Kategori Prioritas:
| Skor | Label | Warna |
|------|-------|-------|
| ≥ 0.7 | Sangat Tinggi | Merah (#ef4444) |
| 0.5 - 0.69 | Tinggi | Kuning (#f59e0b) |
| 0.3 - 0.49 | Sedang | Biru (#06b6d4) |
| < 0.3 | Rendah | Abu-abu (#6b7280) |

---

## 💻 Implementasi Teknis

### 1. AHPService.php

**Metode Utama:**

#### `calculatePriorities($categoryId = null, $globalNormalization = true)`
Menghitung skor AHP untuk semua produk atau filter berdasarkan kategori.

```php
$ahpService = new AHPService();

// Semua kategori
$priorities = $ahpService->calculatePriorities();

// Filter kategori tertentu
$priorities = $ahpService->calculatePriorities($categoryId = 5);
```

**Return Value:**
```php
Collection [
    [
        'id' => 1,
        'name' => 'Produk A',
        'category_id' => 5,
        'category_name' => 'Elektronik',
        'stock' => 50,
        'min_stock' => 20,
        'unit' => 'Pcs',
        'sales_frequency' => 100,
        'price' => 500000,
        'supplier_id' => 2,
        'supplier_name' => 'Supplier XYZ',
        'scores' => [
            'sales' => 0.8500,
            'stock' => 0.6000,
            'price' => 0.9500
        ],
        'score' => 0.7890,
        'priority' => 'Tinggi',
        'stock_ratio' => 2.50,
        'status_stok' => 'Aman'
    ],
    // ... produk lainnya
]
```

#### `getTopPriorities($limit = 10, $categoryId = null)`
Mendapatkan top N produk berdasarkan skor AHP.

```php
$topPriorities = $ahpService->getTopPriorities(10, $categoryId = null);
```

#### `getStatistics($categoryId = null)`
Mendapatkan statistik ringkas untuk dashboard.

```php
$stats = $ahpService->getStatistics();
// Return:
// [
//     'total_products' => 50,
//     'critical_stock' => 5,
//     'high_priority' => 15,
//     'medium_priority' => 20,
//     'low_priority' => 10,
//     'avg_score' => 0.5234
// ]
```

#### `getCategories()`
Mendapatkan daftar kategori untuk dropdown filter.

```php
$categories = $ahpService->getCategories();
// Return: Collection of Category models
```

#### `getWeights()`
Mendapatkan bobot kriteria AHP.

```php
$weights = $ahpService->getWeights();
// Return: ['sales_frequency' => 0.637, 'min_stock_ratio' => 0.258, 'price' => 0.105]
```

### 2. AHPController.php

**Metode Utama:**

#### `index(Request $request)`
Menampilkan halaman SPK dengan filter kategori.

**Query Parameters:**
- `category_id` (optional): ID kategori untuk filter

**Contoh:**
```
GET /admin/ahp-priority
GET /admin/ahp-priority?category_id=5
```

#### `print(Request $request)`
Menampilkan laporan cetak SPK.

**Query Parameters:**
- `category_id` (optional): ID kategori untuk filter

**Contoh:**
```
GET /admin/ahp-priority/print
GET /admin/ahp-priority/print?category_id=5
```

#### `getAHPData(Request $request)`
API endpoint untuk mendapatkan data AHP dalam format JSON.

**Query Parameters:**
- `category_id` (optional): ID kategori untuk filter
- `limit` (optional, default: 10): Jumlah produk teratas

**Contoh:**
```
GET /admin/api/ahp-data
GET /admin/api/ahp-data?category_id=5&limit=20
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Produk A",
            "category_name": "Elektronik",
            "stock": 50,
            "min_stock": 20,
            "unit": "Pcs",
            "sales_frequency": 100,
            "price": 500000,
            "score": 0.7890,
            "priority": "Tinggi",
            "status_stok": "Aman"
        }
    ],
    "statistics": {
        "total_products": 50,
        "critical_stock": 5,
        "high_priority": 15,
        "medium_priority": 20,
        "low_priority": 10,
        "avg_score": 0.5234
    }
}
```

---

## 🎓 Panduan Penggunaan

### Akses Menu SPK:
1. Login sebagai Admin
2. Klik menu **"SPK Prioritas (AHP)"** di sidebar
3. Halaman akan menampilkan:
   - **Filter Kategori** - Pilih kategori atau "Semua Kategori"
   - **Statistik Ringkas** - Total produk, stok kritis, prioritas tinggi, skor rata-rata
   - **Kriteria AHP** - Penjelasan bobot dan logika setiap kriteria
   - **Bar Chart** - Visualisasi Top 10 barang prioritas
   - **Tabel Lengkap** - Ranking prioritas semua produk

### Interpretasi Hasil:

#### Status Stok:
- **Kritis** (Merah) - Stok ≤ Stok Minimum → Perlu restock segera
- **Aman** (Hitam) - Stok > Stok Minimum → Stok masih mencukupi

#### Prioritas Urgensi:
- **Sangat Tinggi** (Merah) - Skor ≥ 0.7 → Restock URGENT
- **Tinggi** (Kuning) - Skor 0.5-0.69 → Restock dalam waktu dekat
- **Sedang** (Biru) - Skor 0.3-0.49 → Restock normal
- **Rendah** (Abu-abu) - Skor < 0.3 → Stok cukup, monitor saja

### Cetak Laporan:
1. Pilih kategori (opsional)
2. Klik tombol **"Cetak Laporan"**
3. Jendela print akan terbuka dengan format profesional
4. Klik **"CETAK LAPORAN"** atau gunakan Ctrl+P untuk print

---

## 🔌 API Endpoints

### Base URL:
```
http://localhost/admin/api/ahp-data
```

### Endpoint: GET /admin/api/ahp-data

**Deskripsi:** Mendapatkan data AHP dalam format JSON

**Query Parameters:**
| Parameter | Type | Required | Default | Deskripsi |
|-----------|------|----------|---------|-----------|
| category_id | integer | No | null | ID kategori untuk filter |
| limit | integer | No | 10 | Jumlah produk teratas |

**Contoh Request:**
```bash
# Semua kategori, top 10
curl "http://localhost/admin/api/ahp-data"

# Kategori 5, top 20
curl "http://localhost/admin/api/ahp-data?category_id=5&limit=20"
```

**Contoh Response (200 OK):**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Laptop Asus",
            "category_id": 5,
            "category_name": "Elektronik",
            "stock": 10,
            "min_stock": 5,
            "unit": "Pcs",
            "sales_frequency": 45,
            "price": 8500000,
            "supplier_id": 2,
            "supplier_name": "PT Supplier Elektronik",
            "scores": {
                "sales": 0.9000,
                "stock": 0.6000,
                "price": 1.0000
            },
            "score": 0.8487,
            "priority": "Sangat Tinggi",
            "stock_ratio": 2.0,
            "status_stok": "Aman"
        }
    ],
    "statistics": {
        "total_products": 25,
        "critical_stock": 3,
        "high_priority": 8,
        "medium_priority": 10,
        "low_priority": 4,
        "avg_score": 0.5234
    }
}
```

**Error Response (400 Bad Request):**
```json
{
    "success": false,
    "message": "Invalid category_id"
}
```

---

## 🔧 Troubleshooting

### 1. Data Produk Tidak Muncul di SPK

**Penyebab:**
- Produk belum memiliki nilai `min_stock`, `sales_frequency`, atau `unit`
- Kategori produk belum dibuat

**Solusi:**
```php
// Pastikan setiap produk memiliki:
- min_stock (integer) - Stok minimum
- sales_frequency (integer) - Frekuensi penjualan
- unit (string) - Satuan (Pcs, Kg, Liter, Dus, dll)
- price (integer) - Harga satuan
- category_id (integer) - ID kategori
```

### 2. Skor AHP Semua Sama

**Penyebab:**
- Semua produk memiliki nilai `sales_frequency` yang sama
- Semua produk memiliki harga yang sama

**Solusi:**
Pastikan data produk memiliki variasi nilai untuk ketiga kriteria agar normalisasi berfungsi optimal.

### 3. Bar Chart Tidak Tampil

**Penyebab:**
- Chart.js library tidak ter-load
- Data `topPriorities` kosong

**Solusi:**
1. Cek koneksi internet (CDN Chart.js)
2. Pastikan ada minimal 1 produk dalam database
3. Buka browser console (F12) untuk melihat error

### 4. Filter Kategori Tidak Bekerja

**Penyebab:**
- Kategori tidak memiliki produk
- Query parameter tidak terkirim dengan benar

**Solusi:**
```php
// Verifikasi di AHPController
$categoryId = $request->get('category_id', null);
dd($categoryId); // Debug untuk melihat nilai
```

### 5. Laporan Cetak Tidak Rapi

**Penyebab:**
- Browser tidak mendukung CSS print
- Margin halaman tidak sesuai

**Solusi:**
1. Gunakan browser Chrome/Firefox
2. Buka Print Settings → Margins: Default
3. Pastikan "Background Graphics" dicentang

---

## 📈 Contoh Kasus Penggunaan

### Kasus 1: Identifikasi Barang Fast-Moving yang Stoknya Kritis

**Scenario:**
- Barang A: Sales = 100x, Stock = 5, Min Stock = 20
- Barang B: Sales = 50x, Stock = 100, Min Stock = 20

**Hasil AHP:**
- Barang A: Score = 0.85 (Sangat Tinggi) → RESTOCK URGENT
- Barang B: Score = 0.42 (Sedang) → Monitor

### Kasus 2: Optimalisasi Modal untuk High-Value Items

**Scenario:**
- Barang Premium: Price = 5,000,000, Sales = 10x, Stock = 50
- Barang Standar: Price = 500,000, Sales = 100x, Stock = 10

**Hasil AHP:**
- Barang Premium: Score = 0.65 (Tinggi) → Prioritas untuk modal besar
- Barang Standar: Score = 0.78 (Tinggi) → Prioritas untuk volume

---

## 📝 Catatan Penting

1. **Normalisasi Satuan**: Sistem tidak melakukan konversi satuan (Kg ke Pcs). Setiap produk dinilai berdasarkan rasio relatif dalam kategorinya.

2. **Min-Max Scaling**: Digunakan untuk Volume Penjualan dan Harga Satuan untuk memastikan perbandingan yang adil antar produk.

3. **Bobot Tetap**: Bobot AHP (63.7%, 25.8%, 10.5%) adalah tetap dan tidak dapat diubah dari UI. Untuk mengubah, edit di `AHPService.php`.

4. **Filter Global vs Per-Kategori**: Normalisasi selalu dilakukan terhadap scope yang dipilih (global atau per-kategori).

5. **Performance**: Untuk database dengan >1000 produk, pertimbangkan pagination atau caching.

---

## 🚀 Pengembangan Lebih Lanjut

### Fitur yang Bisa Ditambahkan:
- [ ] Konfigurasi bobot AHP dari UI
- [ ] Export ke Excel/CSV
- [ ] Grafik tren prioritas per bulan
- [ ] Alert otomatis untuk stok kritis
- [ ] Integrasi dengan sistem pemesanan otomatis
- [ ] Analisis perbandingan kategori
- [ ] Prediksi stok menggunakan machine learning

---

## 📞 Support

Untuk pertanyaan atau laporan bug, silakan hubungi tim development.

**Dokumen ini terakhir diperbarui:** 25 Februari 2026

---

*Dokumentasi Sistem Pendukung Keputusan (SPK) - Toko Aira Inventory Management System*
