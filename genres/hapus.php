<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    try { $statement = $pdo->prepare('DELETE FROM genres WHERE id = ?'); $statement->execute([$id]); flash('success', 'Genre berhasil dihapus.'); }
    catch (PDOException $exception) { flash('danger', 'Genre tidak dapat dihapus karena masih digunakan oleh film.'); }
}
redirect('index.php');
