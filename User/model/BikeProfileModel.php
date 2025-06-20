<?php
class BikeProfileModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addBike($data)
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

    public function getBikesByCustomerId($customerId)
    {
        $sql = "SELECT * FROM xemay WHERE khachhang_MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$customerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBikeById($bikeId)
    {
        $sql = "SELECT * FROM xemay WHERE MaXE = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bikeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteBike($bikeId)
    {
        $sql = "DELETE FROM xemay WHERE MaXe = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$bikeId]);
    }

    public function updateBike($data)
    {
        $sql = "UPDATE xemay SET TenXe = ?, LoaiXe = ?, PhanKhuc = ?, BienSoXe = ?, HinhAnhMatTruocXe = ?, HinhAnhMatSauXe = ?
                WHERE MaXe = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['TenXe'],
            $data['LoaiXe'],
            $data['PhanKhuc'],
            $data['BienSoXe'],
            $data['HinhAnhMatTruocXe'],
            $data['HinhAnhMatSauXe'],
            $data['MaXe']
        ]);
    }
}