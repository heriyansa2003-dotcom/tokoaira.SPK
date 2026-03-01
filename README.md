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
