<?php
class LichLamViecModel {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Lấy tất cả ca làm việc hợp lệ (trạng thái đã duyệt) trong ngày
    public function getCaLamViecByNgay($ngay) {
        $sql = "SELECT MaLLV, ThoiGianCa FROM lichlamviec WHERE ngay = :ngay AND TrangThai = 'da duyet'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ngay', $ngay);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy 1 ca theo ngày và ca để lấy MaLLV
    public function getCaLamViecByNgayVaCa($ngay, $ca) {
        $sql = "SELECT * FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca AND TrangThai = 'da duyet' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ngay' => $ngay, ':ca' => $ca]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>