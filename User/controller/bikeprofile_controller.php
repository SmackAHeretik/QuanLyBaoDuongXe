<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
include_once '../utils/ConnectDb.php';
include_once '../model/BikeProfileModel.php';

if (!isset($_SESSION['MaKH'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_bike'])) {
    $TenXe = $_POST['TenXe'];
    $LoaiXe = $_POST['LoaiXe'];
    $PhanKhuc = $_POST['PhanKhuc'];
    $BienSoXe = $_POST['BienSoXe'];
    // Nếu rỗng thì để NULL
    $SoKhung = isset($_POST['SoKhung']) && trim($_POST['SoKhung']) !== '' ? trim($_POST['SoKhung']) : null;
    $SoMay = isset($_POST['SoMay']) && trim($_POST['SoMay']) !== '' ? trim($_POST['SoMay']) : null;
    $khachhang_MaKH = $_SESSION['MaKH'];

    // Xử lý upload hình ảnh
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $HinhAnhMatTruocXe = '';
    $HinhAnhMatSauXe = '';

    if (isset($_FILES['HinhAnhMatTruocXe']) && $_FILES['HinhAnhMatTruocXe']['error'] == 0) {
        $fileName = uniqid() . '_' . basename($_FILES['HinhAnhMatTruocXe']['name']);
        move_uploaded_file($_FILES['HinhAnhMatTruocXe']['tmp_name'], $uploadDir . $fileName);
        $HinhAnhMatTruocXe = 'uploads/' . $fileName;
    }

    if (isset($_FILES['HinhAnhMatSauXe']) && $_FILES['HinhAnhMatSauXe']['error'] == 0) {
        $fileName = uniqid() . '_' . basename($_FILES['HinhAnhMatSauXe']['name']);
        move_uploaded_file($_FILES['HinhAnhMatSauXe']['tmp_name'], $uploadDir . $fileName);
        $HinhAnhMatSauXe = 'uploads/' . $fileName;
    }

    $db = (new ConnectDb())->connect();
    $bikeModel = new BikeProfileModel($db);

    // Kiểm tra trùng số khung/số máy trước khi thêm
    if (($SoKhung !== null && $SoKhung !== '') || ($SoMay !== null && $SoMay !== '')) {
        if ($bikeModel->isExistedSoKhungOrSoMay($SoKhung, $SoMay)) {
            header("Location: ../bikeprofile.php?error=trung_so_khung_so_may");
            exit();
        }
    }

    try {
        $result = $bikeModel->addBike([
            'TenXe' => $TenXe,
            'LoaiXe' => $LoaiXe,
            'PhanKhuc' => $PhanKhuc,
            'BienSoXe' => $BienSoXe,
            'SoKhung' => $SoKhung,
            'SoMay' => $SoMay,
            'HinhAnhMatTruocXe' => $HinhAnhMatTruocXe,
            'HinhAnhMatSauXe' => $HinhAnhMatSauXe,
            'khachhang_MaKH' => $khachhang_MaKH
        ]);
        if ($result) {
            header("Location: ../bikeprofile.php?success=1");
            exit();
        } else {
            header("Location: ../bikeprofile.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        // Lỗi trùng unique key
        if ($e->errorInfo[1] == 1062) {
            header("Location: ../bikeprofile.php?error=trung_so_khung_so_may");
            exit();
        }
        header("Location: ../bikeprofile.php?error=1");
        exit();
    }
}