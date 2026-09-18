<?php
require_once __DIR__ . '/../config/bootstrap.php'; require_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); if (!$id) redirect('index.php');
$statement = $pdo->prepare('SELECT id, name, email FROM users WHERE id = ?'); $statement->execute([$id]); $user = $statement->fetch(); if (!$user) { flash('danger', 'Pengguna tidak ditemukan.'); redirect('index.php'); }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf(); $user['name'] = clean_string($_POST['name'] ?? null); $user['email'] = strtolower(trim($_POST['email'] ?? '')); $newPassword = $_POST['password'] ?? '';
    if ($user['name'] === '' || strlen($user['name']) < 2 || strlen($user['name']) > 100) $errors[] = 'Nama wajib diisi (2-100 karakter).';
    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if ($newPassword !== '' && strlen($newPassword) < 8) $errors[] = 'Password baru minimal 8 karakter.';
    if (!$errors) { $check = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id <> ? LIMIT 1'); $check->execute([$user['email'], $id]); if ($check->fetch()) $errors[] = 'Email sudah digunakan pengguna lain.'; }
    if (!$errors) { if ($newPassword !== '') { $update = $pdo->prepare('UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?'); $update->execute([$user['name'], $user['email'], password_hash($newPassword, PASSWORD_DEFAULT), $id]); } else { $update = $pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?'); $update->execute([$user['name'], $user['email'], $id]); } flash('success', 'Pengguna berhasil diubah.'); redirect('index.php'); }
}
$pageTitle = 'Edit Pengguna'; require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3">Edit Pengguna</h1><?php foreach ($errors as $error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="bg-white border rounded p-4 col-md-6"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="mb-3"><label class="form-label" for="name">Nama</label><input class="form-control" id="name" name="name" value="<?= e($user['name']) ?>" required maxlength="100"></div><div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" type="email" name="email" value="<?= e($user['email']) ?>" required maxlength="150"></div><div class="mb-3"><label class="form-label" for="password">Password baru (opsional)</label><input class="form-control" id="password" type="password" name="password" minlength="8"></div><button class="btn btn-primary">Simpan</button> <a class="btn btn-secondary" href="index.php">Batal</a></form>
<?php require __DIR__ . '/../partials/footer.php'; ?>
