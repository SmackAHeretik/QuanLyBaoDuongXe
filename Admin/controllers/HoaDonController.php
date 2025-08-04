<?php
require_once __DIR__ . '/../models/HoaDonModel.php';
require_once __DIR__ . '/../models/ChiTietHoaDonModel.php';
require_once __DIR__ . '/../models/DichVuModel.php';
require_once __DIR__ . '/../models/PhuTungXeMayModel.php';

class HoaDonController
{
  public $model;
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
    $phutungModel = new PhuTungXeMayModel($this->model->conn);

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
            $count = max(count($pt_arr), count($dv_arr));
            for ($i = 0; $i < $count; $i++) {
              $masp = $pt_arr[$i] ?: null;
              $madichvu = $dv_arr[$i] ?: null;
              if (empty($masp) && empty($madichvu)) continue;
              $NgayBDBH = null;
              $NgayKTBH = null;
              $SoLanDaBaoHanh = 0;
              if (!empty($masp)) {
                $pt = $phutungModel->getById($masp);
                // Ngày bắt đầu bảo hành là ngày tạo hóa đơn (lấy theo ngày nhập trên form, giờ thực tế)
                $NgayBDBH = date('Y-m-d H:i:s', strtotime($_POST['Ngay'] . ' ' . date('H:i:s')));
                // Xử lý số ngày bảo hành từ chuỗi "xxx ngày"
                $soNgay = 0;
                if (!empty($pt['ThoiGianBaoHanhDinhKy'])) {
                  if (preg_match('/(\d+)\s*ngày/i', $pt['ThoiGianBaoHanhDinhKy'], $matches)) {
                    $soNgay = intval($matches[1]);
                  }
                }
                if ($soNgay > 0) {
                  $NgayKTBH = date('Y-m-d H:i:s', strtotime("+$soNgay days", strtotime($NgayBDBH)));
                }
                // Số lần bảo hành tối đa lấy từ bảng phụ tùng
                $SoLanDaBaoHanh = intval($pt['SoLanBaoHanhToiDa']);
              }
              $cthdModel->add([
                'hoadon_MaHD' => $mahd,
                'phutungxemay_MaSP' => $masp,
                'dichvu_MaDV' => $madichvu,
                'GiaTien' => $gia_arr[$i],
                'SoLuong' => $sl_arr[$i],
                'NgayBDBH' => $NgayBDBH,
                'NgayKTBH' => $NgayKTBH,
                'SoLanDaBaoHanh' => $SoLanDaBaoHanh
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
    $id = $_GET['id'] ?? null;
    $error = "";
    if ($id) {
      $hoadon = $this->model->getById($id);
      $xemays = $this->model->getAllXeMayWithKhachHang();
      $phutungxemay = $this->model->getAllPhuTung();
      $dichvuModel = new DichVuModel($this->model->conn);
      $dichvus = $dichvuModel->getAll();
      $phutungModel = new PhuTungXeMayModel($this->model->conn);
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
            header("Location: hoadon.php");
            exit;
          } else {
            $error = "Cập nhật hóa đơn thất bại!";
          }
        }
      }
      include __DIR__ . '/../views/hoadon/edit.php';
    } else {
      echo "<div class='alert alert-danger'>Không tìm thấy hóa đơn!</div>";
    }
  }

  public function delete()
  {
    $id = $_GET['id'] ?? null;
    if ($id) {
      $this->model->delete($id);
      header("Location: hoadon.php");
      exit;
    } else {
      echo "<div class='alert alert-danger'>Không tìm thấy hóa đơn cần xóa!</div>";
    }
  }
}
?>