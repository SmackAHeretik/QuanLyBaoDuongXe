<?php
require_once __DIR__ . '/../models/HoaDonModel.php';

class HoaDonController
{
  private $model;

  public function __construct($db)
  {
    $this->model = new HoaDonModel($db);
  }

  public function index()
  {
    $hoadons = $this->model->getAll();
    include __DIR__ . '/../views/hoadon/list.php';
  }

  public function add()
  {
    $error = "";
    $xemays = $this->model->getAllXeMayWithKhachHang();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $TongTien = floatval($_POST['TongTien']);
      if ($TongTien <= 0) {
        $error = "Tổng tiền phải lớn hơn 0!";
      } else {
        $data = [
          'TongTien' => $TongTien,
          'Ngay' => $_POST['Ngay'],
          'TrangThai' => $_POST['TrangThai'],
          'xemay_MaXE' => $_POST['xemay_MaXE'],
        ];
        if ($this->model->add($data)) {
          header("Location: khachhang.php");
          exit;
        } else {
          $error = "Thêm hóa đơn thất bại!";
        }
      }
    }
    include __DIR__ . '/../views/hoadon/add.php';
  }

  public function edit()
  {
    $error = "";
    $id = $_GET['id'] ?? null;
    $hoadon = $this->model->getById($id);
    $xemays = $this->model->getAllXeMayWithKhachHang();
    if (!$hoadon) {
      echo "Không tìm thấy hóa đơn!";
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $TongTien = floatval($_POST['TongTien']);
      if ($TongTien <= 0) {
        $error = "Tổng tiền phải lớn hơn 0!";
      } else {
        $data = [
          'TongTien' => $TongTien,
          'Ngay' => $_POST['Ngay'],
          'TrangThai' => $_POST['TrangThai'],
          'xemay_MaXE' => $_POST['xemay_MaXE'],
        ];
        if ($this->model->update($id, $data)) {
          header("Location: khachhang.php");
          exit;
        } else {
          $error = "Cập nhật hóa đơn thất bại!";
        }
      }
    }
    include __DIR__ . '/../views/hoadon/edit.php';
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;
    if ($id && $this->model->delete($id)) {
      header("Location: khachhang.php");
      exit;
    } else {
      echo "Xóa hóa đơn thất bại!";
    }
  }
}
?>