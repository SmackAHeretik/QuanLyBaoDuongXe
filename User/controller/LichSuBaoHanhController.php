<?php
require_once __DIR__ . '/../model/LichSuBaoHanhModel.php';

class LichSuBaoHanhController
{
    // Thêm mới
    public function luuLichBaoHanh()
    {
        // ... như trước ...
    }

    // Lấy tất cả lịch bảo hành
    public function danhSachBaoHanh()
    {
        $model = new LichSuBaoHanhModel();
        $list = $model->getAllBaoHanh();
        include __DIR__ . '/../view/baohanh_list.php';
    }

    // Lấy lịch bảo hành của khách hàng
    public function lichBaoHanhCuaToi($maKH)
    {
        $model = new LichSuBaoHanhModel();
        $list = $model->getBaoHanhByKhachHang($maKH);
        include __DIR__ . '/../view/baohanh_cuatoi.php';
    }

    // Xem chi tiết
    public function chiTietBaoHanh($maBHDK)
    {
        $model = new LichSuBaoHanhModel();
        $item = $model->getBaoHanhById($maBHDK);
        include __DIR__ . '/../view/baohanh_detail.php';
    }

    // Sửa
    public function suaBaoHanh($maBHDK, $data)
    {
        $model = new LichSuBaoHanhModel();
        $model->updateBaoHanh($maBHDK, $data['TenBHDK'], $data['Ngay'], $data['LoaiBaoHanh'], $data['xemay_MaXE']);
        // Redirect hoặc load lại view
    }

    // Xóa
    public function xoaBaoHanh($maBHDK)
    {
        $model = new LichSuBaoHanhModel();
        $model->deleteBaoHanh($maBHDK);
        // Redirect hoặc load lại view
    }
}
?>