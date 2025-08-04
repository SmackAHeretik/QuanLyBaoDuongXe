<?php
class BikeProfileModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Kiểm tra trùng số khung hoặc số máy (chỉ kiểm tra khi không NULL/rỗng)
    public function isExistedSoKhungOrSoMay($SoKhung, $SoMay)
    {
        $sql = "SELECT 1 FROM xemay 
                WHERE 
                    ((:sokhung IS NOT NULL AND :sokhung != '' AND SoKhung = :sokhung) 
                    OR (:somay IS NOT NULL AND :somay != '' AND SoMay = :somay))
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':sokhung' => $SoKhung,
            ':somay' => $SoMay
        ]);
        return $stmt->fetch() ? true : false;
    }

    // Thêm xe (có cả số khung, số máy)
    public function addBike($data)
    {
        $sql = "INSERT INTO xemay (TenXe, LoaiXe, PhanKhuc, BienSoXe, SoKhung, SoMay, HinhAnhMatTruocXe, HinhAnhMatSauXe, khachhang_MaKH)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['TenXe'],
            $data['LoaiXe'],
            $data['PhanKhuc'],
            $data['BienSoXe'],
            $data['SoKhung'],
            $data['SoMay'],
            $data['HinhAnhMatTruocXe'],
            $data['HinhAnhMatSauXe'],
            $data['khachhang_MaKH']
        ]);
    }

    // Lấy danh sách xe theo khách hàng
    public function getBikesByCustomerId($customerId)
    {
        $sql = "SELECT * FROM xemay WHERE khachhang_MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$customerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 xe theo mã
    public function getBikeById($bikeId)
    {
        $sql = "SELECT * FROM xemay WHERE MaXE = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$bikeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Xóa xe (xóa luôn lịch hẹn liên quan)
    public function deleteBike($bikeId)
    {
        $this->conn->prepare("DELETE FROM lichhen WHERE xemay_MaXE = ?")->execute([$bikeId]);
        $sql = "DELETE FROM xemay WHERE MaXE = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$bikeId]);
    }

    // User cập nhật xe KHÔNG được sửa số khung, số máy
    public function updateBikeUser($data)
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

    // Admin cập nhật xe (có thể sửa số khung, số máy)
    public function updateBikeAdmin($data)
    {
        $sql = "UPDATE xemay SET TenXe = ?, LoaiXe = ?, PhanKhuc = ?, BienSoXe = ?, SoKhung = ?, SoMay = ?, HinhAnhMatTruocXe = ?, HinhAnhMatSauXe = ?
                WHERE MaXe = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['TenXe'],
            $data['LoaiXe'],
            $data['PhanKhuc'],
            $data['BienSoXe'],
            $data['SoKhung'],
            $data['SoMay'],
            $data['HinhAnhMatTruocXe'],
            $data['HinhAnhMatSauXe'],
            $data['MaXe']
        ]);
    }
}