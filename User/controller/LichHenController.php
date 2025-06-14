<?php
require_once __DIR__ . '/../model/LichHenModel.php';

class LichHenController
{
    public function nhanvienRon()
    {
        if (!isset($_POST['datetime'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Thiếu dữ liệu']);
            exit;
        }
        $datetime = $_POST['datetime'];
        $model = new LichHenModel();
        $dsNhanVien = $model->getNhanVienRanh($datetime);
        header('Content-Type: application/json');
        echo json_encode($dsNhanVien);
        exit;
    }

    public function datLichForm()
    {
        require_once __DIR__ . '/../layouts/contact/contact.php';
    }

    public function luuLichHen()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy đúng tên input
            $ngayhen = $_POST['thoigianhen'] ?? '';
            $manv = $_POST['manv'] ?? null;
            $mota = $_POST['message'] ?? '';
            $loaixe = $_POST['loaixe'] ?? '';
            $makh = $_SESSION['MaKH'] ?? null;


            // Đặt múi giờ mặc định VN
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            // Kiểm tra ngày quá khứ (so sánh timestamp chính xác)
            $tsHen = strtotime($ngayhen);
            $tsNow = time();
            if (!$ngayhen || $tsHen <= $tsNow) {
                echo "<script>alert('Không thể đặt lịch ở thời điểm quá khứ!'); window.history.back();</script>";
                exit;
            }

            // Kiểm tra Chủ nhật
            if (date('w', $tsHen) == 0) {
                echo "<script>alert('Chỉ được đặt lịch từ Thứ 2 đến Thứ 7!'); window.history.back();</script>";
                exit;
            }

            // Kiểm tra giờ hợp lệ (8h đến 20h)
            $giohen = (int) date('H', $tsHen);
            $phut = (int) date('i', $tsHen);
            if ($giohen < 8 || ($giohen == 20 && $phut > 0) || $giohen > 20) {
                echo "<script>alert('Chỉ được đặt lịch từ 08:00 đến 20:00!'); window.history.back();</script>";
                exit;
            }

            if (!$manv || !$makh || !$loaixe) {
                echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.history.back();</script>";
                exit;
            }

            $model = new LichHenModel();

            // Kiểm tra khách đã có lịch với nhân viên này trong vòng 3 tiếng quanh thời điểm hẹn chưa
            if ($model->daCoLichTrung($makh, $manv, $ngayhen)) {
                echo "<script>alert('Bạn đã có lịch đặt hẹn với nhân viên này trong vòng 3 tiếng tại thời điểm này rồi, vui lòng đặt lịch cách 3 tiếng!'); window.history.back();</script>";
                exit;
            }

            // Kiểm tra nhân viên đã có lịch với khách khác trong vòng 3 tiếng quanh thời điểm này chưa
            if ($model->nhanVienDaCoLichTrung($manv, $ngayhen)) {
                echo "<script>alert('Nhân viên này đã có lịch trong vòng 3 tiếng quanh thời điểm này! Vui lòng chọn nhân viên khác hoặc đổi thời gian!'); window.history.back();</script>";
                exit;
            }

            try {
                $result = $model->luuLichHen($ngayhen, $manv, $makh, $mota, $loaixe);
                if ($result) {
                    echo "<script>alert('Đặt lịch thành công!'); window.location='index.php?controller=LichHen&action=datLichForm';</script>";
                    exit;
                } else {
                    echo "<script>alert('Có lỗi khi lưu dữ liệu!'); window.history.back();</script>";
                    exit;
                }
            } catch (Exception $e) {
                echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
                exit;
            }
        }
        header('Location: index.php?controller=LichHen&action=datLichForm');
        exit;
    }
    public function lichHenCuaToi()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['MaKH'])) {
            echo "<script>alert('Bạn cần đăng nhập để xem lịch hẹn!'); window.location='../login.php';</script>";
            exit();
        }
        $makh = $_SESSION['MaKH'];
        $model = new LichHenModel();
        $lichhen = $model->getLichHenByKhachHang($makh);

        // Đường dẫn đúng tới view
        include __DIR__ . '/../view/lichhen_cuatoi.php';
    }

    // public function getAllLichHen()
    // {
    //     $sql = "SELECT * FROM lichhen";
    //     $stmt = $this->db->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}
?>