<?php
require_once __DIR__ . '/../models/NhaSanXuatModel.php';

class NhaSanXuatController
{
  private $model;

  public function __construct()
  {
    $this->model = new NhaSanXuatModel();
  }

  // Hiển thị danh sách nhà sản xuất
  public function list()
  {
    $dsNSX = $this->model->getAll();

    $success = $_SESSION['success'] ?? '';
    unset($_SESSION['success']);
    $error = $_SESSION['error'] ?? '';
    unset($_SESSION['error']);

    $content = __DIR__ . '/../views/nhasanxuat/list.php';
    include __DIR__ . '/../views/nhasanxuat/layout.php';
  }

  // Thêm mới nhà sản xuất
  public function add()
  {
    $error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $TenNhaSX = $_POST['TenNhaSX'] ?? '';
      $XuatXu = $_POST['XuatXu'] ?? '';
      $MoTa = $_POST['MoTa'] ?? '';

      if (empty($TenNhaSX)) {
        $error = "Tên nhà sản xuất không được để trống!";
      }

      if (!$error) {
        $data = [
          'TenNhaSX' => $TenNhaSX,
          'XuatXu' => $XuatXu,
          'MoTa' => $MoTa
        ];

        $result = $this->model->add($data);
        if ($result) {
          $_SESSION['success'] = "Thêm nhà sản xuất thành công!";
        } else {
          $_SESSION['error'] = "Thêm nhà sản xuất thất bại!";
        }
        header("Location: ?action=list");
        exit;
      }
    }

    $content = __DIR__ . '/../views/nhasanxuat/add.php';
    include __DIR__ . '/../views/nhasanxuat/layout.php';
  }

  // Sửa nhà sản xuất
  public function edit()
  {
    $error = "";
    $MaNSX = $_GET['id'] ?? null;
    $item = $this->model->getById($MaNSX);

    if (!$item) {
      echo "Không tìm thấy nhà sản xuất!";
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $TenNhaSX = $_POST['TenNhaSX'] ?? '';
      $XuatXu = $_POST['XuatXu'] ?? '';
      $MoTa = $_POST['MoTa'] ?? '';

      if (empty($TenNhaSX)) {
        $error = "Tên nhà sản xuất không được để trống!";
      }

      if (!$error) {
        $data = [
          'TenNhaSX' => $TenNhaSX,
          'XuatXu' => $XuatXu,
          'MoTa' => $MoTa
        ];

        $result = $this->model->update($MaNSX, $data);
        if ($result) {
          $_SESSION['success'] = "Cập nhật thành công!";
        } else {
          $_SESSION['error'] = "Cập nhật thất bại!";
        }
        header("Location: ?action=list");
        exit;
      }
    }

    $content = __DIR__ . '/../views/nhasanxuat/edit.php';
    include __DIR__ . '/../views/nhasanxuat/layout.php';
  }

  // Xóa nhà sản xuất
  public function delete()
  {
    $MaNSX = $_GET['id'] ?? null;

    if ($MaNSX) {
      $result = $this->model->delete($MaNSX);
      if ($result) {
        $_SESSION['success'] = "Xóa thành công!";
      } else {
        $_SESSION['error'] = "Xóa thất bại!";
      }
    }
    header("Location: ?action=list");
    exit;
  }
}
