<?php
class DichVuModel
{
  private $conn;
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Lấy tất cả dịch vụ
  public function getAll()
  {
    $stmt = $this->conn->query("SELECT * FROM dichvu ORDER BY MaDV DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy dịch vụ theo ID
  public function getById($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM dichvu WHERE MaDV = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Thêm dịch vụ
  public function add($data)
  {
    $stmt = $this->conn->prepare("INSERT INTO dichvu (TenDV, HinhAnh, DonGia) VALUES (?, ?, ?)");
    return $stmt->execute([
      $data['TenDV'],
      $data['HinhAnh'],
      $data['DonGia']
    ]);
  }

  // Sửa dịch vụ
  public function update($id, $data)
  {
    $stmt = $this->conn->prepare("UPDATE dichvu SET TenDV=?, HinhAnh=?, DonGia=? WHERE MaDV=?");
    return $stmt->execute([
      $data['TenDV'],
      $data['HinhAnh'],
      $data['DonGia'],
      $id
    ]);
  }

  // Xóa dịch vụ
  public function delete($id)
  {
    $stmt = $this->conn->prepare("DELETE FROM dichvu WHERE MaDV=?");
    return $stmt->execute([$id]);
  }
}