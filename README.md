# 🔐 OAuth2Discord

Implementasi **Discord OAuth2 Login** menggunakan PHP murni (tanpa framework). Proyek ini memungkinkan pengguna login ke website menggunakan akun Discord mereka, mengambil data profil (username, email, avatar), dan menyimpannya ke database MySQL.

---

## ✨ Fitur

- 🔑 Login via Discord OAuth2
- 👤 Ambil data profil pengguna (username, discriminator, email, avatar)
- 💾 Simpan data pengguna ke MySQL (dengan `ON DUPLICATE KEY UPDATE`)
- 🛡️ Menggunakan PDO Prepared Statements untuk keamanan database
- 🎨 Halaman login minimalis dengan tema gelap

---

## 📁 Struktur Proyek

```
OAuth2Discord/
├── index.php            # Halaman login (redirect ke Discord)
├── callback.php         # Callback handler (tukar code → token → data user)
├── config.php           # Konfigurasi OAuth2 (Client ID, Secret, dsb.)
├── db.php               # Koneksi database (PDO MySQL)
├── discord_users.sql    # SQL schema untuk tabel users
├── LICENSE              # MIT License
└── README.md            # Dokumentasi proyek
```

---

## ⚙️ Prasyarat

- **PHP** ≥ 7.4
- **MySQL** / MariaDB
- **Web Server** (Apache / Nginx) — atau gunakan [Laragon](https://laragon.org/) / XAMPP
- **Discord Developer Application** — [buat di sini](https://discord.com/developers/applications)

---

## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/username/OAuth2Discord.git
cd OAuth2Discord
```

### 2. Buat Discord Application

1. Buka [Discord Developer Portal](https://discord.com/developers/applications)
2. Klik **"New Application"** → beri nama aplikasi
3. Masuk ke menu **OAuth2** di sidebar
4. Salin **Client ID** dan **Client Secret**
5. Tambahkan **Redirect URL**, contoh:
   ```
   http://localhost/OAuth2Discord/callback.php
   ```

### 3. Konfigurasi `config.php`

Buka `config.php` dan isi dengan kredensial Discord kamu:

```php
<?php
$client_id     = 'YOUR_CLIENT_ID';
$client_secret = 'YOUR_CLIENT_SECRET';
$redirect_uri  = 'http://localhost/OAuth2Discord/callback.php';
$scopes        = 'identify email';
?>
```

### 4. Setup Database

Import file SQL ke MySQL:

```bash
mysql -u root -p < discord_users.sql
```

Atau jalankan secara manual melalui phpMyAdmin / HeidiSQL:

```sql
CREATE DATABASE IF NOT EXISTS `discord_login` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `discord_login`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `discord_id` VARCHAR(50) UNIQUE NOT NULL,
  `username` VARCHAR(100) NOT NULL,
  `discriminator` VARCHAR(10),
  `email` VARCHAR(150),
  `avatar` VARCHAR(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 5. Jalankan

Akses melalui browser:

```
http://localhost/OAuth2Discord/
```

Klik tombol **"Login with Discord"** dan izinkan akses.

---

## 🔄 Alur OAuth2

```
┌──────────┐     1. Redirect      ┌──────────────┐
│  User    │ ──────────────────►  │  Discord     │
│ (Browser)│                      │  Auth Page   │
└──────────┘                      └──────┬───────┘
                                         │
                                    2. Authorization Code
                                         │
                                         ▼
┌──────────┐     4. User Data     ┌──────────────┐
│ callback │ ◄────────────────── │  Discord API │
│   .php   │ ──────────────────► │  /oauth2/    │
└────┬─────┘  3. Exchange Code    │   token      │
     │           for Token        └──────────────┘
     │
     ▼
┌──────────┐
│  MySQL   │  5. Simpan/Update user
│ Database │
└──────────┘
```

---

## 🛡️ Keamanan

> ⚠️ **Penting untuk production:**

- **Jangan commit** `config.php` yang berisi kredensial asli ke repository publik.
- Tambahkan `config.php` ke `.gitignore`:
  ```
  config.php
  ```
- Gunakan **environment variables** atau file `.env` untuk menyimpan secret di production.
- Aktifkan **HTTPS** untuk melindungi token saat transit.
- Tambahkan parameter `state` pada OAuth2 flow untuk mencegah serangan **CSRF**.

---

## 📖 Referensi

- [Discord OAuth2 Documentation](https://discord.com/developers/docs/topics/oauth2)
- [Discord Developer Portal](https://discord.com/developers/applications)
- [PHP PDO Documentation](https://www.php.net/manual/en/book.pdo.php)

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
