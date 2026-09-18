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
PHPMailer digunakan untuk mengirim email konfirmasi setelah registrasi.

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
Repository Git lokal sudah digunakan untuk mencatat perubahan project. 
