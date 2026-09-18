<?php
require_once __DIR__ . '/config/bootstrap.php';
$pageTitle = 'Beranda';
require __DIR__ . '/partials/header.php';
?>
<div class="p-4 p-md-5 mb-4 bg-white border rounded-3">
    <h1 class="display-6">Sistem Manajemen Film</h1>
    <p class="lead">Kelola film dan genre dengan sederhana.</p>
    <?php if (!empty($_SESSION['user'])): ?>
        <a class="btn btn-primary" href="/manajemen_film/movies/index.php">Kelola Film</a>
        <a class="btn btn-outline-secondary" href="/manajemen_film/genres/index.php">Kelola Genre</a>
    <?php else: ?>
        <a class="btn btn-primary" href="/manajemen_film/auth/login.php">Masuk untuk mulai</a>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
