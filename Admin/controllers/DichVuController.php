<?php
require_once __DIR__ . '/../models/DichVuModel.php';

class DichVuController
{
  private $model;

  public function __construct($db)
  {
    $this->model = new DichVuModel($db);
  }

  public function index()
  {
    $dichvus = $this->model->getAll();
    include __DIR__ . '/../views/dichvu/list.php';
  }

  public function add()
  {
    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $DonGia = floatval($_POST['DonGia']);
      if ($DonGia <= 0) {
        $error = "Đơn giá phải lớn hơn 0!";
      } else {
        // Xử lý upload ảnh
        $hinhanh = "";
        if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == UPLOAD_ERR_OK) {
          $target_dir = "uploads/";
          if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
          $ext = pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION);
          $file_name = uniqid('dv_') . '.' . $ext;
          $target_file = $target_dir . $file_name;
          move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target_file);
          $hinhanh = $target_file;
        }

        $data = [
          'TenDV' => $_POST['TenDV'],
          'HinhAnh' => $hinhanh,
          'DonGia' => $DonGia,
        ];
        if ($this->model->add($data)) {
          header("Location: ?controller=dichvu&action=index");
          exit;
        } else {
          $error = "Thêm dịch vụ thất bại!";
        }
      }
    }
    include __DIR__ . '/../views/dichvu/add.php';
  }

  public function edit()
  {
    $error = "";
    $id = $_GET['id'] ?? null;
    $dichvu = $this->model->getById($id);
    if (!$dichvu) {
      echo "Không tìm thấy dịch vụ!";
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $DonGia = floatval($_POST['DonGia']);
      if ($DonGia <= 0) {
        $error = "Đơn giá phải lớn hơn 0!";
      } else {
        // Xử lý upload ảnh (nếu có file mới thì cập nhật)
        $hinhanh = $dichvu['HinhAnh'];
        if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == UPLOAD_ERR_OK) {
          $target_dir = "uploads/";
          if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
          $ext = pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION);
          $file_name = uniqid('dv_') . '.' . $ext;
          $target_file = $target_dir . $file_name;
          move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target_file);
          $hinhanh = $target_file;
        }

        $data = [
          'TenDV' => $_POST['TenDV'],
          'HinhAnh' => $hinhanh,
          'DonGia' => $DonGia,
        ];
        if ($this->model->update($id, $data)) {
          header("Location: ?controller=dichvu&action=index");
          exit;
        } else {
          $error = "Cập nhật dịch vụ thất bại!";
        }
      }
    }
    include __DIR__ . '/../views/dichvu/edit.php';
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;
    if ($id && $this->model->delete($id)) {
      header("Location: ?controller=dichvu&action=index");
      exit;
    } else {
      echo "Xóa dịch vụ thất bại!";
    }
  }
}