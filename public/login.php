<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$message = '';
$status = $_GET['status'] ?? '';

if ($status === 'error') {
    $message = $_GET['message'] ?? 'Terjadi kesalahan.';
} else if ($status === 'registered_success') {
    $message = 'Registrasi berhasil! Silakan login.';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Inventaris</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($message): ?>
            <p class="message <?php echo $status; ?>"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="../app/actions/login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>