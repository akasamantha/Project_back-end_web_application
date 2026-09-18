<?php
require_once __DIR__ . '/../config/bootstrap.php'; require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php'); verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$currentUserId = (int) ($_SESSION['user']['id'] ?? 0);
if ($id && $id !== $currentUserId) { $statement = $pdo->prepare('DELETE FROM users WHERE id = ?'); $statement->execute([$id]); flash('success', 'Pengguna berhasil dihapus.'); }
elseif ($id === $currentUserId) { flash('warning', 'Akun yang sedang digunakan tidak dapat dihapus.'); }
redirect('index.php');
