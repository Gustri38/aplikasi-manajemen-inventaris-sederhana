<?php
session_start(); 

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Product.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../public/login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk menambah produk. Silakan login sebagai admin."));
    exit();
}

$productModel = new Product($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $kode_aset = $_POST['kode_aset'] ?? '';
    $location = $_POST['location'] ?? '';
    $responsible_person_name = $_POST['responsible_person_name'] ?? '';
    $description = $_POST['description'] ?? '';

    if (empty($name) || empty($kode_aset)) {
        header('Location: ../../public/create.php?status=error&message=' . urlencode("Nama dan Kode Aset tidak boleh kosong.") . '&name=' . urlencode($name) . '&kode_aset=' . urlencode($kode_aset) . '&location=' . urlencode($location) . '&responsible_person_name=' . urlencode($responsible_person_name) . '&description=' . urlencode($description));
        exit();
    }

    try {
        if ($productModel->create($name, $kode_aset, $location, $responsible_person_name, $description)) {
            header('Location: ../../public/index.php?status=created');
            exit();
        } else {
            header('Location: ../../public/create.php?status=error&message=' . urlencode("Gagal menambahkan produk.") . '&name=' . urlencode($name) . '&kode_aset=' . urlencode($kode_aset) . '&location=' . urlencode($location) . '&responsible_person_name=' . urlencode($responsible_person_name) . '&description=' . urlencode($description));
            exit();
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
        if ($e->getCode() == 23000) {
            $errorMessage = "Kode Aset produk sudah ada, masukkan Kode Aset yang berbeda.";
        }
        header('Location: ../../public/create.php?status=error&message=' . urlencode($errorMessage) . '&name=' . urlencode($name) . '&kode_aset=' . urlencode($kode_aset) . '&location=' . urlencode($location) . '&responsible_person_name=' . urlencode($responsible_person_name) . '&description=' . urlencode($description));
        exit();
    }
} else {
    header('Location: ../../public/create.php');
    exit();
}
?>