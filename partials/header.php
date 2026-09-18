<?php
$pageTitle = $pageTitle ?? 'Sistem Manajemen Film';
$flashMessage = get_flash();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | Manajemen Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/manajemen_film/index.php">Manajemen Film</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/manajemen_film/movies/index.php">Film</a></li>
                    <li class="nav-item"><a class="nav-link" href="/manajemen_film/genres/index.php">Genre</a></li>
                    <li class="nav-item"><a class="nav-link" href="/manajemen_film/users/index.php">Pengguna</a></li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <?php if (!empty($_SESSION['user'])): ?>
                    <span class="text-white small">Halo, <?= e($_SESSION['user']['name']) ?></span>
                    <a class="btn btn-outline-light btn-sm" href="/manajemen_film/auth/logout.php">Logout</a>
                <?php else: ?>
                    <a class="btn btn-outline-light btn-sm" href="/manajemen_film/auth/login.php">Login</a>
                    <a class="btn btn-warning btn-sm" href="/manajemen_film/auth/register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main class="container pb-5">
    <?php if ($flashMessage): ?>
        <div class="alert alert-<?= e($flashMessage['type']) ?> alert-dismissible fade show" role="alert">
            <?= e($flashMessage['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
