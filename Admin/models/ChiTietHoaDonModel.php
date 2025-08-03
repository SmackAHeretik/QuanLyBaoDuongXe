<?php
class ChiTietHoaDonModel
{
    private $conn;

    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

  // Lấy tất cả chi tiết của 1 hóa đơn, kèm tên phụ tùng và tên dịch vụ
  public function getAllByHoaDon($mahd)
  {
    $stmt = $this->conn->prepare("
        SELECT cthd.*, pt.TenSP, dv.TenDV
        FROM chitiethoadon cthd
        LEFT JOIN phutungxemay pt ON cthd.phutungxemay_MaSP = pt.MaSP
        LEFT JOIN dichvu dv ON cthd.dichvu_MaDV = dv.MaDV
        WHERE cthd.hoadon_MaHD = ?
        ORDER BY cthd.MaCTHD DESC
    ");
    $stmt->execute([$mahd]);
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

    // Lấy danh sách chi tiết hóa đơn còn bảo hành cho 1 xe máy
    public function getListConBaoHanh($maXe)
    {
        $stmt = $this->conn->prepare("
            SELECT cthd.*, pt.TenSP, pt.SoSeriesSP
            FROM chitiethoadon cthd
            JOIN hoadon hd ON cthd.hoadon_MaHD = hd.MaHD
            JOIN phutungxemay pt ON cthd.phutungxemay_MaSP = pt.MaSP
            WHERE hd.xemay_MaXE = ? AND cthd.SoLanDaBaoHanh > 0
        ");
        $stmt->execute([$maXe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy số lần bảo hành còn lại của 1 chi tiết hóa đơn
    public function getSoLanBaoHanhConLai($maCTHD)
    {
        $stmt = $this->conn->prepare("SELECT SoLanDaBaoHanh FROM chitiethoadon WHERE MaCTHD = ?");
        $stmt->execute([$maCTHD]);
        return (int)$stmt->fetchColumn();
    }

    // Trừ số lần bảo hành còn lại
    public function truSoLanBaoHanh($maCTHD)
    {
        $stmt = $this->conn->prepare("UPDATE chitiethoadon SET SoLanDaBaoHanh = SoLanDaBaoHanh - 1 WHERE MaCTHD = ? AND SoLanDaBaoHanh > 0");
        return $stmt->execute([$maCTHD]);
    }

    // Lấy SoSeriesSP từ bảng phutungxemay dựa trên phutungxemay_MaSP của chitiethoadon
    public function getSeriesByMaCTHD($maCTHD)
    {
        $stmt = $this->conn->prepare("
            SELECT pt.SoSeriesSP
            FROM chitiethoadon cthd
            JOIN phutungxemay pt ON cthd.phutungxemay_MaSP = pt.MaSP
            WHERE cthd.MaCTHD = ?
        ");
        $stmt->execute([$maCTHD]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row && array_key_exists('SoSeriesSP', $row)) ? $row['SoSeriesSP'] : null;
    }
}
?>