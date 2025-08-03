<?php
session_start();
include './utils/ConnectDb.php';
require_once __DIR__ . '/controller/LichSuBaoHanhController.php';

// Kiểm tra đăng nhập kiểu mới (không cần sửa file profile.php cũ)
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['MaKH'])) {
    header('Location: login.php');
    exit;
}

$maKH = $_SESSION['user']['MaKH'];

// Kết nối PDO
$pdo = (new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe"))->connect();
$controller = new LichSuBaoHanhController($pdo);
echo $controller->userHistory($maKH);
?>