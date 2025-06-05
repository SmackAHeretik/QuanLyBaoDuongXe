<?php
/**
 * Lớp kết nối cơ sở dữ liệu
 */
class ConnectDb
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    // Hàm khởi tạo để thiết lập thông tin kết nối cơ sở dữ liệu
    public function __construct($servername = "localhost:3306", $username = "root", $password = "", $dbname = "quanlybaoduongxe")
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    // Phương thức để kết nối cơ sở dữ liệu
    public function connect()
    {
        try {
            // Tạo kết nối PDO mới
            $conn = new PDO('mysql:host=' . $this->servername . ';dbname=' . $this->dbname, $this->username, $this->password);
            // Thiết lập chế độ lỗi của PDO thành ngoại lệ
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query('set names utf8');
            return $conn;
        } catch (PDOException $e) {
            // In ra lỗi kết nối nếu có
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>
