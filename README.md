<h2 align="center">Laravel 12 + NativePHP Desktop</h2>

<div align="center" style="display: block; margin-bottom: 20px;">
  <a href="https://laravel.com/docs/12.x" style="text-decoration: none;" target="_blank"><img src="public/logo-laravel12.png" height="77" style="vertical-align: middle; margin-right: 5px;" alt="Laravel Logo"></a>
  &nbsp;&nbsp;&nbsp;
  <a href="https://nativephp.com/docs/desktop/2" style="text-decoration: none;" target="_blank"><img src="public/logo-nativephp.png" width="83" height="80" style="vertical-align: middle; border-radius: 12px;" alt="NativePHP Logo"></a>
</div>
<p></p>
<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🚀 Laravel NativePHP Desktop App

Aplikasi desktop modern yang dibangun dengan kekuatan **Laravel 12**, **NativePHP**, dan **HTMX**. Proyek ini mengintegrasikan fitur manajemen notifikasi otomatis dan antarmuka *Dark-First* yang responsif.

## ✨ Fitur Utama

* **Native Desktop Experience**: Berjalan sebagai aplikasi native di Windows/macOS/Linux menggunakan NativePHP.
* **Auto-Clean Notifications**: Pembersihan otomatis notifikasi lama berdasarkan preferensi user (3, 7, 14, atau 30 hari).
* **Background Scheduler**: Menggunakan *Child Process* NativePHP untuk menjalankan task scheduler tanpa memerlukan Cron Job eksternal.
* **Dark-First Interface**: Antarmuka default gelap yang cerdas dengan pencegahan *flicker/blink* saat aplikasi dimuat.
* **Reactive UI with HTMX**: Interaksi server-side yang mulus tanpa reload halaman penuh.
* **SQLite Powered**: Database lokal yang ringan dan cepat, ideal untuk aplikasi desktop.

## 🛠️ Tech Stack

- **Engine:** [PHP 8.4+]()
- **Framework:** [Laravel 12](https://laravel.com/docs/12.x)
- **Desktop Wrapper:** [NativePHP Desktop](https://nativephp.com/docs/desktop/2)
- **Frontend Interactivity:** [HTMX](https://htmx.org) & [Alpine.js](https://alpinejs.dev)
- **Styling:** [Tailwind CSS](https://tailwindcss.com)
- **Database:** SQLite 3


## 🚀 Instalasi

```bash 
composer install

npm install && npm run build

cp .env.example .env

php artisan key:generate

touch database/database.sqlite

php artisan migrate
```

## ⚙️ Jalankan Aplikasi (Mode Development)

```bash 
php artisan native:migrate

composer native:dev
```

## 📦 Build & Distribution
```bash 
php artisan native:build
```

