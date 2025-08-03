<?php
require_once __DIR__ . '/../models/HoaDonModel.php';
require_once __DIR__ . '/../models/ChiTietHoaDonModel.php';
require_once __DIR__ . '/../models/DichVuModel.php';

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
    $phutungxemay = $this->model->getAllPhuTung();
    $dichvuModel = new DichVuModel($this->model->conn);
    $dichvus = $dichvuModel->getAll();

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
          $mahd = $this->model->getLastInsertId();
          $cthdModel = new ChiTietHoaDonModel($this->model->conn);
          if (!empty($_POST['phutung_MaSP']) || !empty($_POST['dichvu_MaDV'])) {
            $pt_arr = $_POST['phutung_MaSP'];
            $dv_arr = $_POST['dichvu_MaDV'];
            $gia_arr = $_POST['phutung_GiaTien'];
            $sl_arr  = $_POST['phutung_SoLuong'];
            $count = count($pt_arr);
            for ($i = 0; $i < $count; $i++) {
              $masp = $pt_arr[$i] ?: null;
              $madichvu = $dv_arr[$i] ?: null;
              if (empty($masp) && empty($madichvu)) continue;
              $cthdModel->add([
                'hoadon_MaHD' => $mahd,
                'phutungxemay_MaSP' => $masp,
                'dichvu_MaDV' => $madichvu,
                'GiaTien' => $gia_arr[$i],
                'SoLuong' => $sl_arr[$i],
                'NgayBDBH' => null,
                'NgayKTBH' => null,
                'SoLanDaBaoHanh' => 0
              ]);
            }
          }
          header("Location: chitiethoadon.php?hoadon_MaHD=$mahd");
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
    $phutungxemay = $this->model->getAllPhuTung();
    $dichvuModel = new DichVuModel($this->model->conn);
    $dichvus = $dichvuModel->getAll();
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