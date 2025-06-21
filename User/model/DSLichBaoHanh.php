<?php
class DSLichBaoHanh
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=quanlybaoduongxe;charset=utf8', 'root', '');
    }

    // Lấy tất cả lịch bảo hành (từ bảng lichhen, phân loại = 1)
    public function getAllBaoHanh()
    {
        $sql = "SELECT lh.MaLH, 
                       lh.NgayHen AS Ngay,
                       lh.PhanLoai,
                       lh.ThoiGianCa,
                       nv.TenNV AS TenNhanVien,
                       xm.TenXe,
                       xm.BienSoXe,
                       lh.MoTaLyDo AS ThongTinTruocBaoHanh
                FROM lichhen lh
                LEFT JOIN xemay xm ON lh.xemay_MaXE = xm.MaXE
                LEFT JOIN nhanvien nv ON lh.nhanvien_MaNV = nv.MaNV
                WHERE lh.PhanLoai = 1
                ORDER BY lh.NgayHen DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lịch bảo hành của 1 khách hàng (từ bảng lichhen, phân loại = 1)
    public function getBaoHanhByKhachHang($maKH)
    {
        $sql = "SELECT lh.MaLH, 
                       lh.NgayHen AS Ngay,
                       lh.PhanLoai,
                       lh.ThoiGianCa,
                       nv.TenNV AS TenNhanVien,
                       xm.TenXe,
                       xm.BienSoXe,
                       lh.MoTaLyDo AS ThongTinTruocBaoHanh
                FROM lichhen lh
                LEFT JOIN xemay xm ON lh.xemay_MaXE = xm.MaXE
                LEFT JOIN nhanvien nv ON lh.nhanvien_MaNV = nv.MaNV
                WHERE lh.PhanLoai = 1
                  AND lh.khachhang_MaKH = ?
                ORDER BY lh.NgayHen DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>