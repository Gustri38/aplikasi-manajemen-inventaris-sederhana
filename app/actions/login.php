<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../User.php';

$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $userModel->findByUsername($username);

    if ($user && $userModel->verifyPassword($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];

        header('Location: ../../public/index.php?status=login_success');
        exit();
    } else {
        header('Location: ../../public/login.php?status=error&message=' . urlencode("Username atau password salah."));
        exit();
    }
} else {
    header('Location: ../../public/login.php');
    exit();
}
?>