<?php
require_once __DIR__ . '/../config/bootstrap.php';

if (!empty($_SESSION['user'])) {
    redirect('/manajemen_film/index.php');
}

$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Email dan password wajib diisi dengan benar.';
    } else {
        $statement = $pdo->prepare('SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1');
        $statement->execute([$email]);
        $user = $statement->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            unset($user['password']);
            $_SESSION['user'] = $user;
            redirect('/manajemen_film/index.php');
        }
        $error = 'Email atau password salah.';
    }
}

$pageTitle = 'Login';
require __DIR__ . '/../partials/header.php';
?>
<div class="row justify-content-center"><div class="col-md-6 col-lg-5">
<div class="card"><div class="card-body">
<h1 class="h3 mb-3">Login</h1>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" type="email" name="email" value="<?= e($email) ?>" required></div>
<div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" id="password" type="password" name="password" required></div>
<button class="btn btn-primary" type="submit">Login</button>
<a class="btn btn-link" href="register.php">Buat akun</a>
</form></div></div></div></div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
