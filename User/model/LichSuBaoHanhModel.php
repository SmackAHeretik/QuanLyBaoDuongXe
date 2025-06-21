<?php
class LichSuBaoHanhModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=quanlybaoduongxe;charset=utf8', 'root', '');
    }

    // Thêm mới lịch bảo hành
    public function insertBaoHanh($TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE)
    {
        $sql = "INSERT INTO lichsubaohanh (TenBHDK, Ngay, LoaiBaoHanh, xemay_MaXE)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE]);
    }

    // Lấy tất cả lịch bảo hành
    public function getAllBaoHanh()
    {
        $sql = "SELECT lsb.*, xm.TenXe, xm.BienSoXe
                FROM lichsubaohanh lsb
                LEFT JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
                ORDER BY lsb.Ngay DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lịch bảo hành theo khách hàng
    public function getBaoHanhByKhachHang($maKH)
    {
        $sql = "SELECT lsb.*, xm.TenXe, xm.BienSoXe
                FROM lichsubaohanh lsb
                JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
                WHERE xm.khachhang_MaKH = ?
                ORDER BY lsb.Ngay DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lịch bảo hành theo mã
    public function getBaoHanhById($maBHDK)
    {
        $sql = "SELECT lsb.*, xm.TenXe, xm.BienSoXe
                FROM lichsubaohanh lsb
                LEFT JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
                WHERE lsb.MaBHDK = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maBHDK]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật lịch bảo hành
    public function updateBaoHanh($maBHDK, $TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE)
    {
        $sql = "UPDATE lichsubaohanh
                SET TenBHDK = ?, Ngay = ?, LoaiBaoHanh = ?, xemay_MaXE = ?
                WHERE MaBHDK = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE, $maBHDK]);
    }

    // Xóa lịch bảo hành
    public function deleteBaoHanh($maBHDK)
    {
        $sql = "DELETE FROM lichsubaohanh WHERE MaBHDK = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$maBHDK]);
    }
    public function insertBaoHanhFull($TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE, $ThongTinTruocBaoHanh)
    {
        $sql = "INSERT INTO lichsubaohanh (TenBHDK, Ngay, LoaiBaoHanh, xemay_MaXE, ThongTinTruocBaoHanh)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE, $ThongTinTruocBaoHanh]);
    }
     
}
?>