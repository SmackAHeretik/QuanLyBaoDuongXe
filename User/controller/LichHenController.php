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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaXE = $_POST['xemay_MaXE'] ?? '';
            $NgayHen = $_POST['NgayHen'] ?? '';
            $MoTaLyDo = $_POST['MoTaLyDo'] ?? '';
            $PhanLoai = 0; // Đặt lịch hẹn
            $TrangThai = 'cho duyet';

            if (!$MaXE || !$NgayHen || !$MoTaLyDo) {
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            } else {
                $bikeModel = new BikeProfileModel();
                $xeInfo = $bikeModel->getBikeById($MaXE);

                // Random nhân viên
                $nvModel = new NhanVienModel();
                $nhanviens = $nvModel->getAllNhanVien();
                $nhanvien_MaNV = null;
                if ($nhanviens && count($nhanviens) > 0) {
                    $randomIdx = array_rand($nhanviens);
                    $nhanvien_MaNV = $nhanviens[$randomIdx]['MaNV'];
                }

                $data = [
                    'TenXe' => $xeInfo['TenXe'] ?? '',
                    'LoaiXe' => $xeInfo['LoaiXe'] ?? '',
                    'PhanKhuc' => $xeInfo['PhanKhuc'] ?? '',
                    'MoTaLyDo' => $MoTaLyDo,
                    'nhanvien_MaNV' => $nhanvien_MaNV,
                    'NgayHen' => $NgayHen,
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
        include './views/lichhen/add.php';
    }
}