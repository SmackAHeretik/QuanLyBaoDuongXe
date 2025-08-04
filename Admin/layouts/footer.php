<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded-top p-4">
      <div class="row">
        <div class="col-12 col-sm-6 text-center text-sm-start" style="margin-top:20px;">
          &copy; <a href="#">67 Performance Admin Page</a> .
        </div>
        <div class="col-12 col-sm-6 text-center text-sm-end">
          Thiết Kế : <a href="https://htmlcodex.com">Quang Huy | Vĩnh Khang</a>
        </div>
      </div>
    </div>
</div>
<!-- Modal lịch sử bảo hành (luôn có mặt ở DOM) -->
<div class="modal fade" id="modalLichSuBH" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lịch sử bảo hành của xe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="contentLichSuBH">
        <div class="text-center text-muted">Đang tải...</div>
      </div>
    </div>
  </div>
</div>

<!-- Thư viện JS (chỉ cần 1 lần ở layout, không nhúng lại ở file AJAX) -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script xử lý sự kiện lịch sử bảo hành -->
<script>
$(document).on('click', '.btn-lichsu-bh', function(e){
    e.preventDefault();
    var maXe = $(this).data('maxe');
    $('#contentLichSuBH').html('<div class="text-center text-muted">Đang tải...</div>');
    $('#modalLichSuBH').modal('show');
    $.get('ajax_lichsu_baohanh.php', { xemay_MaXE: maXe }, function(data){
        $('#contentLichSuBH').html(data);
    });
});
// Mở modal thêm mới
$(document).on('click', '.btn-add-bh', function(){
    // Reset form, set mã xe, mở modal thêm
});
// Sửa
$(document).on('click', '.btn-edit-bh', function(){
    // Gọi AJAX lấy chi tiết, fill vào form, mở modal sửa
});
// Xóa
$(document).on('click', '.btn-delete-bh', function(){
    if(confirm('Bạn muốn xóa bản ghi này?')){
        // Gửi AJAX xóa, xong reload lại bảng
    }
});
// Mở modal thêm mới bảo hành
$(document).on('click', '.btn-add-bh', function(){
    $('#modalBaoHanhTitle').text('Thêm lịch sử bảo hành');
    $('#formBaoHanh')[0].reset();
    $('#bhMaBHDK').val('');
    $('#bhMaXe').val($(this).data('maxe'));
    $('#modalFormBaoHanh').modal('show');
});
</script>
<!-- Modal Thêm/Sửa lịch sử bảo hành -->
<div class="modal fade" id="modalFormBaoHanh" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formBaoHanh">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBaoHanhTitle">Thêm lịch sử bảo hành</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="MaBHDK" id="bhMaBHDK">
          <input type="hidden" name="xemay_MaXE" id="bhMaXe">
          <div class="mb-2">
            <label>Tên bảo hành</label>
            <input type="text" class="form-control" name="TenBHDK" id="bhTenBHDK" required>
          </div>
          <div class="mb-2">
            <label>Ngày</label>
            <input type="date" class="form-control" name="Ngay" id="bhNgay" required>
          </div>
          <div class="mb-2">
            <label>Loại bảo hành</label>
            <input type="text" class="form-control" name="LoaiBaoHanh" id="bhLoaiBaoHanh" required>
          </div>
          <div class="mb-2">
            <label>Thông tin trước</label>
            <input type="text" class="form-control" name="ThongTinTruocBaoHanh" id="bhTruoc">
          </div>
          <div class="mb-2">
            <label>Thông tin sau</label>
            <input type="text" class="form-control" name="ThongTinSauBaoHanh" id="bhSau">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Lưu</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        </div>
      </form>
    </div>
  </div>
</div>