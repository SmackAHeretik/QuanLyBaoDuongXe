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
}
?>