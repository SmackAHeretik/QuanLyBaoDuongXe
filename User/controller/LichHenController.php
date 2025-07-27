<?php
session_start();
include_once './model/LichHenModel.php';
include_once './model/BikeProfileModel.php';
include_once './model/NhanVienModel.php';

class LichHenController
{
    public function add()
    {
        $bikeList = [];
        if (isset($_SESSION['MaKH'])) {
            $bikeModel = new BikeProfileModel();
            $bikeList = $bikeModel->getBikesByCustomerId($_SESSION['MaKH']);
        }

        $error = '';
        $success = '';
        $nhanvien_TenNV = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaXE = $_POST['xemay_MaXE'] ?? '';
            $NgayHen = $_POST['NgayHen'] ?? '';
            $ThoiGianCa = $_POST['ThoiGianCa'] ?? '';
            $MoTaLyDo = $_POST['MoTaLyDo'] ?? '';
            $PhanLoai = 0; // Đặt lịch hẹn
            $TrangThai = 'cho duyet';

            if (!$MaXE || !$NgayHen || !$ThoiGianCa || !$MoTaLyDo) {
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            } else {
                $bikeModel = new BikeProfileModel();
                $xeInfo = $bikeModel->getBikeById($MaXE);

                // Lấy danh sách nhân viên còn trống ca
                $nvModel = new NhanVienModel();
                $nhanviens = $nvModel->getNhanVienConTrong($NgayHen, $ThoiGianCa);
                $nhanvien_MaNV = null;
                if ($nhanviens && count($nhanviens) > 0) {
                    $randomIdx = array_rand($nhanviens);
                    $nhanvien_MaNV = $nhanviens[$randomIdx]['MaNV'];
                    $nhanvien_TenNV = $nhanviens[$randomIdx]['TenNV'];
                } else {
                    $error = 'Tất cả nhân viên trong ca này đã kín lịch!';
                }

                if (empty($error)) {
                    $data = [
                        'TenXe' => $xeInfo['TenXe'] ?? '',
                        'LoaiXe' => $xeInfo['LoaiXe'] ?? '',
                        'PhanKhuc' => $xeInfo['PhanKhuc'] ?? '',
                        'MoTaLyDo' => $MoTaLyDo,
                        'nhanvien_MaNV' => $nhanvien_MaNV,
                        'NgayHen' => $NgayHen,
                        'ThoiGianCa' => $ThoiGianCa,
                        'PhanLoai' => $PhanLoai,
                        'TrangThai' => $TrangThai,
                        'xemay_MaXE' => $MaXE,
                        'khachhang_MaKH' => $_SESSION['MaKH'],
                    ];
                    $model = new LichHenModel();
                    $ok = $model->insertLichHen($data);
                    if ($ok) {
                        $success = 'Đặt lịch hẹn thành công!';
                    } else {
                        $error = 'Có lỗi khi lưu dữ liệu!';
                    }
                }
            }
        }
        // Truyền $nhanvien_TenNV xuống view (add.php) để show ra cho khách
        include './views/lichhen/add.php';
    }
}