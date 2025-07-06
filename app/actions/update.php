<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Product.php';

// Autorisasi: Hanya admin yang bisa memperbarui produk
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $old_kode_aset = $_POST['old_kode_aset'] ?? 'unknown';
    header('Location: ../../public/login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk memperbarui produk. Silakan login sebagai admin."));
    exit();
}

$productModel = new Product($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_kode_aset = $_POST['old_kode_aset'] ?? null;
    $name = $_POST['name'] ?? '';
    $new_kode_aset = $_POST['kode_aset'] ?? ''; 
    $location = $_POST['location'] ?? '';
    $responsible_person_name = $_POST['responsible_person_name'] ?? '';
    $description = $_POST['description'] ?? '';

    if (empty($name) || empty($new_kode_aset) || !$old_kode_aset) {
        header('Location: ../../public/edit.php?kode_aset=' . urlencode($old_kode_aset) . '&status=error&message=' . urlencode("Nama, Kode Aset baru, dan Kode Aset lama tidak boleh kosong.") . '&name=' . urlencode($name) . '&kode_aset_form=' . urlencode($new_kode_aset) . '&location=' . urlencode($location) . '&responsible_person_name_form=' . urlencode($responsible_person_name) . '&description=' . urlencode($description));
        exit();
    }

    try {
        if ($productModel->update($old_kode_aset, $name, $new_kode_aset, $location, $responsible_person_name, $description)) {
            header('Location: ../../public/index.php?status=updated');
            exit();
        } else {
            header('Location: ../../public/edit.php?kode_aset=' . urlencode($old_kode_aset) . '&status=error&message=' . urlencode("Gagal memperbarui produk.") . '&name=' . urlencode($name) . '&kode_aset_form=' . urlencode($new_kode_aset) . '&location=' . urlencode($location) . '&responsible_person_name_form=' . urlencode($responsible_person_name) . '&description=' . urlencode($description));
            exit();
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
        if ($e->getCode() == 23000) {
            $errorMessage = "Kode Aset produk sudah ada, masukkan Kode Aset yang berbeda.";
        }
        header('Location: ../../public/edit.php?kode_aset=' . urlencode($old_kode_aset) . '&status=error&message=' . urlencode($errorMessage) . '&name=' . urlencode($name) . '&kode_aset_form=' . urlencode($new_kode_aset) . '&location=' . urlencode($location) . '&responsible_person_name_form=' . urlencode($responsible_person_name) . '&description=' . urlencode($description));
        exit();
    }
} else {
    header('Location: ../../public/index.php');
    exit();
}
?>