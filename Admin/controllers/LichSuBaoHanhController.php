<?php
require_once __DIR__ . '/../models/LichSuBaoHanhModel.php';
require_once __DIR__ . '/../models/XeMayModel.php';
require_once __DIR__ . '/../models/ChiTietHoaDonModel.php';

class LichSuBaoHanhController
{
    private $model;
    private $xeMayModel;
    private $chiTietHoaDonModel;

    public function __construct($db)
    {
        $this->model = new LichSuBaoHanhModel($db);
        $this->xeMayModel = new XeMayModel($db);
        $this->chiTietHoaDonModel = new ChiTietHoaDonModel($db);
    }

    public function index()
    {
        $list = $this->model->getAll();
        ob_start();
        require __DIR__ . '/../views/lichsubaohanh/list.php';
        return ob_get_clean();
    }

    public function add()
    {
        $listXe = $this->xeMayModel->getAll();
        $error = '';
        $item = [];

        // Gán mã xe mặc định nếu có trên URL
        if (isset($_GET['xemay_MaXE'])) {
            $item['xemay_MaXE'] = $_GET['xemay_MaXE'];
        }

        // Lấy danh sách chi tiết hóa đơn còn bảo hành cho xe này
        $listCTHD = [];
        if (!empty($item['xemay_MaXE'])) {
            $listCTHD = $this->chiTietHoaDonModel->getListConBaoHanh($item['xemay_MaXE']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Dữ liệu chung lấy từ form
            $tenBHDK = $_POST['TenBHDK'];
            $ngay = $_POST['Ngay'];
            $loaiBH = $_POST['LoaiBaoHanh'];
            $ttTruoc = $_POST['ThongTinTruocBaoHanh'] ?? '';
            $ttSau = $_POST['ThongTinSauBaoHanh'] ?? '';
            $maXe = $_POST['xemay_MaXE'];

            $selectedCTHDs = $_POST['chitiethoadon_MaCTHD'] ?? [];
            $err_bh = [];
            $ok = 0;

            if (empty($selectedCTHDs)) {
                $error = 'Vui lòng chọn ít nhất một phụ tùng cần bảo hành!';
            } else {
                foreach ($selectedCTHDs as $maCTHD) {
                    // Lấy series và kiểm tra số lượt còn lại
                    $maSeries = $this->chiTietHoaDonModel->getSeriesByMaCTHD($maCTHD);
                    $solan = $this->chiTietHoaDonModel->getSoLanBaoHanhConLai($maCTHD);
                    if ($solan > 0) {
                        $item = [
                            'TenBHDK' => $tenBHDK,
                            'Ngay' => $ngay,
                            'LoaiBaoHanh' => $loaiBH,
                            'ThongTinTruocBaoHanh' => $ttTruoc,
                            'ThongTinSauBaoHanh' => $ttSau,
                            'xemay_MaXE' => $maXe,
                            'chitiethoadon_MaCTHD' => $maCTHD,
                            'MaSeriesSP' => $maSeries
                        ];
                        if ($this->model->add($item)) {
                            $this->chiTietHoaDonModel->truSoLanBaoHanh($maCTHD);
                            $ok++;
                        }
                    } else {
                        $err_bh[] = "Phụ tùng mã $maCTHD đã hết lượt bảo hành!";
                    }
                }
                if ($ok > 0) {
                    header('Location: ?controller=lichsubaohanh&action=index');
                    exit;
                } else {
                    $error = implode("<br>", $err_bh);
                }
            }
        }

        ob_start();
        require __DIR__ . '/../views/lichsubaohanh/add.php';
        return ob_get_clean();
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        $item = $this->model->getById($id);
        $listXe = $this->xeMayModel->getAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = [
                'TenBHDK' => $_POST['TenBHDK'],
                'Ngay' => $_POST['Ngay'],
                'LoaiBaoHanh' => $_POST['LoaiBaoHanh'],
                'ThongTinTruocBaoHanh' => $_POST['ThongTinTruocBaoHanh'] ?? '',
                'ThongTinSauBaoHanh' => $_POST['ThongTinSauBaoHanh'] ?? '',
                'xemay_MaXE' => $_POST['xemay_MaXE'],
            ];
            if ($this->model->update($id, $item)) {
                header('Location: ?controller=lichsubaohanh&action=index');
                exit;
            } else {
                $error = 'Cập nhật thất bại!';
            }
        }

        ob_start();
        require __DIR__ . '/../views/lichsubaohanh/edit.php';
        return ob_get_clean();
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($this->model->delete($id)) {
            header('Location: ?controller=lichsubaohanh&action=index');
            exit;
        } else {
            echo 'Xóa thất bại!';
        }
    }

    public function ajaxByXe()
    {
        $maXe = $_GET['xemay_MaXE'] ?? null;
        $list = $this->model->getByXe($maXe);
        $xemay_MaXE = $maXe;
        require_once __DIR__ . '/../views/ajax_lichsu_baohanh.php';
    }
}
?>