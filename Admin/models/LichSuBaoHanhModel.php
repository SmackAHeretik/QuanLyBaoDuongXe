<?php
class LichSuBaoHanhModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT lsb.*, xm.TenXe, xm.BienSoXe
            FROM lichsubaohanh lsb
            LEFT JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
            ORDER BY lsb.Ngay DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($maBHDK)
    {
        $stmt = $this->db->prepare("
            SELECT lsb.*, xm.TenXe, xm.BienSoXe
            FROM lichsubaohanh lsb
            LEFT JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
            WHERE lsb.MaBHDK = ?
        ");
        $stmt->execute([$maBHDK]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByXe($maXe)
    {
        $stmt = $this->db->prepare("
            SELECT lsb.*, xm.TenXe, xm.BienSoXe
            FROM lichsubaohanh lsb
            LEFT JOIN xemay xm ON lsb.xemay_MaXE = xm.MaXE
            WHERE lsb.xemay_MaXE = ?
            ORDER BY lsb.Ngay DESC
        ");
        $stmt->execute([$maXe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO lichsubaohanh 
            (TenBHDK, Ngay, LoaiBaoHanh, MaSeriesSP, ThongTinTruocBaoHanh, ThongTinSauBaoHanh, xemay_MaXE, chitiethoadon_MaCTHD)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['TenBHDK'],
            $data['Ngay'],
            $data['LoaiBaoHanh'],
            $data['MaSeriesSP'] ?? null,
            $data['ThongTinTruocBaoHanh'] ?? '',
            $data['ThongTinSauBaoHanh'] ?? '',
            $data['xemay_MaXE'],
            $data['chitiethoadon_MaCTHD'] ?? null,
        ]);
    }

    public function update($maBHDK, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE lichsubaohanh
            SET 
                TenBHDK = ?, 
                Ngay = ?, 
                LoaiBaoHanh = ?, 
                MaSeriesSP = ?, 
                ThongTinTruocBaoHanh = ?, 
                ThongTinSauBaoHanh = ?, 
                xemay_MaXE = ?, 
                chitiethoadon_MaCTHD = ?
            WHERE MaBHDK = ?
        ");
        return $stmt->execute([
            $data['TenBHDK'],
            $data['Ngay'],
            $data['LoaiBaoHanh'],
            $data['MaSeriesSP'] ?? null,
            $data['ThongTinTruocBaoHanh'] ?? '',
            $data['ThongTinSauBaoHanh'] ?? '',
            $data['xemay_MaXE'],
            $data['chitiethoadon_MaCTHD'] ?? null,
            $maBHDK
        ]);
    }

    public function delete($maBHDK)
    {
        $stmt = $this->db->prepare("DELETE FROM lichsubaohanh WHERE MaBHDK = ?");
        return $stmt->execute([$maBHDK]);
    }
}
?>