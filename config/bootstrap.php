<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/security.php';

function redirect(string $location): never
{
    header("Location: {$location}");
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $message;
}
