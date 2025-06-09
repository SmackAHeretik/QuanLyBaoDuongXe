<?php
require_once __DIR__ . '/../model/LichHenModel.php';

class LichHenController
{
  public function nhanvienRon()
  {
    if (!isset($_POST['datetime'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Thiếu dữ liệu']);
      exit;
    }
    $datetime = $_POST['datetime'];
    $model = new LichHenModel();
    $dsNhanVien = $model->getNhanVienRanh($datetime);
    header('Content-Type: application/json');
    echo json_encode($dsNhanVien);
    exit;
  }

  public function datLichForm()
  {
    require_once __DIR__ . '/../layouts/contact/contact.php';
  }
}
?>