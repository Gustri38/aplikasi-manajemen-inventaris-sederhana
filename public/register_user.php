<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk mendaftarkan pengguna. Silakan login sebagai admin."));
    exit();
}

$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';

$old_username = $_GET['username'] ?? '';
$old_role = $_GET['role'] ?? 'user';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Pengguna Baru</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2 class="project-title">Proyek Aplikasi Inventaris Sederhana</h2>
        <h1>Daftarkan Pengguna Baru</h1>
        <a href="index.php" class="button back">Kembali ke Daftar Produk</a>

        <?php
        if ($status === 'error'): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php elseif ($status === 'success'): ?>
            <p style="color: green;">Pengguna **<?php echo htmlspecialchars($old_username); ?>** berhasil didaftarkan!</p>
        <?php endif; ?>

        <form action="../app/actions/register_user.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($old_username); ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Peran (Role):</label>
            <select id="role" name="role" required>
                <option value="user" <?php echo ($old_role === 'user' ? 'selected' : ''); ?>>User</option>
                <option value="admin" <?php echo ($old_role === 'admin' ? 'selected' : ''); ?>>Admin</option>
            </select>

            <button type="submit" class="button">Daftarkan Pengguna</button>
        </form>
    </div>
</body>
</html>