<?php
class HoaDonModel
{
  public $conn;
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
            INSERT INTO hoadon (TongTien, Ngay, TrangThai, xemay_MaXE)
            VALUES (?, ?, ?, ?)
        ");
    $stmt->execute([
      $data['TongTien'],
      $data['Ngay'],
      $data['TrangThai'],
      $data['xemay_MaXE']
    ]);
    return $stmt->rowCount() > 0;
  }

  // Lấy ID hóa đơn cuối
  public function getLastInsertId() {
    return $this->conn->lastInsertId();
  }

  // Sửa hóa đơn
  public function update($id, $data)
  {
    $stmt = $this->conn->prepare("
            UPDATE hoadon SET TongTien=?, Ngay=?, TrangThai=?, xemay_MaXE=?
            WHERE MaHD=?
        ");
    return $stmt->execute([
      $data['TongTien'],
      $data['Ngay'],
      $data['TrangThai'],
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

  // Lấy danh sách phụ tùng xe máy
  public function getAllPhuTung()
  {
    $stmt = $this->conn->query("SELECT * FROM phutungxemay WHERE TrangThai=1");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy danh sách hóa đơn theo mã xe
  public function getHoaDonByMaXe($maXe) {
    $stmt = $this->conn->prepare("
        SELECT * FROM hoadon WHERE xemay_MaXE = ? ORDER BY MaHD DESC
    ");
    $stmt->execute([$maXe]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Cập nhật trạng thái hóa đơn (dùng cho thanh toán tiền mặt)
  public function updateTrangThai($mahd, $trangthai) {
    $stmt = $this->conn->prepare("UPDATE hoadon SET TrangThai=? WHERE MaHD=?");
    return $stmt->execute([$trangthai, $mahd]);
  }
}
?>