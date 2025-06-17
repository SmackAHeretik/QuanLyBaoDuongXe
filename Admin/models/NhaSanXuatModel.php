<?php
require_once __DIR__ . '/../db.php';

class NhaSanXuatModel
{
  private $conn;

  public function __construct()
  {
    $this->conn = connectDB();
  }

  // Lấy tất cả nhà sản xuất
  public function getAll()
  {
    $sql = "SELECT MaNSX, TenNhaSX, XuatXu, MoTa FROM nhasanxuat";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Lấy 1 nhà sản xuất theo ID
  public function getById($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM nhasanxuat WHERE MaNSX = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Thêm mới
  public function add($data)
  {
    $stmt = $this->conn->prepare("INSERT INTO nhasanxuat (TenNhaSX, XuatXu, MoTa) VALUES (?, ?, ?)");
    return $stmt->execute([
      $data['TenNhaSX'],
      $data['XuatXu'],
      $data['MoTa']
    ]);
  }

  // Cập nhật
  public function update($id, $data)
  {
    $stmt = $this->conn->prepare("UPDATE nhasanxuat SET TenNhaSX = ?, XuatXu = ?, MoTa = ? WHERE MaNSX = ?");
    return $stmt->execute([
      $data['TenNhaSX'],
      $data['XuatXu'],
      $data['MoTa'],
      $id
    ]);
  }

  // Xóa
  public function delete($id)
  {
    $stmt = $this->conn->prepare("DELETE FROM nhasanxuat WHERE MaNSX = ?");
    return $stmt->execute([$id]);
  }
}