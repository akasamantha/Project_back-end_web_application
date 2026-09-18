<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
$genres = $pdo->query('SELECT id, name, created_at FROM genres ORDER BY name')->fetchAll();
$pageTitle = 'Data Genre';
require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Data Genre</h1><a class="btn btn-primary" href="tambah.php">Tambah Genre</a></div>
<div class="table-responsive bg-white border rounded"><table class="table table-striped mb-0"><thead><tr><th>#</th><th>Nama</th><th>Dibuat</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($genres as $number => $genre): ?><tr><td><?= $number + 1 ?></td><td><?= e($genre['name']) ?></td><td><?= e($genre['created_at']) ?></td><td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= (int) $genre['id'] ?>">Edit</a> <form class="d-inline" method="post" action="hapus.php" onsubmit="return confirm('Hapus genre ini?')"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $genre['id'] ?>"><button class="btn btn-sm btn-danger" type="submit">Hapus</button></form></td></tr><?php endforeach; ?>
<?php if (!$genres): ?><tr><td colspan="4" class="text-center">Belum ada genre.</td></tr><?php endif; ?></tbody></table></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
