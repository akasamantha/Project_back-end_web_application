<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../vendor/autoload.php';

$mailConfigPath = __DIR__ . '/../config/mail.local.php';
$mailConfig = is_file($mailConfigPath) ? require $mailConfigPath : [];

function send_registration_email(string $recipientEmail, string $recipientName, array $movies = []): bool
{
    global $mailConfig;
    $mail = new PHPMailer(true);
    try {
        $smtpUsername = trim((string) ($mailConfig['username'] ?? getenv('SMTP_USERNAME') ?: ''));
        $smtpPassword = trim((string) ($mailConfig['password'] ?? getenv('SMTP_PASSWORD') ?: ''));
        $smtpPassword = str_replace([' ', "\t", "\r", "\n"], '', $smtpPassword);
        if ($smtpUsername === '' || $smtpPassword === '' || $smtpPassword === 'isi-google-app-password-di-sini') {
            error_log('PHPMailer: konfigurasi SMTP belum diisi pada config/mail.local.php.');
            return false;
        }

        $mail->isSMTP();
        $mail->Host = $mailConfig['host'] ?? getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) ($mailConfig['port'] ?? getenv('SMTP_PORT') ?: 587);
        $mail->setFrom($mail->Username, 'Sistem Manajemen Film');
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->isHTML(true);
        $mail->Subject = 'Registrasi berhasil - Daftar Film';

        $safeName = htmlspecialchars($recipientName, ENT_QUOTES, 'UTF-8');
        $movieRows = '';
        foreach ($movies as $movie) {
            $movieRows .= '<tr>';
            $movieRows .= '<td>' . htmlspecialchars((string) $movie['title'], ENT_QUOTES, 'UTF-8') . '</td>';
            $movieRows .= '<td>' . htmlspecialchars((string) $movie['director'], ENT_QUOTES, 'UTF-8') . '</td>';
            $movieRows .= '<td>' . (int) $movie['release_year'] . '</td>';
            $movieRows .= '<td>' . htmlspecialchars((string) $movie['genre_name'], ENT_QUOTES, 'UTF-8') . '</td>';
            $movieRows .= '</tr>';
        }

        $movieList = $movieRows !== ''
            ? '<table border="1" cellpadding="6" cellspacing="0"><thead><tr><th>Judul</th><th>Sutradara</th><th>Tahun</th><th>Genre</th></tr></thead><tbody>' . $movieRows . '</tbody></table>'
            : '<p>Belum ada film yang tersedia saat ini.</p>';

        $mail->Body = '<h2>Registrasi Berhasil</h2>'
            . '<p>Halo <b>' . $safeName . '</b>, akun Anda berhasil dibuat.</p>'
            . '<p>Berikut daftar film yang tersedia saat ini:</p>'
            . $movieList;
        $mail->AltBody = 'Halo ' . $recipientName . ", akun Anda berhasil dibuat. Daftar film tersedia dikirim dalam versi HTML.";
        return $mail->send();
    } catch (Exception $exception) {
        error_log('PHPMailer: ' . $mail->ErrorInfo);
        return false;
    }
}
