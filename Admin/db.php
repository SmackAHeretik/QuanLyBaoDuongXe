<?php
function connectDB()
{
    $host = 'localhost';
    $dbname = 'quanlybaoduongxe';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Kết nối thất bại: " . $e->getMessage());
    }
}
?>