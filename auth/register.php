<?php
require_once __DIR__ . '/../config/bootstrap.php';

if (!empty($_SESSION['user'])) {
    redirect('/manajemen_film/index.php');
}

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = clean_string($_POST['name'] ?? null);
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($name === '' || strlen($name) < 2 || strlen($name) > 100) {
        $errors[] = 'Nama wajib diisi (2-100 karakter).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak memiliki format yang valid.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter.';
    }

    if (!$errors) {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $check->execute([$email]);
        if ($check->fetch()) {
            $errors[] = 'Email sudah terdaftar.';
        } else {
            $statement = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $statement->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            require_once __DIR__ . '/../mail/mailer.php';
            send_registration_email($email, $name);
            $_SESSION['registration_reference'] = encrypt_text($email);
            flash('success', 'Registrasi berhasil. Silakan login.');
            redirect('/manajemen_film/auth/login.php');
        }
    }
}

$pageTitle = 'Register';
require __DIR__ . '/../partials/header.php';
?>
<div class="row justify-content-center"><div class="col-md-6 col-lg-5">
<div class="card"><div class="card-body">
<h1 class="h3 mb-3">Register</h1>
<?php foreach ($errors as $error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" novalidate>
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="mb-3"><label class="form-label" for="name">Nama</label><input class="form-control" id="name" name="name" value="<?= e($name) ?>" required maxlength="100"></div>
<div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" type="email" name="email" value="<?= e($email) ?>" required maxlength="150"></div>
<div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" id="password" type="password" name="password" required minlength="8"></div>
<button class="btn btn-primary" type="submit">Daftar</button>
<a class="btn btn-link" href="login.php">Sudah punya akun?</a>
</form></div></div></div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
