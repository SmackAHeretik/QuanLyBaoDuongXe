<?php
require_once __DIR__ . '/../models/PhuTungXeMayModel.php';
require_once __DIR__ . '/../models/NhaSanXuatModel.php';

class PhuTungXeMayController
{
  private $model;
  private $nsxModel;

  public function __construct()
  {
    $this->model = new PhuTungXeMayModel();
    $this->nsxModel = new NhaSanXuatModel();
  }

  // Hiển thị danh sách phụ tùng
  public function list()
  {
    $data = $this->model->getAll();
    $success = $_SESSION['success'] ?? '';
    unset($_SESSION['success']);
    $error = $_SESSION['error'] ?? '';
    unset($_SESSION['error']);

    $content = __DIR__ . '/../views/phutungxemay/list.php';
    include __DIR__ . '/../views/phutungxemay/layout.php';
  }

  // Hiển thị form thêm & xử lý thêm mới
  public function add()
  {
    $error = "";
    $listNSX = $this->nsxModel->getAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Gán giá trị cho tất cả biến từ POST, tránh lỗi unassigned
      $TenSP = $_POST['TenSP'] ?? '';
      $SoSeriesSP = $_POST['SoSeriesSP'] ?? '';
      $MieuTaSP = $_POST['MieuTaSP'] ?? '';
      $NamSX = $_POST['NamSX'] ?? '';
      $XuatXu = $_POST['XuatXu'] ?? '';
      $loaiphutung = $_POST['loaiphutung'] ?? '';
      $nhasanxuat_MaNSX = $_POST['nhasanxuat_MaNSX'] ?? '';
      $SoLanBaoHanhToiDa = $_POST['SoLanBaoHanhToiDa'] ?? '';
      $DonGia = $_POST['DonGia'] ?? 0;

      // Xử lý ngày bảo hành định kỳ
      $ngay = $_POST['ngay'] ?? '';
      $thang = $_POST['thang'] ?? '';
      $nam = $_POST['nam'] ?? '';
      $count = 0;
      if ($ngay)
        $count++;
      if ($thang)
        $count++;
      if ($nam)
        $count++;
      if ($count < 1) {
        $error = "Phải nhập ít nhất 1 trong các trường Ngày, Tháng, Năm cho Thời gian bảo hành định kỳ!";
      } else {
        $ThoiGianBaoHanhDinhKy = sprintf('%04d-%02d-%02d', $nam ? $nam : 0, $thang ? $thang : 1, $ngay ? $ngay : 1);
      }

      if ($DonGia <= 0) {
        $error = "Đơn giá phải lớn hơn 0!";
      }

      // Xử lý upload hình ảnh
      $HinhAnh = '';
      if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == 0 && is_uploaded_file($_FILES['HinhAnh']['tmp_name'])) {
        $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
        $fileName = $_FILES['HinhAnh']['name'];
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName); // tránh trùng tên và ký tự lạ
        $dest_path = __DIR__ . '/../uploads/' . $fileName;
        if (!is_dir(__DIR__ . '/../uploads')) {
          mkdir(__DIR__ . '/../uploads', 0777, true);
        }
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
          $HinhAnh = 'uploads/' . $fileName;
        } else {
          $error = "Lỗi upload file hình ảnh!";
        }
      }

      if (!$error) {
        $data = [
          'TenSP' => $TenSP,
          'SoSeriesSP' => $SoSeriesSP,
          'MieuTaSP' => $MieuTaSP,
          'NamSX' => $NamSX,
          'XuatXu' => $XuatXu,
          'ThoiGianBaoHanhDinhKy' => $ThoiGianBaoHanhDinhKy,
          'DonGia' => $DonGia,
          'loaiphutung' => $loaiphutung,
          'nhasanxuat_MaNSX' => $nhasanxuat_MaNSX,
          'SoLanBaoHanhToiDa' => $SoLanBaoHanhToiDa,
          'HinhAnh' => $HinhAnh
        ];
        $result = $this->model->add($data);

        if ($result) {
          $_SESSION['success'] = "Thêm phụ tùng thành công!";
        } else {
          $_SESSION['error'] = "Thêm phụ tùng thất bại!";
        }
        header("Location: ?action=list");
        exit;
      }
    }

    $content = __DIR__ . '/../views/phutungxemay/add.php';
    include __DIR__ . '/../views/phutungxemay/layout.php';
  }

  // Hiển thị form sửa & xử lý cập nhật
  public function edit()
  {
    $error = "";
    $MaSP = $_GET['id'] ?? null;
    $item = $this->model->getById($MaSP);
    $listNSX = $this->nsxModel->getAll();

    if (!$item) {
      echo "Không tìm thấy sản phẩm";
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Gán giá trị cho tất cả biến từ POST
      $TenSP = $_POST['TenSP'] ?? '';
      $SoSeriesSP = $_POST['SoSeriesSP'] ?? '';
      $MieuTaSP = $_POST['MieuTaSP'] ?? '';
      $NamSX = $_POST['NamSX'] ?? '';
      $XuatXu = $_POST['XuatXu'] ?? '';
      $loaiphutung = $_POST['loaiphutung'] ?? '';
      $nhasanxuat_MaNSX = $_POST['nhasanxuat_MaNSX'] ?? '';
      $SoLanBaoHanhToiDa = $_POST['SoLanBaoHanhToiDa'] ?? '';
      $DonGia = $_POST['DonGia'] ?? 0;

      $ngay = $_POST['ngay'] ?? '';
      $thang = $_POST['thang'] ?? '';
      $nam = $_POST['nam'] ?? '';
      $count = 0;
      if ($ngay)
        $count++;
      if ($thang)
        $count++;
      if ($nam)
        $count++;
      if ($count < 1) {
        $error = "Phải nhập ít nhất 1 trong các trường Ngày, Tháng, Năm cho Thời gian bảo hành định kỳ!";
      } else {
        $ThoiGianBaoHanhDinhKy = sprintf('%04d-%02d-%02d', $nam ? $nam : 0, $thang ? $thang : 1, $ngay ? $ngay : 1);
      }

      if ($DonGia <= 0) {
        $error = "Đơn giá phải lớn hơn 0!";
      }

      // Xử lý upload hình ảnh (nếu có)
      $HinhAnh = $item['HinhAnh'] ?? '';
      if (
        isset($_FILES['HinhAnh']) &&
        $_FILES['HinhAnh']['error'] == 0 &&
        is_uploaded_file($_FILES['HinhAnh']['tmp_name'])
      ) {
        $fileTmpPath = $_FILES['HinhAnh']['tmp_name'];
        $fileName = $_FILES['HinhAnh']['name'];
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName);
        $dest_path = __DIR__ . '/../uploads/' . $fileName;
        if (!is_dir(__DIR__ . '/../uploads')) {
          mkdir(__DIR__ . '/../uploads', 0777, true);
        }
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
          $HinhAnh = 'uploads/' . $fileName;
        } else {
          $error = "Lỗi upload file hình ảnh!";
        }
      }

      if (!$error) {
        $data = [
          'TenSP' => $TenSP,
          'SoSeriesSP' => $SoSeriesSP,
          'MieuTaSP' => $MieuTaSP,
          'NamSX' => $NamSX,
          'XuatXu' => $XuatXu,
          'ThoiGianBaoHanhDinhKy' => $ThoiGianBaoHanhDinhKy,
          'DonGia' => $DonGia,
          'loaiphutung' => $loaiphutung,
          'nhasanxuat_MaNSX' => $nhasanxuat_MaNSX,
          'SoLanBaoHanhToiDa' => $SoLanBaoHanhToiDa,
          'HinhAnh' => $HinhAnh
        ];
        $result = $this->model->update($MaSP, $data);

        if ($result) {
          $_SESSION['success'] = "Cập nhật phụ tùng thành công!";
        } else {
          $_SESSION['error'] = "Cập nhật phụ tùng thất bại!";
        }
        header("Location: ?action=list");
        exit;
      }
    }

    $content = __DIR__ . '/../views/phutungxemay/edit.php';
    include __DIR__ . '/../views/phutungxemay/layout.php';
  }

  // Xóa phụ tùng
  public function delete()
  {
    $MaSP = $_GET['id'] ?? null;
    if ($MaSP) {
      $result = $this->model->delete($MaSP);
      if ($result) {
        $_SESSION['success'] = "Xóa phụ tùng thành công!";
      } else {
        $_SESSION['error'] = "Xóa phụ tùng thất bại!";
      }
    }
    header("Location: ?action=list");
    exit;
  }
}
?>