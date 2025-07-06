<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $original_kode_aset_from_url_for_redirect = $_GET['kode_aset'] ?? 'unknown';
    header('Location: login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk mengedit produk. Silakan login sebagai admin.") . '&redirect_to=' . urlencode('edit.php?kode_aset=' . $original_kode_aset_from_url_for_redirect));
    exit();
}

$product = null;
$error_message = $_GET['message'] ?? ''; 

$old_name_form = $_GET['name'] ?? null;
$old_kode_aset_form = $_GET['kode_aset_form'] ?? null;
$old_location_form = $_GET['location'] ?? null;
$old_responsible_person_name_form = $_GET['responsible_person_name_form'] ?? null;
$old_description_form = $_GET['description'] ?? null;
$original_kode_aset_from_url = $_GET['kode_aset'] ?? null;

if ($original_kode_aset_from_url) {
    $_GET['kode_aset'] = $original_kode_aset_from_url;
    unset($_GET['kode_aset']); 
}


$display_name = $old_name_form ?? ($product['name'] ?? '');
$display_kode_aset = $old_kode_aset_form ?? ($product['kode_aset'] ?? '');
$display_location = $old_location_form ?? ($product['location'] ?? '');
$display_responsible_person_name = $old_responsible_person_name_form ?? ($product['responsible_person_name'] ?? '');
$display_description = $old_description_form ?? ($product['description'] ?? '');

if (!$product && $original_kode_aset_from_url && empty($error_message)) {
    $error_message = "Produk tidak ditemukan.";
} elseif (!$original_kode_aset_from_url && empty($error_message)) {
    $error_message = "Kode Aset produk tidak disediakan untuk diedit.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2 class="project-title">Proyek Aplikasi Inventaris Sederhana</h2>
        <h1>Edit Produk</h1>
        <a href="index.php" class="button back">Kembali ke Daftar Produk</a>

        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <?php if ($original_kode_aset_from_url && $product): // Tampilkan form hanya jika produk ditemukan ?>
            <form action="../app/actions/update.php" method="POST">
                <input type="hidden" name="old_kode_aset" value="<?php echo htmlspecialchars($original_kode_aset_from_url); ?>">

                <label for="name">Nama Barang:</label>
                <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($display_name); ?>">

                <label for="kode_aset">Kode Aset:</label>
                <input type="text" id="kode_aset" name="kode_aset" required value="<?php echo htmlspecialchars($display_kode_aset); ?>">

                <label for="location">Lokasi:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($display_location); ?>">

                <label for="responsible_person_name">Penanggung Jawab:</label>
                <input type="text" id="responsible_person_name" name="responsible_person_name" value="<?php echo htmlspecialchars($display_responsible_person_name); ?>">

                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($display_description); ?></textarea>

                <button type="submit" class="button">Update Produk</button>
            </form>
        <?php elseif (!$original_kode_aset_from_url && empty($error_message)): ?>
            <p>Silakan pilih produk yang akan diedit dari daftar.</p>
        <?php endif; ?>
    </div>
</body>
</html>