<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Product.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../public/login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk menghapus produk. Silakan login sebagai admin."));
    exit();
}

$productModel = new Product($pdo);
$kode_aset = $_POST['kode_aset'] ?? null;

if ($kode_aset) {
    try {
        if ($productModel->delete($kode_aset)) {
            header('Location: ../../public/index.php?status=deleted');
            exit();
        } else {
            header('Location: ../../public/index.php?status=error&message=' . urlencode("Gagal menghapus produk."));
            exit();
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
        header('Location: ../../public/index.php?status=error&message=' . urlencode($errorMessage));
        exit();
    }
} else {
    header('Location: ../../public/index.php?status=error&message=' . urlencode("Kode Aset produk tidak disediakan untuk dihapus."));
    exit();
}
?>