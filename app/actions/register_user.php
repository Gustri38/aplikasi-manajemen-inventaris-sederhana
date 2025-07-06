<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../User.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../public/login.php?status=unauthorized&message=' . urlencode("Anda tidak memiliki akses untuk mendaftarkan pengguna. Silakan login sebagai admin."));
    exit();
}

$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user'; 

    if (empty($username) || empty($password) || empty($role)) {
        header('Location: ../../public/register_user.php?status=error&message=' . urlencode("Username, password, dan peran tidak boleh kosong.") . '&username=' . urlencode($username) . '&role=' . urlencode($role));
        exit();
    }

    if (!in_array($role, ['admin', 'user'])) {
        header('Location: ../../public/register_user.php?status=error&message=' . urlencode("Peran yang dipilih tidak valid.") . '&username=' . urlencode($username) . '&role=' . urlencode($role));
        exit();
    }

    try {
        if ($userModel->findByUsername($username)) {
            header('Location: ../../public/register_user.php?status=error&message=' . urlencode("Username sudah ada, silakan gunakan username lain.") . '&username=' . urlencode($username) . '&role=' . urlencode($role));
            exit();
        }

        if ($userModel->create($username, $password, $role)) {
            header('Location: ../../public/register_user.php?status=success&username=' . urlencode($username));
            exit();
        } else {
            header('Location: ../../public/register_user.php?status=error&message=' . urlencode("Gagal mendaftarkan pengguna baru.") . '&username=' . urlencode($username) . '&role=' . urlencode($role));
            exit();
        }
    } catch (PDOException $e) {
        $errorMessage = "Error database: " . $e->getMessage();
        if ($e->getCode() == 23000) {
            $errorMessage = "Username sudah ada, silakan gunakan username lain.";
        }
        header('Location: ../../public/register_user.php?status=error&message=' . urlencode($errorMessage) . '&username=' . urlencode($username) . '&role=' . urlencode($role));
        exit();
    }
} else {
    header('Location: ../../public/register_user.php');
    exit();
}
?>