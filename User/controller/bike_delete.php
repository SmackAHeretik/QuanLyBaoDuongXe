<?php
session_start();
include '../utils/ConnectDb.php';
include '../model/BikeProfileModel.php';

if (!isset($_SESSION['MaKH'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MaXe'])) {
    $db = (new ConnectDb())->connect();
    $bikeModel = new BikeProfileModel($db);
    $bikeModel->deleteBike($_POST['MaXe']);
}

header("Location: ../bike_list.php");
exit();