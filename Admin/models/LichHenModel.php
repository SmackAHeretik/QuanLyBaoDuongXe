<?php
class LichHenModel
{
    private $conn;
    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

    public function getAllLichHen()
    {
        $sql = "SELECT * FROM lichhen WHERE PhanLoai = 1 ORDER BY NgayHen DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllLichBaoHanh()
    {
        $sql = "SELECT * FROM lichhen WHERE PhanLoai = 2 ORDER BY NgayHen DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>