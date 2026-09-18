<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../vendor/autoload.php';

function send_registration_email(string $recipientEmail, string $recipientName): bool
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME') ?: 'isi-email-anda@example.com';
        $mail->Password = getenv('SMTP_PASSWORD') ?: 'isi-app-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) (getenv('SMTP_PORT') ?: 587);
        $mail->setFrom($mail->Username, 'Sistem Manajemen Film');
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->isHTML(true);
        $mail->Subject = 'Registrasi berhasil';
        $mail->Body = '<p>Halo ' . htmlspecialchars($recipientName, ENT_QUOTES, 'UTF-8') . ', akun Anda berhasil dibuat.</p>';
        return $mail->send();
    } catch (Exception $exception) {
        error_log('PHPMailer: ' . $mail->ErrorInfo);
        return false;
    }
}
