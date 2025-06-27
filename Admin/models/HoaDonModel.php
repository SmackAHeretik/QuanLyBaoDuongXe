<?php
class HoaDonModel
{
  private $conn;
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Lấy danh sách hóa đơn (kèm tên xe và tên khách hàng)
  public function getAll()
  {
    $stmt = $this->conn->query("
            SELECT 
                h.*, 
                x.TenXe, 
                x.BienSoXe, 
                k.TenKH 
            FROM hoadon h
            LEFT JOIN xemay x ON h.xemay_MaXE = x.MaXE
            LEFT JOIN khachhang k ON x.khachhang_MaKH = k.MaKH
            ORDER BY h.MaHD DESC
        ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy hóa đơn theo ID
  public function getById($id)
  {
    $stmt = $this->conn->prepare("
            SELECT 
                h.*, 
                x.TenXe, 
                x.BienSoXe, 
                k.TenKH 
            FROM hoadon h
            LEFT JOIN xemay x ON h.xemay_MaXE = x.MaXE
            LEFT JOIN khachhang k ON x.khachhang_MaKH = k.MaKH
            WHERE h.MaHD = ?
        ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Thêm hóa đơn mới
  public function add($data)
  {
    $stmt = $this->conn->prepare("
            INSERT INTO hoadon (TongTien, Ngay, TrangThai, TienKhuyenMai, TienSauKhiGiam, xemay_MaXE)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
    return $stmt->execute([
      $data['TongTien'],
      $data['Ngay'],
      $data['TrangThai'],
      $data['TienKhuyenMai'],
      $data['TienSauKhiGiam'],
      $data['xemay_MaXE']
    ]);
  }

  // Sửa hóa đơn
  public function update($id, $data)
  {
    $stmt = $this->conn->prepare("
            UPDATE hoadon SET TongTien=?, Ngay=?, TrangThai=?, TienKhuyenMai=?, TienSauKhiGiam=?, xemay_MaXE=?
            WHERE MaHD=?
        ");
    return $stmt->execute([
      $data['TongTien'],
      $data['Ngay'],
      $data['TrangThai'],
      $data['TienKhuyenMai'],
      $data['TienSauKhiGiam'],
      $data['xemay_MaXE'],
      $id
    ]);
  }

  // Xóa hóa đơn
  public function delete($id)
  {
    $stmt = $this->conn->prepare("DELETE FROM hoadon WHERE MaHD=?");
    return $stmt->execute([$id]);
  }

  // Lấy danh sách xe máy kèm tên khách hàng
  public function getAllXeMayWithKhachHang()
  {
    $stmt = $this->conn->query("
            SELECT 
                x.MaXE, 
                x.TenXe, 
                x.BienSoXe, 
                k.TenKH 
            FROM xemay x
            LEFT JOIN khachhang k ON x.khachhang_MaKH = k.MaKH
        ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy hóa đơn theo mã xe
  public function getHoaDonByMaXe($maxe) {
    $stmt = $this->conn->prepare("
        SELECT * FROM hoadon WHERE xemay_MaXE = ? ORDER BY MaHD DESC
    ");
    $stmt->execute([$maxe]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>