<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
include '../utils/ConnectDb.php';
include '../model/BikeProfileModel.php';

if (!isset($_SESSION['MaKH'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MaXe'])) {
    $db = (new ConnectDb())->connect();
    $bikeModel = new BikeProfileModel($db);

    $data = [
        'TenXe' => $_POST['TenXe'],
        'LoaiXe' => $_POST['LoaiXe'],
        'PhanKhuc' => $_POST['PhanKhuc'],
        'BienSoXe' => $_POST['BienSoXe'],
        'HinhAnhMatTruocXe' => $_POST['old_HinhAnhMatTruocXe'],
        'HinhAnhMatSauXe' => $_POST['old_HinhAnhMatSauXe'],
        'MaXe' => $_POST['MaXe']
    ];

    // Xử lý upload ảnh mới nếu có
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    if (isset($_FILES['HinhAnhMatTruocXe']) && $_FILES['HinhAnhMatTruocXe']['error'] == 0) {
        $fileName = uniqid() . '_' . basename($_FILES['HinhAnhMatTruocXe']['name']);
        move_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name'], $uploadDir . $fileName);
        $data['HinhAnhMatTruocXe'] = 'uploads/' . $fileName;
    }
    if (isset($_FILES['HinhAnhMatSauXe']) && $_FILES['HinhAnhMatSauXe']['error'] == 0) {
        $fileName = uniqid() . '_' . basename($_FILES['HinhAnhMatSauXe']['name']);
        move_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name'], $uploadDir . $fileName);
        $data['HinhAnhMatSauXe'] = 'uploads/' . $fileName;
    }

    // Chỉ cho user update các trường cho phép
    $bikeModel->updateBikeUser($data);
    header("Location: ../bike_list.php");
    exit();
}
header("Location: ../bike_list.php");
exit();