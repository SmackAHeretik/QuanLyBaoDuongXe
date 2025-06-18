<?php
class PhuTungXeMayModel
{
  private $conn;

  public function __construct($pdo)
  {
    $this->conn = $pdo;
  }

  public function getAll()
  {
    $sql = "SELECT * FROM phutungxemay";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getAllHienThi()
  {
    $sql = "SELECT * FROM phutungxemay WHERE TrangThai = 1";
    $stmt = $this->conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($MaSP)
  {
    $stmt = $this->conn->prepare("SELECT * FROM phutungxemay WHERE MaSP = ?");
    $stmt->execute([$MaSP]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function add($data)
  {
    $sql = "INSERT INTO phutungxemay (TenSP, SoSeriesSP, MieuTaSP, NamSX, XuatXu, ThoiGianBaoHanhDinhKy, DonGia, loaiphutung, nhasanxuat_MaNSX, SoLanBaoHanhToiDa, HinhAnh, TrangThai)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
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
      $data['TrangThai']
    ]);
  }

  public function update($MaSP, $data)
  {
    $sql = "UPDATE phutungxemay SET TenSP=?, SoSeriesSP=?, MieuTaSP=?, NamSX=?, XuatXu=?, ThoiGianBaoHanhDinhKy=?, DonGia=?, loaiphutung=?, nhasanxuat_MaNSX=?, SoLanBaoHanhToiDa=?, HinhAnh=?, TrangThai=?
            WHERE MaSP=?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
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
      $data['TrangThai'],
      $MaSP
    ]);
  }

  public function updateStatus($MaSP, $TrangThai)
  {
    $sql = "UPDATE phutungxemay SET TrangThai=? WHERE MaSP=?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$TrangThai, $MaSP]);
  }

  public function delete($MaSP)
  {
    $stmt = $this->conn->prepare("DELETE FROM phutungxemay WHERE MaSP = ?");
    return $stmt->execute([$MaSP]);
  }
}
?>