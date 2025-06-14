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
    $result = $this->conn->query($sql);
    $arr = [];
    while ($row = $result->fetch_assoc()) {
      $arr[] = $row;
    }
    return $arr;
  }

  // Lấy 1 nhà sản xuất theo ID
  public function getById($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM nhasanxuat WHERE MaNSX = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
  }

  // Thêm mới
  public function add($data)
  {
    $stmt = $this->conn->prepare("INSERT INTO nhasanxuat (TenNhaSX, XuatXu, MoTa) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $data['TenNhaSX'], $data['XuatXu'], $data['MoTa']);
    return $stmt->execute();
  }

  // Cập nhật
  public function update($id, $data)
  {
    $stmt = $this->conn->prepare("UPDATE nhasanxuat SET TenNhaSX = ?, XuatXu = ?, MoTa = ? WHERE MaNSX = ?");
    $stmt->bind_param("sssi", $data['TenNhaSX'], $data['XuatXu'], $data['MoTa'], $id);
    return $stmt->execute();
  }

  // Xóa
  public function delete($id)
  {
    $stmt = $this->conn->prepare("DELETE FROM nhasanxuat WHERE MaNSX = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }
}
