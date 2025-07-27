<?php
class NhanVienModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Lấy danh sách nhân viên còn trống ca làm việc (được phân công vào ca nhưng chưa bị đặt lịch)
    public function getNhanVienConTrong($ngay, $ca)
    {
        // Chỉ lấy các lịch làm việc đã duyệt với ngày và ca tương ứng
        $sql = "SELECT MaLLV FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca AND TrangThai = 'da duyet'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ngay' => $ngay, ':ca' => $ca]);
        $MaLLV = $stmt->fetchColumn();
        if (!$MaLLV)
            return [];

        // Lấy tất cả nhân viên đã được phân công ca này
        $sql = "SELECT nv.MaNV, nv.TenNV
                FROM phancong_lichlamviec pc
                JOIN nhanvien nv ON pc.MaNV = nv.MaNV
                WHERE pc.MaLLV = :mallv";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mallv' => $MaLLV]);
        $nhanviens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy các nhân viên đã bị đặt lịch ở ca này (trạng thái chưa huỷ)
        $sql2 = "SELECT nhanvien_MaNV FROM lichhen WHERE MaLLV = :mallv AND TrangThai IN ('cho duyet','da duyet')";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([':mallv' => $MaLLV]);
        $nvDaDat = $stmt2->fetchAll(PDO::FETCH_COLUMN);

        // Lọc ra nhân viên còn trống
        $nhanviensConTrong = [];
        foreach ($nhanviens as $nv) {
            if (!in_array($nv['MaNV'], $nvDaDat)) {
                $nhanviensConTrong[] = $nv;
            }
        }
        return $nhanviensConTrong;
    }

    // Lấy thông tin nhân viên theo mã
    public function getNhanVienById($maNV) {
        $sql = "SELECT * FROM nhanvien WHERE MaNV = :manv LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':manv' => $maNV]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>