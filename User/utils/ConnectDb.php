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
            $conn = new PDO('mysql:host=' . $this->servername . ';dbname=' . $this->dbname . ';charset=utf8', $this->username, $this->password);
            // Thiết lập chế độ lỗi của PDO thành ngoại lệ
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // Ghi lỗi vào file log và hiển thị thông báo chung chung
            error_log("Connection failed: " . $e->getMessage(), 3, 'errors.log');
            throw new Exception("Không thể kết nối cơ sở dữ liệu.");
        }
    }

    // Phương thức kiểm tra kết nối
    public function testConnection()
    {
        try {
            $this->connect();
            return "Kết nối cơ sở dữ liệu thành công!";
        } catch (Exception $e) {
            return "Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage();
        }
    }
}
?>