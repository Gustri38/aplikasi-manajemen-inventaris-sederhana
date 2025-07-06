<?php
require_once __DIR__ . '/../../config/database.php'; // Menggunakan path relatif dari app/actions
require_once __DIR__ . '/../Product.php';

$productModel = new Product($pdo);

// Jika ada parameter 'kode_aset' di GET, kita akan membaca satu produk
if (isset($_GET['kode_aset'])) {
    $kode_aset = $_GET['kode_aset'];
    $product_data = $productModel->readOne($kode_aset);
    return $product_data; // Mengembalikan data satu produk
} else {
    // Jika tidak ada 'kode_aset', kita akan membaca semua produk
    $all_products_data = $productModel->readAll();
    return $all_products_data; // Mengembalikan array semua produk
}
?>