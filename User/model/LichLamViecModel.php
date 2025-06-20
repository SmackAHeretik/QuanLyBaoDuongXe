<?php
class LichLamViecModel {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Lấy tất cả ca làm việc hợp lệ (trạng thái đã duyệt) trong ngày
    public function getCaLamViecByNgay($ngay) {
        $sql = "SELECT ThoiGianCa FROM lichlamviec WHERE ngay = :ngay AND TrangThai = 'da duyet'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ngay', $ngay);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>