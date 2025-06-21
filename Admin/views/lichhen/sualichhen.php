<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0 fw-bold">Sửa lịch hẹn</h5>
      <a href="?controller=lichhen" class="btn btn-secondary">
        <i class="fa fa-list"></i> Danh sách
      </a>
    </div>
    <form method="post">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Tên xe</label>
          <input required name="TenXe" class="form-control" value="<?=htmlspecialchars($lichhen['TenXe'])?>" placeholder="Tên xe">
        </div>
        <div class="col-md-4">
          <label class="form-label">Loại xe</label>
          <input required name="LoaiXe" class="form-control" value="<?=htmlspecialchars($lichhen['LoaiXe'])?>" placeholder="Loại xe">
        </div>
        <div class="col-md-4">
          <label class="form-label">Phân khúc</label>
          <input required name="PhanKhuc" class="form-control" value="<?=htmlspecialchars($lichhen['PhanKhuc'])?>" placeholder="Phân khúc">
        </div>

        <div class="col-md-4">
          <label class="form-label">Ngày hẹn</label>
          <input required type="date" name="NgayHen" class="form-control" value="<?=htmlspecialchars($lichhen['NgayHen'])?>" placeholder="Ngày hẹn">
        </div>
        <div class="col-md-4">
          <label class="form-label">Thời gian ca</label>
          <input required name="ThoiGianCa" class="form-control" value="<?=htmlspecialchars($lichhen['ThoiGianCa'])?>" placeholder="Thời gian ca">
        </div>
        <div class="col-md-4">
          <label class="form-label">Trạng thái</label>
          <select name="TrangThai" class="form-select" required>
            <option value="cho duyet" <?=$lichhen['TrangThai']=='cho duyet'?'selected':''?>>Chờ duyệt</option>
            <option value="da duyet" <?=$lichhen['TrangThai']=='da duyet'?'selected':''?>>Đã duyệt</option>
            <option value="huy" <?=$lichhen['TrangThai']=='huy'?'selected':''?>>Đã hủy</option>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Mô tả lý do</label>
          <textarea name="MoTaLyDo" class="form-control" placeholder="Mô tả lý do"><?=htmlspecialchars($lichhen['MoTaLyDo'])?></textarea>
        </div>

        <div class="col-md-4">
          <label class="form-label">Nhân viên (Mã NV)</label>
          <input required name="nhanvien_MaNV" class="form-control" value="<?=htmlspecialchars($lichhen['nhanvien_MaNV'])?>" placeholder="Mã NV">
        </div>
        <div class="col-md-4">
          <label class="form-label">Khách hàng (Mã KH)</label>
          <input required name="khachhang_MaKH" class="form-control" value="<?=htmlspecialchars($lichhen['khachhang_MaKH'])?>" placeholder="Mã KH">
        </div>
        <div class="col-md-4">
          <label class="form-label">Xe máy (Mã XE)</label>
          <input required name="xemay_MaXE" class="form-control" value="<?=htmlspecialchars($lichhen['xemay_MaXE'])?>" placeholder="Mã xe máy">
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Lưu</button>
        <a href="?controller=lichhen" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
      </div>
    </form>
  </div>
</div>