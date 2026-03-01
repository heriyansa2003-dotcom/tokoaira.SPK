<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Aplikasi Inventaris Barang 

Sistem manajemen inventaris berbasis web yang dirancang untuk mempermudah pengelolaan stok barang, kategori, dan data supplier secara efisien. Proyek ini dibangun menggunakan framework **Laravel** dan menggunakan template dashboard **Mazer** untuk antarmuka yang modern dan responsif.

## 🚀 Fitur Utama

### 1. Manajemen Akses
* **Sistem Login**: Autentikasi keamanan untuk masuk ke sistem.
* **Sistem Registrasi**: Fitur pendaftaran akun pengguna baru.

### 2. Panel Administrator (Admin)
* **Dashboard Admin**: Ringkasan statistik (Jumlah barang, kategori, dan supplier).
* **Kelola Kategori**: Fitur CRUD lengkap untuk kategori barang.
* **Kelola Produk**: Pengelolaan data produk mendetail.
* **Kelola Supplier**: Manajemen data pemasok barang.

### 3. Panel Pengguna (User)
* **Dashboard & Katalog**: Antarmuka ramah pengguna untuk melihat stok.
* **Eksplorasi Kategori & Supplier**: Navigasi data yang mudah dipahami.

## 🛠️ Teknologi & Tools
* **Framework:** Laravel
* **Template UI:** [Mazer Admin Dashboard](https://github.com/zuramai/mazer)
* **Database:** MySQL

## 💻 Cara Instalasi (Lokal)
1. Clone repositori ini
2. Jalankan `composer install`
3. Jalankan `npm install` & `npm run dev`
4. Copy `.env.example` menjadi `.env` dan atur koneksi database
5. Jalankan `php artisan key:generate`
6. Jalankan `php artisan migrate --seed`
7. Akses aplikasi dengan `php artisan serve`


## Integrasi AHP untuk Prioritas Stok Barang

### 1. Pendahuluan

Metode AHP (Analytic Hierarchy Process) adalah teknik pengambilan keputusan multi-kriteria yang dikembangkan oleh Thomas L. Saaty. Dalam konteks sistem inventaris ini, AHP digunakan untuk memprioritaskan barang-barang yang memerlukan perhatian stok berdasarkan kriteria tertentu. Tujuannya adalah untuk memberikan rekomendasi yang lebih terstruktur mengenai barang mana yang harus segera diisi ulang atau dikelola lebih lanjut.

### 2. Kriteria dan Pembobotan

Untuk menentukan prioritas stok, dua kriteria utama telah diidentifikasi dan diberi bobot menggunakan pendekatan AHP:

*   **Stok (Bobot: 75%)**: Kriteria ini bersifat *cost*, artinya semakin rendah jumlah stok suatu barang, semakin tinggi prioritasnya untuk pengadaan. Barang dengan stok yang mendekati nol akan memiliki skor prioritas yang lebih tinggi.
*   **Harga (Bobot: 25%)**: Kriteria ini bersifat *benefit*, artinya semakin tinggi harga satuan suatu barang, semakin tinggi prioritasnya. Asumsinya adalah barang dengan harga lebih tinggi mungkin memerlukan perhatian lebih dalam pengelolaan investasi atau memiliki dampak finansial yang lebih besar jika terjadi kekurangan stok.

#### Matriks Perbandingan Berpasangan (Contoh)

Berikut adalah contoh matriks perbandingan berpasangan yang digunakan untuk mendapatkan bobot kriteria di atas:

| Kriteria | Stok   | Harga |
| :------- | :----- | :---- |
| Stok     | 1      | 3     |
| Harga    | 1/3    | 1     |

Dari matriks ini, setelah dinormalisasi dan dihitung nilai eigennya, didapatkan bobot kriteria seperti yang disebutkan di atas.

### 3. Cara Mengakses Fitur Prioritas Stok AHP

Fitur prioritas stok AHP dapat diakses melalui panel admin:

1.  Login sebagai **Admin**.
2.  Pada sidebar navigasi di sebelah kiri, klik menu **"Prioritas Stok (AHP)"**.
3.  Anda juga dapat mengaksesnya melalui tombol **"Lihat Prioritas AHP"** yang tersedia di halaman Dashboard Admin.

### 4. Interpretasi Hasil

Halaman prioritas stok AHP akan menampilkan tabel dengan kolom-kolom berikut:

*   **Peringkat**: Urutan prioritas barang, dari yang paling tinggi ke paling rendah.
*   **Nama Barang**: Nama produk.
*   **Stok Saat Ini**: Jumlah stok produk yang tersedia.
*   **Harga Satuan**: Harga jual per unit produk.
*   **Skor AHP**: Nilai numerik hasil perhitungan AHP. Semakin tinggi skor, semakin tinggi prioritasnya.
*   **Status Prioritas**: Label kualitatif berdasarkan rentang skor AHP:
    *   **Sangat Tinggi**: Skor >= 0.7
    *   **Tinggi**: Skor >= 0.5
    *   **Sedang**: Skor >= 0.3
    *   **Rendah**: Skor < 0.3

Barang dengan status prioritas **Sangat Tinggi** atau **Tinggi** adalah yang paling direkomendasikan untuk segera dipertimbangkan pengadaan stoknya.

### 5. Detail Teknis (Untuk Pengembang)

#### `AHPService.php`

Logika perhitungan AHP diimplementasikan dalam `app/Services/AHPService.php`. Kelas ini bertanggung jawab untuk:

*   Mendefinisikan bobot kriteria (`$weights`).
*   Mengambil semua produk dari database.
*   Melakukan normalisasi nilai stok (sebagai kriteria *cost*) dan harga (sebagai kriteria *benefit*).
*   Menghitung skor akhir untuk setiap produk berdasarkan bobot kriteria.
*   Menentukan label prioritas (`Sangat Tinggi`, `Tinggi`, `Sedang`, `Rendah`) berdasarkan skor akhir.

#### `AHPController.php`

Controller ini (`app/Http/Controllers/AHPController.php`) menangani permintaan untuk halaman prioritas AHP. Ia menginjeksikan `AHPService` dan memanggil metode `calculatePriorities()` untuk mendapatkan data yang kemudian diteruskan ke view `ahp.index`.

#### `routes/web.php`

Route untuk fitur ini didefinisikan di `routes/web.php` sebagai berikut:

```php
Route::middleware([\"auth\", \"role:admin\"])->prefix(\"admin\")->group(function () {
    // ... rute admin lainnya ...
    Route::get(\"ahp-priority\", [\App\Http\Controllers\AHPController::class, \"index\"])->name(\"ahp.index\");
});
```

#### `resources/views/ahp/index.blade.php`

File ini adalah tampilan Blade yang menampilkan hasil perhitungan AHP dalam bentuk tabel yang mudah dibaca.

#### `resources/views/layouts/sidebar.blade.php`

Menu navigasi untuk fitur AHP telah ditambahkan ke sidebar admin untuk memudahkan akses.
