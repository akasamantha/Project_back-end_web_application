<?php
require_once __DIR__ . '/../config/bootstrap.php'; require_login();
$genres = $pdo->query('SELECT id, name FROM genres ORDER BY name')->fetchAll();
$errors = []; $title = ''; $director = ''; $releaseYear = ''; $genreId = ''; $description = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title = clean_string($_POST['title'] ?? null); $director = clean_string($_POST['director'] ?? null); $releaseYear = filter_input(INPUT_POST, 'release_year', FILTER_VALIDATE_INT); $genreId = filter_input(INPUT_POST, 'genre_id', FILTER_VALIDATE_INT); $description = clean_string($_POST['description'] ?? null);
    $currentYear = (int) date('Y');
    if ($title === '' || strlen($title) > 200) $errors[] = 'Judul wajib diisi dan maksimal 200 karakter.';
    if ($director === '' || strlen($director) > 150) $errors[] = 'Sutradara wajib diisi dan maksimal 150 karakter.';
    if (!$releaseYear || $releaseYear < 1888 || $releaseYear > $currentYear) $errors[] = "Tahun rilis harus antara 1888 dan {$currentYear}.";
    if (!$genreId) $errors[] = 'Genre wajib dipilih.';
    if (!$errors) { $check = $pdo->prepare('SELECT id FROM genres WHERE id = ?'); $check->execute([$genreId]); if (!$check->fetch()) $errors[] = 'Genre tidak valid.'; }
    if (!$errors) { $statement = $pdo->prepare('INSERT INTO movies (title, director, release_year, genre_id, description) VALUES (?, ?, ?, ?, ?)'); $statement->execute([$title, $director, $releaseYear, $genreId, $description ?: null]); flash('success', 'Film berhasil ditambahkan.'); redirect('index.php'); }
}
$pageTitle = 'Tambah Film'; require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3">Tambah Film</h1><?php foreach ($errors as $error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="bg-white border rounded p-4"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="row"><div class="col-md-8 mb-3"><label class="form-label" for="title">Judul</label><input class="form-control" id="title" name="title" value="<?= e($title) ?>" required maxlength="200"></div><div class="col-md-4 mb-3"><label class="form-label" for="release_year">Tahun rilis</label><input class="form-control" id="release_year" type="number" name="release_year" value="<?= e((string) $releaseYear) ?>" min="1888" max="<?= date('Y') ?>" required></div></div><div class="row"><div class="col-md-6 mb-3"><label class="form-label" for="director">Sutradara</label><input class="form-control" id="director" name="director" value="<?= e($director) ?>" required maxlength="150"></div><div class="col-md-6 mb-3"><label class="form-label" for="genre_id">Genre</label><select class="form-select" id="genre_id" name="genre_id" required><option value="">Pilih genre</option><?php foreach ($genres as $genre): ?><option value="<?= (int) $genre['id'] ?>" <?= (string) $genreId === (string) $genre['id'] ? 'selected' : '' ?>><?= e($genre['name']) ?></option><?php endforeach; ?></select></div></div><div class="mb-3"><label class="form-label" for="description">Deskripsi</label><textarea class="form-control" id="description" name="description" rows="4"><?= e($description) ?></textarea></div><button class="btn btn-primary">Simpan</button> <a class="btn btn-secondary" href="index.php">Batal</a></form>
<?php require __DIR__ . '/../partials/footer.php'; ?>
