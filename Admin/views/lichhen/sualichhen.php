<?php
// KHÔNG require model ở đây nữa!
// Các biến $lichhen, $khachhangs, $nhanviens, $xemays được truyền từ controller
?>
<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4 position-relative">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0 fw-bold">Sửa lịch hẹn</h5>
      <a href="?controller=lichhen" class="btn btn-secondary">
        <i class="fa fa-list"></i> Danh sách
      </a>
    </div>
    <form method="post">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Mã xe máy</label>
          <select name="xemay_MaXE" id="xemay_MaXE" class="form-select" required>
            <option value="">-- Chọn xe máy --</option>
            <?php foreach($xemays as $xe): ?>
              <option
                value="<?=$xe['MaXE']?>"
                <?=$lichhen['xemay_MaXE']==$xe['MaXE']?'selected':''?>
                data-tenxe="<?=htmlspecialchars($xe['TenXe'])?>"
                data-loaixe="<?=htmlspecialchars($xe['LoaiXe'])?>"
                data-phankhuc="<?=htmlspecialchars($xe['PhanKhuc'])?>"
                data-makh="<?=$xe['khachhang_MaKH']?>"
              >
                <?=$xe['MaXE']?> - <?=htmlspecialchars($xe['TenXe'])?> (<?=htmlspecialchars($xe['BienSoXe'])?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Tên xe</label>
          <input required name="TenXe" class="form-control" value="<?=htmlspecialchars($lichhen['TenXe'])?>" placeholder="Tên xe" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Loại xe</label>
          <input required name="LoaiXe" class="form-control" value="<?=htmlspecialchars($lichhen['LoaiXe'])?>" placeholder="Loại xe" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Phân khúc</label>
          <input required name="PhanKhuc" class="form-control" value="<?=htmlspecialchars($lichhen['PhanKhuc'])?>" placeholder="Phân khúc" readonly>
        </div>
        <div class="col-md-4">
          <label class="form-label">Ngày hẹn</label>
          <input required type="date" name="NgayHen" class="form-control"
            value="<?=htmlspecialchars($lichhen['NgayHen'])?>"
            min="<?=date('Y-m-d')?>">
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
          <select name="nhanvien_MaNV" class="form-select" required>
            <option value="">-- Chọn nhân viên --</option>
            <?php foreach($nhanviens as $nv): ?>
              <option value="<?=$nv['MaNV']?>" <?=$lichhen['nhanvien_MaNV']==$nv['MaNV']?'selected':''?>>
                <?=htmlspecialchars($nv['TenNV'])?> (Mã: <?=$nv['MaNV']?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Khách hàng (Mã KH)</label>
          <select name="khachhang_MaKH" id="khachhang_MaKH" class="form-select" required>
            <option value="">-- Chọn khách hàng --</option>
            <?php foreach($khachhangs as $kh): ?>
              <option value="<?=$kh['MaKH']?>" <?=$lichhen['khachhang_MaKH']==$kh['MaKH']?'selected':''?>>
                <?=htmlspecialchars($kh['TenKH'])?> (Mã: <?=$kh['MaKH']?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Lưu</button>
        <a href="?controller=lichhen" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
      </div>
    </form>
    <!-- Nút tạo hóa đơn góc phải dưới, truyền đúng mã xe vào link -->
    <a href="/QuanLyBaoDuongXe/Admin/hoadon.php?controller=hoadon&action=add&xemay_MaXE=<?=urlencode($lichhen['xemay_MaXE'])?>"
       class="btn btn-primary"
       style="position: absolute; bottom: 16px; right: 16px; z-index: 10;">
      <i class="fa fa-file-invoice"></i> Tạo hóa đơn
    </a>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Khi chọn xe máy, tự động điền Tên xe, Loại xe, Phân khúc
$('#xemay_MaXE').change(function() {
  let $option = $(this).find('option:selected');
  $('input[name="TenXe"]').val($option.data('tenxe') || '');
  $('input[name="LoaiXe"]').val($option.data('loaixe') || '');
  $('input[name="PhanKhuc"]').val($option.data('phankhuc') || '');
});
// Lọc xe máy theo khách hàng khi thay đổi khách hàng
$('#khachhang_MaKH').change(function() {
  let makh = $(this).val();
  $('#xemay_MaXE option').each(function(){
    let xeMaKH = $(this).data('makh');
    if(!xeMaKH || makh == '' || xeMaKH == makh) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
  $('#xemay_MaXE').val('');
  $('input[name="TenXe"]').val('');
  $('input[name="LoaiXe"]').val('');
  $('input[name="PhanKhuc"]').val('');
});
</script>