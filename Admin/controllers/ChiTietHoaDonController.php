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
    $mahd = $_GET['hoadon_MaHD'] ?? null;
    if ($mahd) {
        $dsChiTietHD = $this->model->getAllByHoaDon($mahd);
    } else {
        $dsChiTietHD = [];
    }
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

      // Xác định giá tiền theo loại: dịch vụ hoặc phụ tùng
      if (!empty($data['phutungxemay_MaSP'])) {
        $pt = $this->phutungModel->getById($data['phutungxemay_MaSP']);
        $data['GiaTien'] = $pt['DonGia'] ?? 0;
      } elseif (!empty($data['dichvu_MaDV'])) {
        $dv = $this->dichvuModel->getById($data['dichvu_MaDV']);
        $data['GiaTien'] = $dv['DonGia'] ?? 0;
      } else {
        $data['GiaTien'] = 0;
      }

      if (!$error) {
        $this->model->add($data);
        header('Location: ?controller=chitiethoadon&action=list&hoadon_MaHD=' . $data['hoadon_MaHD']);
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

      // Xác định giá tiền theo loại: dịch vụ hoặc phụ tùng
      if (!empty($data['phutungxemay_MaSP'])) {
        $pt = $this->phutungModel->getById($data['phutungxemay_MaSP']);
        $data['GiaTien'] = $pt['DonGia'] ?? 0;
      } elseif (!empty($data['dichvu_MaDV'])) {
        $dv = $this->dichvuModel->getById($data['dichvu_MaDV']);
        $data['GiaTien'] = $dv['DonGia'] ?? 0;
      } else {
        $data['GiaTien'] = 0;
      }

      if (!$error) {
        $this->model->update($id, $data);
        header('Location: ?controller=chitiethoadon&action=list&hoadon_MaHD=' . $data['hoadon_MaHD']);
        exit;
      }
    }
    include __DIR__ . '/../views/chitiethoadon/edit.php';
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;
    $mahd = null;
    if ($id) {
      $row = $this->model->getById($id);
      $mahd = $row ? $row['hoadon_MaHD'] : null;
      $this->model->delete($id);
    }
    header('Location: ?controller=chitiethoadon&action=list' . ($mahd ? '&hoadon_MaHD='.$mahd : ''));
    exit;
  }
}
?>