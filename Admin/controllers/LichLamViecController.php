<?php
require_once __DIR__ . '/../models/LichLamViecModel.php';
require_once __DIR__ . '/../models/NhanVienModel.php';
require_once __DIR__ . '/../models/PhanCongLichLamViecModel.php';

class LichLamViecController {
    private $db;
    private $lichLamViecModel;
    private $nhanVienModel;
    private $phanCongModel;

    public function __construct($db) {
        $this->db = $db;
        $this->lichLamViecModel = new LichLamViecModel($db);
        $this->nhanVienModel = new NhanVienModel($db);
        $this->phanCongModel = new PhanCongLichLamViecModel($db);
    }

    // Hiển thị danh sách lịch làm việc
    public function index() {
        $dsLich = $this->lichLamViecModel->getAll();
        $phancongModel = $this->phanCongModel; // Đưa biến này cho view
        ob_start();
        require __DIR__ . '/../views/lichlamviec/list.php';
        echo ob_get_clean();
    }

    // Thêm lịch làm việc
    public function add() {
        $error = '';
        $data = [];
        $dsThoSuaXe = $this->nhanVienModel->getAllThoSuaXe();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['LaNgayCuoiTuan'] = isset($data['LaNgayCuoiTuan']) ? 1 : 0;
            $data['LaNgayNghiLe']   = isset($data['LaNgayNghiLe'])   ? 1 : 0;

            $ngay = $data['ngay'] ?? '';
            $ca = $data['ThoiGianCa'] ?? '';

            // Kiểm tra trùng ngày + ca làm việc
            $sql = "SELECT COUNT(*) FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':ngay' => $ngay, ':ca' => $ca]);
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                $error = "Đã tồn tại ca làm việc $ca cho ngày $ngay. Vui lòng chọn ca khác!";
            } else {
                // Tạo lịch làm việc mới
                $ok = $this->lichLamViecModel->add($data);
                if ($ok) {
                    $MaLLV = $this->db->lastInsertId();
                    // Gán thợ vào ca làm việc này
                    if (!empty($data['thoSuaXe']) && is_array($data['thoSuaXe'])) {
                        foreach ($data['thoSuaXe'] as $maNV) {
                            // Đảm bảo 1 nhân viên chỉ được gán 1 lần vào ca/ngày này
                            if (!$this->phanCongModel->isNhanVienInCa($MaLLV, $maNV)) {
                                $this->phanCongModel->insert($MaLLV, $maNV);
                            }
                        }
                    }
                    header('Location: ?action=index');
                    exit;
                } else {
                    $error = 'Lỗi lưu dữ liệu!';
                }
            }
        }

        require __DIR__ . '/../views/lichlamviec/add.php';
    }

    // Sửa lịch làm việc
    public function edit() {
        $error = '';
        $id = $_GET['id'] ?? null;
        $data = [];
        if (!$id) { header('Location: ?action=index'); exit; }

        $lich = $this->lichLamViecModel->getById($id);
        $dsThoSuaXe = $this->nhanVienModel->getAllThoSuaXe();

        // Lấy danh sách nhân viên đã phân công
        $dsPhanCong = $this->phanCongModel->getNhanVienByMaLLV($id);
        $data = $lich;
        $data['thoSuaXe'] = array_column($dsPhanCong, 'MaNV');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['LaNgayCuoiTuan'] = isset($data['LaNgayCuoiTuan']) ? 1 : 0;
            $data['LaNgayNghiLe']   = isset($data['LaNgayNghiLe'])   ? 1 : 0;

            $ngay = $data['ngay'] ?? '';
            $ca = $data['ThoiGianCa'] ?? '';

            // Kiểm tra trùng ngày + ca làm việc, nhưng bỏ qua chính lịch này khi sửa
            $sql = "SELECT COUNT(*) FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca AND MaLLV != :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':ngay' => $ngay, ':ca' => $ca, ':id' => $id]);
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                $error = "Đã tồn tại ca làm việc $ca cho ngày $ngay. Vui lòng chọn ca khác!";
            } else {
                // Update lịch làm việc
                $ok = $this->lichLamViecModel->update($id, $data);
                if ($ok) {
                    // Xoá hết phân công cũ, gán lại
                    $this->phanCongModel->deleteByMaLLV($id);
                    if (!empty($data['thoSuaXe']) && is_array($data['thoSuaXe'])) {
                        foreach ($data['thoSuaXe'] as $maNV) {
                            if (!$this->phanCongModel->isNhanVienInCa($id, $maNV)) {
                                $this->phanCongModel->insert($id, $maNV);
                            }
                        }
                    }
                    header('Location: ?action=index');
                    exit;
                } else {
                    $error = 'Lỗi cập nhật dữ liệu!';
                }
            }
        }

        require __DIR__ . '/../views/lichlamviec/edit.php';
    }

    // Xóa lịch làm việc
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->phanCongModel->deleteByMaLLV($id); // Xoá phân công trước
            $this->lichLamViecModel->delete($id);
        }
        header('Location: ?action=index');
        exit;
    }
}
?>