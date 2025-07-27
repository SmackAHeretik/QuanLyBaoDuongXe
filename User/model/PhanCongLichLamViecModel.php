<?php
class PhanCongLichLamViecModel {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Lấy danh sách nhân viên đã phân công vào 1 ca
    public function getNhanVienByMaLLV($MaLLV) {
        $sql = "SELECT MaNV FROM phancong_lichlamviec WHERE MaLLV = :mallv";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mallv' => $MaLLV]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>