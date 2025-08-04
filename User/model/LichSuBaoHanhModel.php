<?php
class LichSuBaoHanhModel
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Lấy lịch sử bảo hành tất cả xe của một khách hàng
    public function getByUser($maKH)
    {
        $stmt = $this->db->prepare("
            SELECT lsb.*, xm.TenXe, xm.BienSoXe
            FROM lichsubaohanh lsb
            INNER JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
            WHERE xm.khachhang_MaKH = ?
            ORDER BY lsb.Ngay DESC
        ");
        $stmt->execute([$maKH]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>