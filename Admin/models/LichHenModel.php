<?php
class LichHenModel {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function getAll() {
        $sql = "SELECT lh.*, nv.TenNV, kh.TenKH, xe.TenXe FROM lichhen lh
            LEFT JOIN nhanvien nv ON lh.nhanvien_MaNV = nv.MaNV
            LEFT JOIN khachhang kh ON lh.khachhang_MaKH = kh.MaKH
            LEFT JOIN xemay xe ON lh.xemay_MaXE = xe.MaXE";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByNhanVien($maNV) {
        $sql = "SELECT lh.*, nv.TenNV, kh.TenKH, xe.TenXe 
            FROM lichhen lh
            LEFT JOIN nhanvien nv ON lh.nhanvien_MaNV = nv.MaNV
            LEFT JOIN khachhang kh ON lh.khachhang_MaKH = kh.MaKH
            LEFT JOIN xemay xe ON lh.xemay_MaXE = xe.MaXE
            WHERE lh.nhanvien_MaNV = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maNV]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM lichhen WHERE MaLH=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function insert($data) {
        $stmt = $this->db->prepare("INSERT INTO lichhen (TenXe, LoaiXe, PhanKhuc, NgayHen, ThoiGianCa, TrangThai, MoTaLyDo, nhanvien_MaNV, khachhang_MaKH, xemay_MaXE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['TenXe'], $data['LoaiXe'], $data['PhanKhuc'],
            $data['NgayHen'], $data['ThoiGianCa'], $data['TrangThai'],
            $data['MoTaLyDo'], $data['nhanvien_MaNV'], $data['khachhang_MaKH'], $data['xemay_MaXE']
        ]);
    }
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE lichhen SET TenXe=?, LoaiXe=?, PhanKhuc=?, NgayHen=?, ThoiGianCa=?, TrangThai=?, MoTaLyDo=?, nhanvien_MaNV=?, khachhang_MaKH=?, xemay_MaXE=? WHERE MaLH=?");
        return $stmt->execute([
            $data['TenXe'], $data['LoaiXe'], $data['PhanKhuc'],
            $data['NgayHen'], $data['ThoiGianCa'], $data['TrangThai'],
            $data['MoTaLyDo'], $data['nhanvien_MaNV'], $data['khachhang_MaKH'], $data['xemay_MaXE'],
            $id
        ]);
    }
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM lichhen WHERE MaLH=?");
        return $stmt->execute([$id]);
    }
}

class KhachHangModel {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll() {
        return $this->db->query("SELECT * FROM khachhang")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM khachhang WHERE MaKH=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class XeModel {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getByKhachHang($maKH) {
        $stmt = $this->db->prepare("SELECT * FROM xemay WHERE khachhang_MaKH=?");
        $stmt->execute([$maKH]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM xemay WHERE MaXE=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

class NhanVienModel {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll() {
        return $this->db->query("SELECT * FROM nhanvien")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE MaNV=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>