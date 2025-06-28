# SIMS (Sistem Informasi Manajemen Siswa)

Sistem ini adalah aplikasi manajemen siswa berbasis web yang dibangun menggunakan Laravel 8.

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini dari awal:

### 1. Clone Repository dari GitHub

```
git clone https://github.com/mfahmialif/sims-laravel.git
cd sims-laravel
```

Ganti `https://github.com/mfahmialif/sims-laravel.git` dengan URL repository GitHub Anda.

### 2. Generate Application Key

```
php artisan key:generate
```

### 3. Install Dependency Composer

Pastikan Composer sudah terinstall, lalu jalankan:

```
composer install
```

### 4. Jalankan Migrasi Database

```
php artisan migrate
```

### 5. Jalankan Server Lokal

```
php artisan serve
```

Aplikasi dapat diakses melalui `http://localhost:8000`.

---

## Dokumentasi Tambahan

- [Laravel 8 Documentation](https://laravel.com/docs/8.x)
- [Composer](https://getcomposer.org/)

---

Jika mengalami kendala, silakan buat issue di repository ini atau hubungi pengelola proyek.
