<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
$users = $pdo->query('SELECT id, name, email, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Data Pengguna'; require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Data Pengguna</h1><a class="btn btn-primary" href="../auth/register.php">Tambah Pengguna</a></div>
<div class="table-responsive bg-white border rounded"><table class="table table-striped mb-0"><thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Dibuat</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($users as $number => $user): ?><tr><td><?= $number + 1 ?></td><td><?= e($user['name']) ?></td><td><?= e($user['email']) ?></td><td><?= e($user['created_at']) ?></td><td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= (int) $user['id'] ?>">Edit</a> <form class="d-inline" method="post" action="hapus.php" onsubmit="return confirm('Hapus pengguna ini?')"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $user['id'] ?>"><button class="btn btn-sm btn-danger" type="submit">Hapus</button></form></td></tr><?php endforeach; ?>
<?php if (!$users): ?><tr><td colspan="5" class="text-center">Belum ada pengguna.</td></tr><?php endif; ?></tbody></table></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
