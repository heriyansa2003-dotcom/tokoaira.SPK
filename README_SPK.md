# Sistem Pendukung Keputusan (SPK) - AHP Implementation

## 🎯 Ringkasan Cepat

Sistem Pendukung Keputusan dengan metode **Analytic Hierarchy Process (AHP)** untuk optimasi pengadaan stok barang di Toko Aira.

## ✨ Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| **Filter Kategori** | Analisis per kategori atau global |
| **Normalisasi Satuan** | Perbandingan adil untuk satuan berbeda (Kg, Pcs, Liter, Dus) |
| **Bar Chart** | Visualisasi Top 10 barang prioritas |
| **Tabel Prioritas** | Ranking lengkap dengan detail |
| **Laporan Cetak** | Export ke format print-friendly |
| **API Endpoint** | JSON API untuk integrasi sistem |

## 📊 Kriteria AHP

| Kriteria | Bobot | Tipe | Deskripsi |
|----------|-------|------|-----------|
| Volume Penjualan | 63.7% | Benefit | Barang fast-moving |
| Stok Minimum | 25.8% | Cost | Stok mendekati minimum |
| Harga Satuan | 10.5% | Benefit | High value investment |

## 🚀 Cara Menggunakan

### 1. Akses Menu SPK
```
Admin Dashboard → SPK Prioritas (AHP)
```

### 2. Filter Kategori (Opsional)
```
Pilih kategori dari dropdown → Klik "Terapkan Filter"
```

### 3. Analisis Hasil
- **Statistik Ringkas**: Total produk, stok kritis, prioritas tinggi
- **Bar Chart**: Top 10 barang yang perlu restock
- **Tabel Lengkap**: Ranking prioritas semua produk

### 4. Cetak Laporan
```
Klik tombol "Cetak Laporan" → Pilih "Print" di browser
```

## 📈 Interpretasi Skor

| Skor | Label | Aksi |
|------|-------|------|
| ≥ 0.7 | Sangat Tinggi | ⚠️ Restock URGENT |
| 0.5-0.69 | Tinggi | 📋 Restock dalam waktu dekat |
| 0.3-0.49 | Sedang | 📌 Restock normal |
| < 0.3 | Rendah | ✅ Monitor saja |

## 🔌 API Endpoint

```bash
# Semua kategori, top 10
GET /admin/api/ahp-data

# Kategori 5, top 20
GET /admin/api/ahp-data?category_id=5&limit=20
```

**Response:**
```json
{
    "success": true,
    "data": [...],
    "statistics": {...}
}
```

## 📁 File yang Dimodifikasi

```
app/Services/AHPService.php
app/Http/Controllers/AHPController.php
resources/views/ahp/index.blade.php
resources/views/ahp/print.blade.php
routes/web.php
```

## 🔍 Normalisasi Satuan

Sistem menangani satuan berbeda tanpa konversi absolut:

1. **Volume Penjualan**: Min-Max Scaling (0-1)
2. **Stok Minimum**: Rasio (Stok Saat Ini / Min Stock)
3. **Harga Satuan**: Normalisasi harga (0-1)

Setiap produk dinilai secara relatif dalam kategorinya.

## 📚 Dokumentasi Lengkap

Lihat file `DOKUMENTASI_SPK_AHP.md` untuk:
- Penjelasan detail metode AHP
- Implementasi teknis lengkap
- Contoh kasus penggunaan
- Troubleshooting

## 🛠️ Troubleshooting

### Data Produk Tidak Muncul?
Pastikan setiap produk memiliki:
- `min_stock` (integer)
- `sales_frequency` (integer)
- `unit` (string)
- `price` (integer)
- `category_id` (integer)

### Bar Chart Tidak Tampil?
- Cek koneksi internet (CDN Chart.js)
- Pastikan ada minimal 1 produk

### Filter Tidak Bekerja?
- Pastikan kategori memiliki produk
- Refresh halaman

## 📞 Support

Untuk pertanyaan atau bug report, hubungi tim development.

---

**Last Updated:** 25 Februari 2026
