<?php
require_once __DIR__ . '/../utils/ConnectDb.php';

class UserModel {
    private $TenKH;
    private $Email;
    private $MatKhau;
    private $SDT;

    public function __construct($TenKH = '', $Email = '', $MatKhau = '', $SDT = '') {
        $this->TenKH = $TenKH;
        $this->Email = $Email;
        $this->MatKhau = $MatKhau;
        $this->SDT = $SDT;
    }

    public function get_TenKH() { return $this->TenKH; }
    public function get_Email() { return $this->Email; }
    public function get_MatKhau() { return $this->MatKhau; }
    public function get_SDT() { return $this->SDT; }

    // Hàm chèn dữ liệu vào bảng khachhang
    public function insert($TenKH, $Email, $MatKhau, $SDT) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "INSERT INTO khachhang (TenKH, Email, MatKhau, SDT) VALUES (:TenKH, :Email, :MatKhau, :SDT)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':TenKH', $TenKH);
        $stmt->bindParam(':Email', $Email);
        $stmt->bindParam(':MatKhau', $MatKhau);
        $stmt->bindParam(':SDT', $SDT);

        $stmt->execute();
    }

    // Kiểm tra xem tên khách hàng đã tồn tại chưa
    public function existsByTenKH($TenKH) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT COUNT(*) FROM khachhang WHERE TenKH = :TenKH";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':TenKH', $TenKH);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    // Kiểm tra xem email đã tồn tại chưa
    public function existsByEmail($Email) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT COUNT(*) FROM khachhang WHERE Email = :Email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Email', $Email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    // Tìm khách hàng theo email
    public function findByEmail($Email) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT * FROM khachhang WHERE Email = :Email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Email', $Email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        return $result;
    }

    // Tìm khách hàng theo ID
    public function findById($MaKH) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT * FROM khachhang WHERE MaKH = :MaKH";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':MaKH', $MaKH);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        return $result;
    }
    public function findByName($TenKH) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();
    
        $sql = "SELECT * FROM khachhang WHERE TenKH = :TenKH";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':TenKH', $TenKH);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return false;
        }
        return $result;
    }
    // Cập nhật thông tin khách hàng
    public function update($MaKH, $TenKH, $Email, $SDT, $DiaChi, $MatKhau = null) {
        try {
            $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
            $conn = $dbConn->connect();

            if ($MatKhau) {
                $hashedPassword = password_hash($MatKhau, PASSWORD_DEFAULT);
                $sql = "UPDATE khachhang SET TenKH = :TenKH, Email = :Email, SDT = :SDT, DiaChi = :DiaChi, MatKhau = :MatKhau WHERE MaKH = :MaKH";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':MatKhau', $hashedPassword);
            } else {
                $sql = "UPDATE khachhang SET TenKH = :TenKH, Email = :Email, SDT = :SDT, DiaChi = :DiaChi WHERE MaKH = :MaKH";
                $stmt = $conn->prepare($sql);
            }

            $stmt->bindParam(':TenKH', $TenKH);
            $stmt->bindParam(':Email', $Email);
            $stmt->bindParam(':SDT', $SDT);
            $stmt->bindParam(':DiaChi', $DiaChi);
            $stmt->bindParam(':MaKH', $MaKH);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating customer: " . $e->getMessage());
        }
    }
}
?>