<?php
class LichHenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=quanlybaoduongxe;charset=utf8', 'root', '');
    }

    public function getNhanVienRanh($datetime)
    {
        $sql = "
            SELECT nv.MaNV, nv.TenNV
            FROM nhanvien nv
            WHERE nv.MaNV NOT IN (
                SELECT llv.nhanvien_MaNV
                FROM lichlamviec llv
                JOIN calamviec cav ON llv.calamviec_MaCaV = cav.MaCaV
                WHERE (? BETWEEN cav.ThoiGianBD AND cav.ThoiGianKT)
                AND llv.TrangThai = 'on'
            )
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$datetime]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function daCoLichTrung($makh, $manv, $ngayhen)
    {
        $giohen = date('Y-m-d H:i:s', strtotime($ngayhen));
        $start = date('Y-m-d H:i:s', strtotime($giohen) - 3 * 3600);
        $end = date('Y-m-d H:i:s', strtotime($giohen) + 3 * 3600);

        $sql = "SELECT COUNT(*) FROM lichhen
                WHERE lichen_khachhang_MaKH = ? 
                  AND lichen_nhanvien_MaNV = ?
                  AND NgayHen BETWEEN ? AND ?
                  AND TrangThai IN ('pending','confirmed')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$makh, $manv, $start, $end]);
        return $stmt->fetchColumn() > 0;
    }

    public function nhanVienDaCoLichTrung($manv, $ngayhen)
    {
        $giohen = date('Y-m-d H:i:s', strtotime($ngayhen));
        $start = date('Y-m-d H:i:s', strtotime($giohen) - 3 * 3600);
        $end = date('Y-m-d H:i:s', strtotime($giohen) + 3 * 3600);

        $sql = "SELECT COUNT(*) FROM lichhen
                WHERE lichen_nhanvien_MaNV = ?
                  AND NgayHen BETWEEN ? AND ?
                  AND TrangThai IN ('pending','confirmed')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manv, $start, $end]);
        return $stmt->fetchColumn() > 0;
    }

    public function luuLichHen($ngayhen, $manv, $makh, $mota, $loaixe)
    {
        var_dump($makh); // ngay trước khi insert
        $sql = "INSERT INTO lichhen (NgayHen, TrangThai, lichen_nhanvien_MaNV, lichen_khachhang_MaKH, MoTaLyDoHen, LoaiXe)
                VALUES (?, 'pending', ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$ngayhen, $manv, $makh, $mota, $loaixe]);
    }

    public function getLichHenByKhachHang($makh)
    {
        $sql = "SELECT lh.*, nv.TenNV 
                FROM lichhen lh 
                LEFT JOIN nhanvien nv ON lh.lichen_nhanvien_MaNV = nv.MaNV
                WHERE lh.lichen_khachhang_MaKH = :makh 
                ORDER BY lh.NgayHen DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':makh', $makh, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getLichById($malich)
    {
        $stmt = $this->db->prepare("SELECT * FROM lichhen WHERE MaLich = ?");
        $stmt->execute([$malich]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTrangThai($malich, $trangthai)
    {
        $stmt = $this->db->prepare("UPDATE lichhen SET TrangThai = ? WHERE MaLich = ?");
        return $stmt->execute([$trangthai, $malich]);
    }
}

?>