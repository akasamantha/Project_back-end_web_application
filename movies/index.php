<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
$movies = $pdo->query('SELECT movies.id, movies.title, movies.director, movies.release_year, genres.name AS genre_name FROM movies JOIN genres ON genres.id = movies.genre_id ORDER BY movies.created_at DESC')->fetchAll();
$pageTitle = 'Data Film'; require __DIR__ . '/../partials/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Data Film</h1><a class="btn btn-primary" href="tambah.php">Tambah Film</a></div>
<div class="table-responsive bg-white border rounded"><table class="table table-striped mb-0"><thead><tr><th>#</th><th>Judul</th><th>Sutradara</th><th>Tahun</th><th>Genre</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($movies as $number => $movie): ?><tr><td><?= $number + 1 ?></td><td><?= e($movie['title']) ?></td><td><?= e($movie['director']) ?></td><td><?= (int) $movie['release_year'] ?></td><td><?= e($movie['genre_name']) ?></td><td><a class="btn btn-sm btn-warning" href="edit.php?id=<?= (int) $movie['id'] ?>">Edit</a> <form class="d-inline" method="post" action="hapus.php" onsubmit="return confirm('Hapus film ini?')"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $movie['id'] ?>"><button class="btn btn-sm btn-danger">Hapus</button></form></td></tr><?php endforeach; ?>
<?php if (!$movies): ?><tr><td colspan="6" class="text-center">Belum ada film.</td></tr><?php endif; ?></tbody></table></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
