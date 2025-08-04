<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
include_once './utils/ConnectDb.php';
include_once './model/LichHenModel.php';
include_once './model/BikeProfileModel.php';
include_once './model/NhanVienModel.php';
include_once './model/LichLamViecModel.php';

class LichHenController
{
    public function add()
    {
        // Tạo kết nối CSDL
        $db = (new ConnectDb())->connect();

        $bikeList = [];
        if (isset($_SESSION['MaKH'])) {
            $bikeModel = new BikeProfileModel($db);
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
                $bikeModel = new BikeProfileModel($db);
                $xeInfo = $bikeModel->getBikeById($MaXE);

                // Lấy MaLLV từ bảng lichlamviec
                $lichLamViecModel = new LichLamViecModel($db);
                $ca = $lichLamViecModel->getCaLamViecByNgayVaCa($NgayHen, $ThoiGianCa);
                if (!$ca) {
                    $error = 'Không tìm thấy ca làm việc!';
                } else {
                    $MaLLV = $ca['MaLLV'];
                }

                // Lấy danh sách nhân viên còn trống ca
                $nvModel = new NhanVienModel($db);
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
                        'MaLLV' => $MaLLV
                    ];
                    $model = new LichHenModel($db);
                    $ok = $model->insertLichHen($data);

                    if ($ok === 'duplicate_khachhang') {
                        $error = 'Bạn đã đặt lịch cho xe này trong ca này rồi!';
                    } else if ($ok) {
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
?>