<?php
class XeMayModel
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT xm.*, kh.TenKH
                FROM xemay xm
                LEFT JOIN khachhang kh ON xm.khachhang_MaKH = kh.MaKH
                ORDER BY xm.MaXE DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($MaXE)
    {
        $stmt = $this->conn->prepare("SELECT * FROM xemay WHERE MaXE = ?");
        $stmt->execute([$MaXE]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả khách hàng cho dropdown
    public function getAllKhachHang()
    {
        $sql = "SELECT * FROM khachhang ORDER BY TenKH";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data)
    {
        $sql = "INSERT INTO xemay (TenXe, LoaiXe, PhanKhuc, BienSoXe, HinhAnhMatTruocXe, HinhAnhMatSauXe, khachhang_MaKH)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['TenXe'],
            $data['LoaiXe'],
            $data['PhanKhuc'],
            $data['BienSoXe'],
            $data['HinhAnhMatTruocXe'],
            $data['HinhAnhMatSauXe'],
            $data['khachhang_MaKH']
        ]);
    }

    public function update($MaXE, $data)
    {
        $sql = "UPDATE xemay SET TenXe=?, LoaiXe=?, PhanKhuc=?, BienSoXe=?, HinhAnhMatTruocXe=?, HinhAnhMatSauXe=?, khachhang_MaKH=?
                WHERE MaXE=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['TenXe'],
            $data['LoaiXe'],
            $data['PhanKhuc'],
            $data['BienSoXe'],
            $data['HinhAnhMatTruocXe'],
            $data['HinhAnhMatSauXe'],
            $data['khachhang_MaKH'],
            $MaXE
        ]);
    }

    public function delete($MaXE)
    {
        $stmt = $this->conn->prepare("DELETE FROM xemay WHERE MaXE=?");
        return $stmt->execute([$MaXE]);
    }
}