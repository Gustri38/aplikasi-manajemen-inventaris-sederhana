<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk menambah produk. Silakan login sebagai admin."));
    exit();
}

$old_name = $_GET['name'] ?? '';
$old_kode_aset = $_GET['kode_aset'] ?? '';
$old_location = $_GET['location'] ?? '';
$old_responsible_person_name = $_GET['responsible_person_name'] ?? '';
$old_description = $_GET['description'] ?? '';

$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2 class="project-title">Proyek Aplikasi Inventaris Sederhana</h2>
        <h1>Tambah Produk Baru</h1>
        <a href="index.php" class="button back">Kembali ke Daftar Produk</a>

        <?php if ($status === 'error'): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="../app/actions/create.php" method="POST">
            <label for="name">Nama Barang:</label>
            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($old_name); ?>">

            <label for="kode_aset">Kode Aset:</label>
            <input type="text" id="kode_aset" name="kode_aset" required value="<?php echo htmlspecialchars($old_kode_aset); ?>">

            <label for="location">Lokasi:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($old_location); ?>">

            <label for="responsible_person_name">Penanggung Jawab:</label>
            <input type="text" id="responsible_person_name" name="responsible_person_name" value="<?php echo htmlspecialchars($old_responsible_person_name); ?>">

            <label for="description">Deskripsi:</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($old_description); ?></textarea>

            <button type="submit" class="button">Tambahkan Produk</button>
        </form>
    </div>
</body>
</html>