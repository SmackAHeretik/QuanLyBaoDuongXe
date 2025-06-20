<?php
class NhanVienModel
{
  private $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  // Lấy nhân viên còn trống cho ca/ngày (chưa có lịch hẹn)
  public function getNhanVienConTrong($ngay, $ca)
  {
    $sql = "SELECT MaLLV FROM lichlamviec WHERE ngay = :ngay AND ThoiGianCa = :ca AND TrangThai = 'da duyet'";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':ngay' => $ngay, ':ca' => $ca]);
    $MaLLV = $stmt->fetchColumn();
    if (!$MaLLV)
      return [];
    $sql = "SELECT nv.* FROM nhanvien nv 
                WHERE nv.lichlamviec_MaLLV = :mallv
                AND nv.MaNV NOT IN (
                    SELECT nhanvien_MaNV FROM lichhen 
                    WHERE NgayHen = :ngay AND ThoiGianCa = :ca AND TrangThai IN ('cho duyet', 'da duyet')
                )";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':mallv' => $MaLLV, ':ngay' => $ngay, ':ca' => $ca]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>