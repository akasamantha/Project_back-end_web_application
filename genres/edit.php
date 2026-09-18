<?php
require_once __DIR__ . '/../config/bootstrap.php';
require_login();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) redirect('index.php');
$statement = $pdo->prepare('SELECT id, name FROM genres WHERE id = ?'); $statement->execute([$id]); $genre = $statement->fetch();
if (!$genre) { flash('danger', 'Genre tidak ditemukan.'); redirect('index.php'); }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = clean_string($_POST['name'] ?? null);
    if ($name === '' || strlen($name) > 100) $errors[] = 'Nama genre wajib diisi dan maksimal 100 karakter.';
    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM genres WHERE name = ? AND id <> ? LIMIT 1'); $check->execute([$name, $id]);
        if ($check->fetch()) $errors[] = 'Genre tersebut sudah ada.';
        else { $update = $pdo->prepare('UPDATE genres SET name = ? WHERE id = ?'); $update->execute([$name, $id]); flash('success', 'Genre berhasil diubah.'); redirect('index.php'); }
    }
    $genre['name'] = $name;
}
$pageTitle = 'Edit Genre'; require __DIR__ . '/../partials/header.php';
?>
<h1 class="h3 mb-3">Edit Genre</h1>
<?php foreach ($errors as $error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="bg-white border rounded p-4 col-md-6"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="mb-3"><label class="form-label" for="name">Nama genre</label><input class="form-control" id="name" name="name" value="<?= e($genre['name']) ?>" required maxlength="100"></div><button class="btn btn-primary">Simpan</button> <a class="btn btn-secondary" href="index.php">Batal</a></form>
<?php require __DIR__ . '/../partials/footer.php'; ?>
