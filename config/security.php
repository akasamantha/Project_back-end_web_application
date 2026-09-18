<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function clean_string(?string $value): string
{
    return trim(strip_tags($value ?? ''));
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Token keamanan tidak valid. Silakan kembali dan coba lagi.');
    }
}

function require_login(): void
{
    if (empty($_SESSION['user'])) {
        header('Location: /manajemen_film/auth/login.php');
        exit;
    }
}

function encrypt_text(string $plainText): string
{
    $key = hash('sha256', getenv('FILM_APP_KEY') ?: 'ganti-kunci-aplikasi-ini', true);
    $iv = random_bytes(16);
    $ciphertext = openssl_encrypt($plainText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $ciphertext);
}

function decrypt_text(string $encryptedText): string
{
    $decoded = base64_decode($encryptedText, true);
    if ($decoded === false || strlen($decoded) < 17) {
        return '';
    }

    $key = hash('sha256', getenv('FILM_APP_KEY') ?: 'ganti-kunci-aplikasi-ini', true);
    $iv = substr($decoded, 0, 16);
    $ciphertext = substr($decoded, 16);
    $plainText = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

    return is_string($plainText) ? $plainText : '';
}
