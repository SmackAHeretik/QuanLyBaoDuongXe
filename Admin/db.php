<?php
function connectDB()
{
  $conn = new mysqli('localhost', 'root', '', 'quanlybaoduongxe');
  if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
  }
  $conn->set_charset("utf8mb4");
  return $conn;
}
?>