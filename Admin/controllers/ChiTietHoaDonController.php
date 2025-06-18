<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/ChiTietHoaDonModel.php';
require_once __DIR__ . '/../models/HoaDonModel.php';
require_once __DIR__ . '/../models/PhuTungXeMayModel.php';
require_once __DIR__ . '/../models/DichVuModel.php';

class ChiTietHoaDonController
{
  private $model;
  private $hoadonModel;
  private $phutungModel;
  private $dichvuModel;

  public function __construct($pdo)
  {
    $this->model = new ChiTietHoaDonModel($pdo);
    $this->hoadonModel = new HoaDonModel($pdo);
    $this->phutungModel = new PhuTungXeMayModel($pdo);
    $this->dichvuModel = new DichVuModel($pdo);
  }

  public function list()
  {
    $dsChiTietHD = $this->model->getAll();
    include __DIR__ . '/../views/chitiethoadon/list.php';
  }

  public function add()
  {
    $listHD = $this->hoadonModel->getAll();
    $listPT = $this->phutungModel->getAll();
    $listDV = $this->dichvuModel->getAll();
    $error = '';
    $data = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data['hoadon_MaHD'] = $_POST['hoadon_MaHD'] ?? '';
      $data['phutungxemay_MaSP'] = $_POST['phutungxemay_MaSP'] ?? '';
      $data['dichvu_MaDV'] = $_POST['dichvu_MaDV'] ?? '';
      $data['SoLuong'] = $_POST['SoLuong'] ?? 0;
      $data['NgayBDBH'] = $_POST['NgayBDBH'] ?? null;
      $data['NgayKTBH'] = $_POST['NgayKTBH'] ?? null;
      $data['SoLanDaBaoHanh'] = $_POST['SoLanDaBaoHanh'] ?? 0;

      // Validate so luong
      if (!is_numeric($data['SoLuong']) || $data['SoLuong'] < 0) {
        $error = "Số lượng phải >= 0";
      }

      // Lấy giá tiền từ hóa đơn, không cho nhập tay
      $hd = $this->hoadonModel->getById($data['hoadon_MaHD']);
      $data['GiaTien'] = $hd['TienSauKhiGiam'] ?? 0;

      if (!$error) {
        $this->model->add($data);
        header('Location: ?controller=chitiethoadon&action=list');
        exit;
      }
    }
    include __DIR__ . '/../views/chitiethoadon/add.php';
  }

  public function edit()
  {
    $id = $_GET['id'] ?? null;
    $listHD = $this->hoadonModel->getAll();
    $listPT = $this->phutungModel->getAll();
    $listDV = $this->dichvuModel->getAll();
    $error = '';
    $data = $this->model->getById($id);

    if (!$data) {
      echo "<div class='alert alert-danger'>Không tìm thấy chi tiết hóa đơn!</div>";
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data['hoadon_MaHD'] = $_POST['hoadon_MaHD'] ?? '';
      $data['phutungxemay_MaSP'] = $_POST['phutungxemay_MaSP'] ?? '';
      $data['dichvu_MaDV'] = $_POST['dichvu_MaDV'] ?? '';
      $data['SoLuong'] = $_POST['SoLuong'] ?? 0;
      $data['NgayBDBH'] = $_POST['NgayBDBH'] ?? null;
      $data['NgayKTBH'] = $_POST['NgayKTBH'] ?? null;
      $data['SoLanDaBaoHanh'] = $_POST['SoLanDaBaoHanh'] ?? 0;

      // Validate so luong
      if (!is_numeric($data['SoLuong']) || $data['SoLuong'] < 0) {
        $error = "Số lượng phải >= 0";
      }

      // Lấy giá tiền từ hóa đơn, không cho nhập tay
      $hd = $this->hoadonModel->getById($data['hoadon_MaHD']);
      $data['GiaTien'] = $hd['TienSauKhiGiam'] ?? 0;

      if (!$error) {
        $this->model->update($id, $data);
        header('Location: ?controller=chitiethoadon&action=list');
        exit;
      }
    }
    include __DIR__ . '/../views/chitiethoadon/edit.php';
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;
    if ($id) {
      $this->model->delete($id);
    }
    header('Location: ?controller=chitiethoadon&action=list');
    exit;
  }
}
?>