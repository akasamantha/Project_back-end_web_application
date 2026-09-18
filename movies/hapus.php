<?php
require_once __DIR__ . '/../config/bootstrap.php'; require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php'); verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) { $statement = $pdo->prepare('DELETE FROM movies WHERE id = ?'); $statement->execute([$id]); flash('success', 'Film berhasil dihapus.'); }
redirect('index.php');
