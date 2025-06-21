<?php
class NhanVienModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
public function getNhanVienConTrong($ngay, $ca)
    {
        $sql = "SELECT MaLLV FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca AND TrangThai = 'da duyet'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ngay' => $ngay, ':ca' => $ca]);
        $MaLLV = $stmt->fetchColumn();
        if (!$MaLLV)
            return [];

        $sql = "SELECT nv.*
                FROM nhanvien nv
                WHERE nv.lichlamviec_MaLLV = :mallv
                  AND NOT EXISTS (
                      SELECT 1 FROM lichhen lh
                      WHERE lh.nhanvien_MaNV = nv.MaNV
                        AND lh.NgayHen = :ngay
                        AND lh.ThoiGianCa = :ca
                        AND lh.TrangThai IN ('cho duyet', 'da duyet')
                  )";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mallv' => $MaLLV, ':ngay' => $ngay, ':ca' => $ca]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin nhân viên theo mã
    public function getNhanVienById($maNV) {
        $sql = "SELECT * FROM nhanvien WHERE MaNV = :manv LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':manv' => $maNV]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lấy nhân viên còn trống cho ca/ngày, tối đa 4 ca/ngày, 1 ca có thể có nhiều nhân viên
    // public function getNhanVienConTrong($ngay, $ca)
    // {
    //     $sql = "SELECT MaLLV FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca AND TrangThai = 'da duyet'";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([':ngay' => $ngay, ':ca' => $ca]);
    //     $MaLLV = $stmt->fetchColumn();
    //     if (!$MaLLV)
    //         return [];

    //     $sql = "SELECT nv.*,
    //                    (
    //                        SELECT COUNT(*) FROM lichhen lh
    //                        WHERE lh.nhanvien_MaNV = nv.MaNV
    //                          AND lh.NgayHen = :ngay
    //                          AND lh.TrangThai IN ('cho duyet', 'da duyet')
    //                    ) AS so_lich_trong_ngay
    //             FROM nhanvien nv
    //             WHERE nv.lichlamviec_MaLLV = :mallv
    //             HAVING so_lich_trong_ngay < 4";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([':mallv' => $MaLLV, ':ngay' => $ngay]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // // Lấy thông tin nhân viên theo mã
    // public function getNhanVienById($maNV) {
    //     $sql = "SELECT * FROM nhanvien WHERE MaNV = :manv LIMIT 1";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([':manv' => $maNV]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
}
?>