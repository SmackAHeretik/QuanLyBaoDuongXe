<?php
class ChiTietHoaDonModel
{
  private $conn;

  public function __construct($pdo)
  {
    $this->conn = $pdo;
  }

  // Lấy tất cả chi tiết hóa đơn
  public function getAll()
  {
    $stmt = $this->conn->query("SELECT * FROM chitiethoadon ORDER BY MaCTHD DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy 1 chi tiết hóa đơn theo ID
  public function getById($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM chitiethoadon WHERE MaCTHD=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Thêm mới chi tiết hóa đơn
  public function add($data)
  {
    $stmt = $this->conn->prepare("INSERT INTO chitiethoadon 
            (hoadon_MaHD, phutungxemay_MaSP, dichvu_MaDV, GiaTien, SoLuong, NgayBDBH, NgayKTBH, SoLanDaBaoHanh) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
      $data['hoadon_MaHD'],
      $data['phutungxemay_MaSP'],
      $data['dichvu_MaDV'],
      $data['GiaTien'],
      $data['SoLuong'],
      $data['NgayBDBH'],
      $data['NgayKTBH'],
      $data['SoLanDaBaoHanh']
    ]);
  }

  // Cập nhật chi tiết hóa đơn
  public function update($id, $data)
  {
    $stmt = $this->conn->prepare("UPDATE chitiethoadon SET 
            hoadon_MaHD=?, 
            phutungxemay_MaSP=?, 
            dichvu_MaDV=?, 
            GiaTien=?, 
            SoLuong=?, 
            NgayBDBH=?, 
            NgayKTBH=?, 
            SoLanDaBaoHanh=?
            WHERE MaCTHD=?");
    return $stmt->execute([
      $data['hoadon_MaHD'],
      $data['phutungxemay_MaSP'],
      $data['dichvu_MaDV'],
      $data['GiaTien'],
      $data['SoLuong'],
      $data['NgayBDBH'],
      $data['NgayKTBH'],
      $data['SoLanDaBaoHanh'],
      $id
    ]);
  }

  // Xóa chi tiết hóa đơn
  public function delete($id)
  {
    $stmt = $this->conn->prepare("DELETE FROM chitiethoadon WHERE MaCTHD=?");
    return $stmt->execute([$id]);
  }
}
?>