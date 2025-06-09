<?php
require_once __DIR__ . '/../db.php';

class NhaSanXuatModel
{
  private $conn;

  public function __construct()
  {
    $this->conn = connectDB();
  }

  public function getAll()
  {
    $sql = "SELECT MaNSX, TenNhaSX FROM nhasanxuat";
    $result = $this->conn->query($sql);
    $arr = [];
    while ($row = $result->fetch_assoc()) {
      $arr[] = $row;
    }
    return $arr;
  }
}
?>