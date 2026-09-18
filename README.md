# Sistem Manajemen Film

Aplikasi back-end PHP native untuk mengelola film dan genre. Teknologi: PHP 8+, MySQL, XAMPP, PDO, Bootstrap 5 CDN, Composer, PHPMailer, dan Git.

## Persiapan

1. Install XAMPP, PHP 8+, Composer, Git, dan VS Code.
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka `http://localhost/phpmyadmin`.
4. Klik **New** di panel kiri, masukkan `film_management`, lalu klik **Create**.
5. Pilih database tersebut, klik tab **Import**, pilih file `database.sql`, klik **Import** atau **Go**. File ini membuat tabel `users`, `genres`, dan `movies` serta relasi foreign key.
6. Buka terminal pada folder project dan jalankan `composer install`.
7. Buka `http://localhost/manajemen_film/`.

Alternatif phpMyAdmin: pilih database `film_management`, klik tab **SQL**, buka file `database.sql`, salin seluruh isinya ke kotak SQL, lalu klik **Go**.

## Konfigurasi

Kredensial MySQL XAMPP standar ada di `config/database.php`: user `root` tanpa password. Ubah jika konfigurasi lokal Anda berbeda.

PHPMailer dipasang dengan:

```bash
composer require phpmailer/phpmailer
```

Konfigurasi SMTP dibaca dari environment variable `SMTP_HOST`, `SMTP_PORT`, `SMTP_USERNAME`, dan `SMTP_PASSWORD`. Isi dengan email dan **App Password** milik sendiri, bukan password utama email. Jangan commit rahasia ke GitHub. Contoh Windows PowerShell:

```powershell
$env:SMTP_USERNAME="email-anda@gmail.com"
$env:SMTP_PASSWORD="app-password-email"
```

Tanpa SMTP yang benar, registrasi tetap tersimpan dan kegagalan email dicatat ke log PHP.

## Validasi dan keamanan

- Semua query database menggunakan PDO prepared statement sehingga input tidak digabung langsung ke SQL dan risiko SQL Injection berkurang.
- Input teks dipangkas, tag HTML dibuang, lalu divalidasi berdasarkan panjang dan tipe data.
- Output database memakai `htmlspecialchars()` melalui helper `e()` untuk mencegah script user dieksekusi sebagai HTML (XSS).
- Form POST dilindungi token CSRF.
- Password disimpan dengan `password_hash()` dan diverifikasi dengan `password_verify()`. Hash password bukan encryption: hash bersifat satu arah, sedangkan encryption dapat dibuka kembali dengan kunci.
- Contoh enkripsi dasar tersedia pada `encrypt_text()` dan `decrypt_text()` menggunakan AES-256-CBC untuk referensi registrasi session. Kunci produksi sebaiknya disimpan di environment variable `FILM_APP_KEY`.

## Git dan GitHub

```bash
git init
git add .
git commit -m "Initial sistem manajemen film"
git branch -M main
git remote add origin https://github.com/USERNAME/manajemen_film.git
git push -u origin main
```

Buat repository kosong di GitHub terlebih dahulu. Untuk kolaborasi, anggota dapat memakai `git clone`, membuat branch fitur, melakukan commit, lalu mengirim Pull Request. File `.gitignore` mencegah folder `vendor`, `.env`, dan log ikut terunggah.

## Checklist tugas

- CPMK091: database relational tiga tabel dan CRUD genre/film.
- CPMK093: input, validasi, sanitasi, PDO prepared statement, CSRF, dan escaping XSS.
- CPMK103: PHPMailer sebagai library eksternal melalui Composer.
- CPMK104: repository Git, commit, remote GitHub, branch, dan Pull Request.
