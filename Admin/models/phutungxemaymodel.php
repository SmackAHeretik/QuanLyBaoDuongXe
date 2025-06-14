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

  // Lấy tất cả phụ tùng HIỂN THỊ cho trang ngoài (khách)
  public function getAllHienThi()
  {
    $sql = "SELECT * FROM phutungxemay WHERE TrangThai = 1";
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
    $stmt = $this->conn->prepare("INSERT INTO phutungxemay (TenSP, SoSeriesSP, MieuTaSP, NamSX, XuatXu, ThoiGianBaoHanhDinhKy, DonGia, loaiphutung, nhasanxuat_MaNSX, SoLanBaoHanhToiDa, HinhAnh, TrangThai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $TenSP = $data['TenSP'];
    $SoSeriesSP = $data['SoSeriesSP'];
    $MieuTaSP = $data['MieuTaSP'];
    $NamSX = $data['NamSX'];
    $XuatXu = $data['XuatXu'];
    $ThoiGianBaoHanhDinhKy = $data['ThoiGianBaoHanhDinhKy'];
    $DonGia = floatval($data['DonGia']);
    $loaiphutung = $data['loaiphutung'];
    $nhasanxuat_MaNSX = intval($data['nhasanxuat_MaNSX']);
    $SoLanBaoHanhToiDa = intval($data['SoLanBaoHanhToiDa']);
    $HinhAnh = $data['HinhAnh'];
    $TrangThai = isset($data['TrangThai']) ? intval($data['TrangThai']) : 1;

    // sửa chuỗi kiểu đúng với dữ liệu cột:
    // TenSP(s), SoSeriesSP(s), MieuTaSP(s), NamSX(i), XuatXu(s), ThoiGianBaoHanhDinhKy(s), DonGia(d), loaiphutung(s), nhasanxuat_MaNSX(i), SoLanBaoHanhToiDa(i), HinhAnh(s), TrangThai(i)
    $stmt->bind_param(
      'sssissdsissi',
      $TenSP,
      $SoSeriesSP,
      $MieuTaSP,
      $NamSX,
      $XuatXu,
      $ThoiGianBaoHanhDinhKy,
      $DonGia,
      $loaiphutung,
      $nhasanxuat_MaNSX,
      $SoLanBaoHanhToiDa,
      $HinhAnh,
      $TrangThai
    );
    return $stmt->execute();
  }

  public function update($MaSP, $data)
  {
    $stmt = $this->conn->prepare("UPDATE phutungxemay SET TenSP=?, SoSeriesSP=?, MieuTaSP=?, NamSX=?, XuatXu=?, ThoiGianBaoHanhDinhKy=?, DonGia=?, loaiphutung=?, nhasanxuat_MaNSX=?, SoLanBaoHanhToiDa=?, HinhAnh=?, TrangThai=? WHERE MaSP=?");

    $TenSP = $data['TenSP'];
    $SoSeriesSP = $data['SoSeriesSP'];
    $MieuTaSP = $data['MieuTaSP'];
    $NamSX = $data['NamSX'];
    $XuatXu = $data['XuatXu'];
    $ThoiGianBaoHanhDinhKy = $data['ThoiGianBaoHanhDinhKy'];
    $DonGia = floatval($data['DonGia']);
    $loaiphutung = $data['loaiphutung'];
    $nhasanxuat_MaNSX = intval($data['nhasanxuat_MaNSX']);
    $SoLanBaoHanhToiDa = intval($data['SoLanBaoHanhToiDa']);
    $HinhAnh = $data['HinhAnh'];
    $TrangThai = isset($data['TrangThai']) ? intval($data['TrangThai']) : 1;
    $MaSP_int = intval($MaSP);

    // sửa chuỗi kiểu đúng với dữ liệu cột:
    // TenSP(s), SoSeriesSP(s), MieuTaSP(s), NamSX(i), XuatXu(s), ThoiGianBaoHanhDinhKy(s), DonGia(d), loaiphutung(s), nhasanxuat_MaNSX(i), SoLanBaoHanhToiDa(i), HinhAnh(s), TrangThai(i), MaSP(i)
    $stmt->bind_param(
      'sssissdsissii',
      $TenSP,
      $SoSeriesSP,
      $MieuTaSP,
      $NamSX,
      $XuatXu,
      $ThoiGianBaoHanhDinhKy,
      $DonGia,
      $loaiphutung,
      $nhasanxuat_MaNSX,
      $SoLanBaoHanhToiDa,
      $HinhAnh,
      $TrangThai,
      $MaSP_int
    );
    return $stmt->execute();
  }

  // Bật/tắt trạng thái
  public function updateStatus($MaSP, $TrangThai)
  {
    $stmt = $this->conn->prepare("UPDATE phutungxemay SET TrangThai=? WHERE MaSP=?");
    $stmt->bind_param("ii", $TrangThai, $MaSP);
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