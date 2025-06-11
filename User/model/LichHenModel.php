<?php
class LichHenModel
{
  private $db;

  public function __construct()
  {
    $this->db = new PDO('mysql:host=localhost;dbname=quanlybaoduongxe;charset=utf8', 'root', '');
  }

  public function getNhanVienRanh($datetime)
  {
    $sql = "
            SELECT nv.MaNV, nv.TenNV
            FROM nhanvien nv
            WHERE nv.MaNV NOT IN (
                SELECT llv.nhanvien_MaNV
                FROM lichlamviec llv
                JOIN calamviec cav ON llv.calamviec_MaCaV = cav.MaCaV
                WHERE (? BETWEEN cav.ThoiGianBD AND cav.ThoiGianKT)
                AND llv.TrangThai = 'on'
            )
        ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$datetime]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Kiểm tra khách đã có lịch với nhân viên đó trong vòng 3 tiếng quanh thời gian đặt chưa
  public function daCoLichTrung($makh, $manv, $ngayhen)
  {
    $giohen = date('Y-m-d H:i:s', strtotime($ngayhen));
    $start = date('Y-m-d H:i:s', strtotime($giohen) - 3 * 3600); // -3h
    $end = date('Y-m-d H:i:s', strtotime($giohen) + 3 * 3600); // +3h

    $sql = "SELECT COUNT(*) FROM lichhen
                WHERE lichen_khachhang_MaKH = ? 
                  AND lichen_nhanvien_MaNV = ?
                  AND NgayHen BETWEEN ? AND ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$makh, $manv, $start, $end]);
    return $stmt->fetchColumn() > 0;
  }

  // Kiểm tra nhân viên đã có lịch với bất kỳ khách nào trong vòng 3 tiếng quanh thời gian đặt chưa
  public function nhanVienDaCoLichTrung($manv, $ngayhen)
  {
    $giohen = date('Y-m-d H:i:s', strtotime($ngayhen));
    $start = date('Y-m-d H:i:s', strtotime($giohen) - 3 * 3600); // -3h
    $end = date('Y-m-d H:i:s', strtotime($giohen) + 3 * 3600); // +3h

    $sql = "SELECT COUNT(*) FROM lichhen
                WHERE lichen_nhanvien_MaNV = ?
                  AND NgayHen BETWEEN ? AND ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$manv, $start, $end]);
    return $stmt->fetchColumn() > 0;
  }

  public function luuLichHen($ngayhen, $manv, $makh, $mota, $loaixe)
  {
    $sql = "INSERT INTO lichhen (NgayHen, TrangThai, lichen_nhanvien_MaNV, lichen_khachhang_MaKH, MoTaLyDoHen, LoaiXe)
                VALUES (?, 'pending', ?, ?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$ngayhen, $manv, $makh, $mota, $loaixe]);
  }
}
?>