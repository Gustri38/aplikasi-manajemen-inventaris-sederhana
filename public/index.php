<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?status=error&message=' . urlencode("Anda harus login untuk mengakses halaman ini."));
    exit();
}

$products = require_once __DIR__ . '/../app/actions/read.php';

$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';

$is_logged_in = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? '';
$user_role = $_SESSION['user_role'] ?? ''; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Inventaris Kelompok 1 ...</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="../app/scripts/title.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="project-title">Aplikasi Inventaris Sederhana</h2>

        <div class="auth-status">
            <?php if ($is_logged_in): ?>
                <a href="logout.php" class="button back">Logout</a>
            <?php else: ?>
                <p>Anda belum login.</p>
                <a href="login.php" class="button">Login</a>
            <?php endif; ?>
        </div>

        <?php
        if ($status === 'created'): ?>
            <p style="color: green;">Produk berhasil ditambahkan!</p>
        <?php elseif ($status === 'updated'): ?>
            <p style="color: green;">Produk berhasil diperbarui!</p>
        <?php elseif ($status === 'deleted'): ?>
            <p style="color: green;">Produk berhasil dihapus!</p>
        <?php elseif ($status === 'error'): ?>
            <p style="color: red;">Error: <?php echo htmlspecialchars($message); ?></p>
        <?php elseif ($status === 'login_success'): ?>
            <p style="color: green;">Login berhasil! Selamat datang, <?php echo htmlspecialchars($username); ?>.</p>
        <?php endif; ?>

        <?php
        if ($is_logged_in && $user_role === 'admin'): ?>
            <a href="create.php" class="button">Tambah Produk Baru</a>
            <a href="register_user.php" class="button">Daftarkan Pengguna Baru</a>
        <?php else: ?>
            <p>Untuk menambah, mengedit, menghapus produk, atau mendaftarkan pengguna baru, silakan login sebagai Admin.</p>
        <?php endif; ?>

        <?php
        if (empty($products)): ?>
            <p>Belum ada produk di inventaris.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kode Aset</th>
                        <th>Lokasi</th>
                        <th>Penanggung Jawab</th>
                        <?php
                        if ($is_logged_in && $user_role === 'admin'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['kode_aset']); ?></td>
                        <td><?php echo htmlspecialchars($product['location']); ?></td>
                        <td><?php echo htmlspecialchars($product['responsible_person_name'] ?? 'N/A'); ?></td>
                        <?php
                        if ($is_logged_in && $user_role === 'admin'): ?>
                        <td>
                            <a href="edit.php?kode_aset=<?php echo htmlspecialchars($product['kode_aset']); ?>" class="button edit">Edit</a>
                            <form action="../app/actions/delete.php" method="POST" class = "inline-delete-form">
                                <input type="hidden" name="kode_aset" value="<?php echo htmlspecialchars($product['kode_aset']); ?>">
                                <a type="submit" class="button delete" onclick="return confirm('Yakin ingin menghapus produk ini?');">Hapus</a>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>