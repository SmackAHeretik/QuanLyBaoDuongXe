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
      $TienKhuyenMai = $_POST['TienKhuyenMai'] === "" ? 0 : floatval($_POST['TienKhuyenMai']);
      $TienSauKhiGiam = $TongTien - $TienKhuyenMai;
      if ($TienSauKhiGiam < 0)
        $TienSauKhiGiam = 0;

      if ($TongTien <= 0) {
        $error = "Tổng tiền phải lớn hơn 0!";
      } elseif ($TienKhuyenMai < 0) {
        $error = "Tiền khuyến mãi không được nhỏ hơn 0!";
      } elseif ($TienSauKhiGiam <= 0) {
        $error = "Tiền sau khi giảm phải lớn hơn 0!";
      } else {
        $data = [
          'TongTien' => $TongTien,
          'Ngay' => $_POST['Ngay'],
          'TrangThai' => $_POST['TrangThai'],
          'TienKhuyenMai' => $TienKhuyenMai,
          'TienSauKhiGiam' => $TienSauKhiGiam,
          'xemay_MaXE' => $_POST['xemay_MaXE'],
        ];
        if ($this->model->add($data)) {
          header("Location: ?controller=hoadon&action=index");
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
      $TienKhuyenMai = $_POST['TienKhuyenMai'] === "" ? 0 : floatval($_POST['TienKhuyenMai']);
      $TienSauKhiGiam = $TongTien - $TienKhuyenMai;
      if ($TienSauKhiGiam < 0)
        $TienSauKhiGiam = 0;

      if ($TongTien <= 0) {
        $error = "Tổng tiền phải lớn hơn 0!";
      } elseif ($TienKhuyenMai < 0) {
        $error = "Tiền khuyến mãi không được nhỏ hơn 0!";
      } elseif ($TienSauKhiGiam <= 0) {
        $error = "Tiền sau khi giảm phải lớn hơn 0!";
      } else {
        $data = [
          'TongTien' => $TongTien,
          'Ngay' => $_POST['Ngay'],
          'TrangThai' => $_POST['TrangThai'],
          'TienKhuyenMai' => $TienKhuyenMai,
          'TienSauKhiGiam' => $TienSauKhiGiam,
          'xemay_MaXE' => $_POST['xemay_MaXE'],
        ];
        if ($this->model->update($id, $data)) {
          header("Location: ?controller=hoadon&action=index");
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
      header("Location: ?controller=hoadon&action=index");
      exit;
    } else {
      echo "Xóa hóa đơn thất bại!";
    }
  }
}