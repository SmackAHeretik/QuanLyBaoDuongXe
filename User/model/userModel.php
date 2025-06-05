<?php
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

    // Hàm sinh mã khách hàng dạng KH001, KH002...
    public function generateMaKH() {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT MaKH FROM khachhang ORDER BY MaKH DESC LIMIT 1";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $lastMaKH = $stm->fetchColumn();

        if ($lastMaKH) {
            $number = intval(substr($lastMaKH, 2)) + 1;
            return 'KH' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            return 'KH001';
        }
    }

    // Insert sẽ tự sinh MaKH
    public function insert($TenKH, $Email, $MatKhau, $SDT) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();
        $MaKH = $this->generateMaKH();

        $sql = "INSERT INTO khachhang (MaKH, TenKH, Email, MatKhau, SDT) 
                VALUES (:MaKH, :TenKH, :Email, :MatKhau, :SDT)";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':MaKH', $MaKH);
        $stm->bindParam(':TenKH', $TenKH);
        $stm->bindParam(':Email', $Email);
        $stm->bindParam(':MatKhau', $MatKhau);
        $stm->bindParam(':SDT', $SDT);

        if ($stm->execute()) {
            echo "<script>alert('Tài khoản đăng ký thành công!'); window.location = '../login.php';</script>";
        } else {
            echo "<script>alert('Đăng ký thất bại.'); window.location = '../login.php';</script>";
        }
    }

    public function findByEmail($email) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT * FROM khachhang WHERE Email = :Email";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':Email', $email);
        $stm->execute();

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function existsByEmail($Email) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT COUNT(*) FROM khachhang WHERE Email = :Email";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':Email', $Email);
        $stm->execute();

        return $stm->fetchColumn() > 0;
    }

    public function existsByTenKH($TenKH) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT COUNT(*) FROM khachhang WHERE TenKH = :TenKH";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':TenKH', $TenKH);
        $stm->execute();

        return $stm->fetchColumn() > 0;
    }

    public function update($MaKH, $TenKH, $Email, $SDT) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "UPDATE khachhang SET TenKH = :TenKH, Email = :Email, SDT = :SDT WHERE MaKH = :MaKH";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':TenKH', $TenKH);
        $stm->bindParam(':Email', $Email);
        $stm->bindParam(':SDT', $SDT);
        $stm->bindParam(':MaKH', $MaKH);
        return $stm->execute();
    }

    public function updatePassword($email, $new_password) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "UPDATE khachhang SET MatKhau = :new_password WHERE Email = :Email";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':new_password', $new_password);
        $stm->bindParam(':Email', $email);
        $stm->execute();
    }

    public function storeResetToken($email, $token) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "UPDATE khachhang SET reset_token = :token WHERE Email = :Email";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':token', $token);
        $stm->bindParam(':Email', $email);
        $stm->execute();
    }

    public function findByResetToken($token) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "SELECT * FROM khachhang WHERE reset_token = :token";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':token', $token);
        $stm->execute();

        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function clearResetToken($email) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();

        $sql = "UPDATE khachhang SET reset_token = NULL WHERE Email = :Email";
        $stm = $conn->prepare($sql);
        $stm->bindParam(':Email', $email);
        $stm->execute();
    }
    public function findById($MaKH) {
        $dbConn = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
        $conn = $dbConn->connect();
    
        $sql = "SELECT * FROM khachhang WHERE MaKH = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$MaKH]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}
?>