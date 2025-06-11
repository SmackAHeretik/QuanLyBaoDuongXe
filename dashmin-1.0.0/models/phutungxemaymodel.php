<?php
require_once __DIR__ . '/../db.php';

class PhuTungXeMayModel
{
  private $conn;

  public function __construct()
  {
    $this->conn = connectDB();
  }

  public function getAll()
  {
    $sql = "SELECT * FROM phutungxemay";
    return $this->conn->query($sql);
  }

  public function getById($MaSP)
  {
    $stmt = $this->conn->prepare("SELECT * FROM phutungxemay WHERE MaSP = ?");
    $stmt->bind_param("i", $MaSP);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  public function add($data)
  {
    $stmt = $this->conn->prepare("INSERT INTO phutungxemay (TenSP, SoSeriesSP, MieuTaSP, NamSX, XuatXu, ThoiGianBaoHanhDinhKy, DonGia, loaiphutung, nhasanxuat_MaNSX, SoLanBaoHanhToiDa, HinhAnh) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
      "sssissdsiis",
      $data['TenSP'],
      $data['SoSeriesSP'],
      $data['MieuTaSP'],
      $data['NamSX'],
      $data['XuatXu'],
      $data['ThoiGianBaoHanhDinhKy'],
      $data['DonGia'],
      $data['loaiphutung'],
      $data['nhasanxuat_MaNSX'],
      $data['SoLanBaoHanhToiDa'],
      $data['HinhAnh']
    );
    return $stmt->execute();
  }

  public function update($MaSP, $data)
  {
    $stmt = $this->conn->prepare("UPDATE phutungxemay SET TenSP=?, SoSeriesSP=?, MieuTaSP=?, NamSX=?, XuatXu=?, ThoiGianBaoHanhDinhKy=?, DonGia=?, loaiphutung=?, nhasanxuat_MaNSX=?, SoLanBaoHanhToiDa=?, HinhAnh=? WHERE MaSP=?");
    $stmt->bind_param(
      "sssissdsiisi",
      $data['TenSP'],
      $data['SoSeriesSP'],
      $data['MieuTaSP'],
      $data['NamSX'],
      $data['XuatXu'],
      $data['ThoiGianBaoHanhDinhKy'],
      $data['DonGia'],
      $data['loaiphutung'],
      $data['nhasanxuat_MaNSX'],
      $data['SoLanBaoHanhToiDa'],
      $data['HinhAnh'],
      $MaSP
    );
    return $stmt->execute();
  }

  public function delete($MaSP)
  {
    $stmt = $this->conn->prepare("DELETE FROM phutungxemay WHERE MaSP = ?");
    $stmt->bind_param("i", $MaSP);
    return $stmt->execute();
  }
}
?>