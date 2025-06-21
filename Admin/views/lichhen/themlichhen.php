<?php
require_once __DIR__ . '/../../models/LichHenModel.php';
$db = connectDB();
$khachhangModel = new KhachHangModel($db);
$nhanvienModel = new NhanVienModel($db);
$khachhangs = $khachhangModel->getAll();
$nhanviens  = $nhanvienModel->getAll();
?>
<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4">
    <h5 class="mb-4">Thêm mới lịch hẹn / lịch bảo dưỡng</h5>
    <!-- Popup thông báo -->
    <div id="popupMsg" style="display:none;position:fixed;top:30px;left:50%;transform:translateX(-50%);z-index:9999;" class="alert"></div>
    <form method="post" id="formLichHen" autocomplete="off">
      <div class="row g-3">

        <!-- Chọn khách hàng -->
        <div class="col-md-4">
          <label for="khachhang_MaKH" class="form-label">Khách hàng</label>
          <select required id="khachhang_MaKH" name="khachhang_MaKH" class="form-select">
            <option value="">-- Chọn khách hàng --</option>
            <?php foreach($khachhangs as $kh): ?>
              <option value="<?= $kh['MaKH'] ?>"><?= htmlspecialchars($kh['TenKH']) ?> (Mã: <?= $kh['MaKH'] ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Chọn mã xe máy của khách -->
        <div class="col-md-4">
          <label for="xemay_MaXE" class="form-label">Mã xe máy</label>
          <select required id="xemay_MaXE" name="xemay_MaXE" class="form-select">
            <option value="">-- Chọn mã xe --</option>
            <!-- Sẽ được load động bằng JS -->
          </select>
        </div>

        <!-- Các trường tự động điền -->
        <div class="col-md-4">
          <label for="TenXe" class="form-label">Tên xe</label>
          <input required readonly id="TenXe" name="TenXe" class="form-control" placeholder="Tên xe">
        </div>
        <div class="col-md-4">
          <label for="LoaiXe" class="form-label">Loại xe</label>
          <input required readonly id="LoaiXe" name="LoaiXe" class="form-control" placeholder="Loại xe">
        </div>
        <div class="col-md-4">
          <label for="PhanKhuc" class="form-label">Phân khúc</label>
          <input required readonly id="PhanKhuc" name="PhanKhuc" class="form-control" placeholder="Phân khúc">
        </div>

        <!-- Mã nhân viên -->
        <div class="col-md-4">
          <label for="nhanvien_MaNV" class="form-label">Nhân viên</label>
          <select required id="nhanvien_MaNV" name="nhanvien_MaNV" class="form-select">
            <option value="">-- Chọn nhân viên --</option>
            <?php foreach($nhanviens as $nv): ?>
              <option value="<?= $nv['MaNV'] ?>"><?= htmlspecialchars($nv['TenNV']) ?> (Mã: <?= $nv['MaNV'] ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Ngày hẹn -->
        <div class="col-md-4">
          <label for="NgayHen" class="form-label">Ngày hẹn</label>
          <input required type="date" id="NgayHen" name="NgayHen" class="form-control">
        </div>

        <!-- Thời gian ca (người nhập) -->
        <div class="col-md-4">
          <label for="ThoiGianCa" class="form-label">Thời gian ca (nhập tay)</label>
          <input required type="text" id="ThoiGianCa" name="ThoiGianCa" class="form-control" placeholder="VD: 6h-7h">
        </div>

        <!-- Trạng thái -->
        <div class="col-md-4">
          <label for="TrangThai" class="form-label">Trạng thái</label>
          <select required id="TrangThai" name="TrangThai" class="form-select">
            <option value="cho duyet">Chờ duyệt</option>
            <option value="da duyet">Đã duyệt</option>
            <option value="huy">Đã huỷ</option>
          </select>
        </div>

        <!-- Mô tả lý do hẹn -->
        <div class="col-12">
          <label for="MoTaLyDo" class="form-label">Mô tả lý do</label>
          <textarea name="MoTaLyDo" id="MoTaLyDo" class="form-control" placeholder="Mô tả lý do"></textarea>
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-success" type="submit">Lưu</button>
        <a href="?controller=lichhen" class="btn btn-secondary">Quay lại</a>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
  // Khi chọn khách hàng, load danh sách xe máy của khách đó
  $('#khachhang_MaKH').change(function() {
    var maKH = $(this).val();
    $('#xemay_MaXE').html('<option value="">-- Chọn mã xe --</option>');
    $('#TenXe, #LoaiXe, #PhanKhuc').val('');
    if(maKH) {
      $.get('/QuanLyBaoDuongXe/Admin/api/lichhenapi.php?action=get_xemay_by_khachhang&MaKH=' + maKH, function(data) {
        let arr = JSON.parse(data);
        arr.forEach(function(xe) {
          $('#xemay_MaXE').append('<option value="'+xe.MaXE+'">'+xe.MaXE+' - '+xe.BienSoXe+'</option>');
        });
      });
    }
  });
  // Khi chọn xe máy, tự động điền Tên xe, Loại xe, Phân khúc
  $('#xemay_MaXE').change(function() {
    var maXE = $(this).val();
    if(maXE) {
      $.get('/QuanLyBaoDuongXe/Admin/api/lichhenapi.php?action=get_thongtin_xemay&MaXE=' + maXE, function(data) {
        let xe = JSON.parse(data);
        $('#TenXe').val(xe.TenXe);
        $('#LoaiXe').val(xe.LoaiXe);
        $('#PhanKhuc').val(xe.PhanKhuc);
      });
    } else {
      $('#TenXe, #LoaiXe, #PhanKhuc').val('');
    }
  });

  // AJAX submit form thêm lịch hẹn
  $('#formLichHen').submit(function(e){
    e.preventDefault(); // Không submit truyền thống

    var formData = $(this).serialize();
    $.ajax({
      url: '/QuanLyBaoDuongXe/Admin/api/lichhenapi.php', // API xử lý thêm mới lịch hẹn
      type: 'POST',
      data: formData + '&action=add_lichhen', // truyền thêm action
      dataType: 'json',
      success: function(res){
        if(res.status === 'success'){
          showPopup('Thêm lịch hẹn thành công!', 'success');
          $('#formLichHen')[0].reset();
        }else{
          showPopup('Thêm lịch hẹn thất bại: '+(res.msg||''), 'danger');
        }
      },
      error: function(xhr){
        showPopup('Có lỗi xảy ra khi gửi dữ liệu!', 'danger');
      }
    });
  });

  // Hàm hiển thị popup
  function showPopup(msg, type){
    var $msg = $('#popupMsg');
    $msg.removeClass('alert-success alert-danger').addClass('alert-' + (type=='success'?'success':'danger'));
    $msg.html(msg).fadeIn();
    setTimeout(function(){$msg.fadeOut();}, 2500);
  }
});
</script>