# Sistem Manajemen Film

## Deskripsi

Sistem Manajemen Film adalah aplikasi back-end berbasis PHP yang digunakan untuk mengelola data film, genre, dan pengguna. Aplikasi ini dibuat dengan tampilan sederhana agar mudah digunakan, dipelajari, dan dipresentasikan.

Pengguna dapat membuat akun, login, mengelola genre, serta menambahkan dan mengelola data film. Setelah registrasi, sistem dapat mengirim email konfirmasi yang berisi daftar film menggunakan PHPMailer.

## Teknologi

- PHP
- MySQL dan phpMyAdmin
- XAMPP
- PDO
- Bootstrap 5 melalui CDN
- Composer
- PHPMailer
- Git dan GitHub

## Fitur Utama

### Autentikasi pengguna

- Register pengguna
- Login menggunakan session
- Logout
- Password disimpan dengan `password_hash()`
- Password diperiksa menggunakan `password_verify()`

### Manajemen pengguna

- Melihat daftar pengguna
- Mengubah nama, email, dan password
- Menghapus pengguna lain
- Akun yang sedang digunakan tidak dapat dihapus sendiri

### Manajemen genre

- Menampilkan daftar genre
- Menambah genre
- Mengedit genre
- Menghapus genre

### Manajemen film

- Menampilkan daftar film
- Menambah film
- Mengedit film
- Menghapus film
- Memilih genre melalui dropdown
- Menyimpan judul, sutradara, tahun rilis, dan deskripsi

## Relasi Database

Aplikasi menggunakan tiga tabel utama:

- `users`: menyimpan data akun pengguna.
- `genres`: menyimpan daftar genre film.
- `movies`: menyimpan data film.

Tabel `movies` memiliki foreign key `genre_id` yang terhubung ke `genres.id`. Relasi ini membuat setiap film memiliki genre yang valid.

## Keamanan

- PDO prepared statements digunakan untuk mengurangi risiko SQL Injection.
- Input dibersihkan dengan sanitasi dan divalidasi di server.
- Output ditampilkan menggunakan `htmlspecialchars()` untuk mencegah XSS.
- Form POST menggunakan CSRF token.
- Password menggunakan hashing satu arah dengan `password_hash()`.
- Enkripsi dasar AES-256-CBC tersedia untuk data yang memang perlu dienkripsi.

Hashing password berbeda dengan encryption. Hashing tidak dapat dikembalikan ke bentuk asli, sedangkan encryption dapat dibuka kembali menggunakan kunci.

## PHPMailer

PHPMailer digunakan untuk mengirim email konfirmasi setelah registrasi. Dependency dipasang dengan Composer:

```bash
composer install
```

Konfigurasi SMTP lokal berada di:

```text
config/mail.local.php
```

Isi file tersebut dengan email Gmail pengirim dan Google App Password:

```php
return [
	'host' => 'smtp.gmail.com',
	'port' => 587,
	'username' => 'email-anda@gmail.com',
	'password' => 'google-app-password',
];
```

Gunakan Google App Password, bukan password utama Gmail. File konfigurasi lokal sudah masuk `.gitignore` agar password tidak ikut diunggah ke GitHub.

## Cara Menjalankan

1. Install XAMPP, PHP 8+, Composer, Git, dan VS Code.
2. Salin folder project ke `C:\xampp\htdocs\manajemen_film`.
3. Jalankan Apache dan MySQL dari XAMPP.
4. Buka `http://localhost/phpmyadmin`.
5. Buat database bernama `film_management`.
6. Pilih database tersebut, klik tab **Import**, pilih file `database.sql`, lalu klik **Go**.
7. Jalankan `composer install` dari terminal pada folder project.
8. Isi konfigurasi SMTP jika fitur email ingin digunakan.
9. Buka `http://localhost/manajemen_film/`.

## Alur Penggunaan

1. Buka halaman register dan buat akun.
2. Login menggunakan email dan password yang telah dibuat.
3. Tambahkan beberapa genre melalui menu **Genre**.
4. Tambahkan film melalui menu **Film** dan pilih genre.
5. Gunakan tombol **Edit** atau **Hapus** untuk mengelola data.
6. Gunakan menu **Pengguna** untuk mengelola akun lain.
7. Logout setelah selesai menggunakan aplikasi.

## Struktur Folder

```text
manajemen_film/
├── auth/       # register, login, dan logout
├── config/     # koneksi database dan keamanan
├── genres/     # CRUD genre
├── movies/     # CRUD film
├── users/      # CRUD pengguna
├── mail/       # konfigurasi pengiriman email
├── partials/   # header dan footer bersama
├── database.sql
├── composer.json
└── index.php
```

## Git dan GitHub

Repository Git lokal sudah digunakan untuk mencatat perubahan project. Untuk menghubungkan project ke GitHub:

```bash
git init
git add .
git commit -m "Initial sistem manajemen film"
git branch -M main
git remote add origin https://github.com/akasamantha/Project_back-end_web_application.git
git push -u origin main
```

Repository ini dapat dikembangkan secara kolaboratif menggunakan branch dan Pull Request.

## Kesesuaian CPMK

- **CPMK091**: database relational, relasi foreign key, CRUD, PDO, dan keamanan dasar.
- **CPMK093**: input, validasi, sanitasi, CSRF, serta perlindungan XSS dan SQL Injection.
- **CPMK103**: penggunaan PHPMailer sebagai library eksternal melalui Composer.
- **CPMK104**: penggunaan Git, commit, branch, GitHub, dan Pull Request untuk kolaborasi.
