<?php
// $xemays, $phutungxemay, $dichvus, $error đã có từ controller
?>
<div class="container-fluid pt-4 px-4">
  <div class="row g-4 justify-content-center">
    <div class="col-lg-8 col-md-10 bg-white p-4 rounded shadow">
      <h2 class="mb-4">Thêm hóa đơn</h2>
      <form method="post" id="frmHoadon" autocomplete="off">
        <div class="mb-3">
          <label class="form-label fw-bold">Xe máy</label>
          <select name="xemay_MaXE" id="select_xemay" class="form-control" required>
            <option value="">-- Chọn xe máy --</option>
            <?php foreach($xemays as $xe): ?>
              <option value="<?= htmlspecialchars($xe['MaXE']) ?>"
                data-tenkh="<?= htmlspecialchars($xe['TenKH']) ?>">
                <?= htmlspecialchars($xe['TenXe'] . ' - ' . $xe['BienSoXe'] . ' - ' . $xe['TenKH']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Ngày</label>
          <input type="date" name="Ngay" class="form-control" required>
        </div>
        <div class="mb-3" style="display:none">
          <input type="number" name="TongTien" id="TongTien" class="form-control" min="0" readonly>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Trạng Thái</label>
          <select name="TrangThai" class="form-control" required>
            <option value="cho_thanh_toan">Chờ thanh toán</option>
            <option value="da_thanh_toan">Đã thanh toán</option>
            <option value="huy">Hủy</option>
          </select>
        </div>
        <h4 class="mt-4">Danh sách phụ tùng / dịch vụ</h4>
        <table class="table" id="tbl-phutung">
          <thead>
            <tr>
              <th>Phụ tùng</th>
              <th>Số lượng</th>
              <th>Giá tiền</th>
              <th>Dịch vụ</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select name="phutung_MaSP[]" class="form-control sl-phutung">
                  <option value="">-- Chọn phụ tùng --</option>
                  <?php foreach($phutungxemay as $pt): ?>
                    <option value="<?=$pt['MaSP']?>" data-giatien="<?=$pt['DonGia']?>">
                      <?=$pt['TenSP']?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <input type="number" name="phutung_SoLuong[]" class="form-control inp-soluong" min="1" value="1">
              </td>
              <td>
                <input type="number" name="phutung_GiaTien[]" class="form-control inp-giatien" min="0" value="0">
              </td>
              <td>
              <select name="dichvu_MaDV[]" class="form-control sl-dichvu">
                <option value="">-- Chọn dịch vụ --</option>
                <?php foreach($dichvus as $dv): ?>
                  <option value="<?= $dv['MaDV'] ?>" data-giatien="<?= $dv['DonGia'] ?>">
                    <?= htmlspecialchars($dv['TenDV']) ?> (<?= number_format($dv['DonGia'],0,',','.') ?> VNĐ)
                  </option>
                <?php endforeach; ?>
              </select>
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-remove-row">X</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <button type="button" class="btn btn-info mb-3" id="btn-add-row">+ Thêm dòng</button>
          <div class="fw-bold fs-5">
            Tổng tiền: <span id="sumPhuTung" class="text-primary">0</span> VNĐ
          </div>
        </div>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-success" name="save">Thêm hóa đơn</button>
          <a href="khachhang.php" class="btn btn-secondary">Quay lại</a>
        </div>
      </form>
      <div class="mt-3 alert alert-info">
        <b>Gợi ý:</b> Bạn có thể thêm nhiều phụ tùng và/hoặc dịch vụ cho một hóa đơn bằng nút <span class="badge bg-info text-dark">+ Thêm dòng</span>. Tổng tiền hóa đơn sẽ được tự động tính bằng tổng giá các phụ tùng và dịch vụ bên dưới.
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateTongTienPhuTung() {
  let sum = 0;
  $("#tbl-phutung tbody tr").each(function(){
    let giaPT = parseFloat($(this).find("input[name='phutung_GiaTien[]']").val()) || 0;
    let sl = parseInt($(this).find("input[name='phutung_SoLuong[]']").val()) || 0;
    let giaDV = 0;
    let $dv = $(this).find('.sl-dichvu option:selected');
    if($dv.val()) giaDV = parseFloat($dv.data('giatien')) || 0;
    sum += giaPT * sl + giaDV;
  });
  $("#TongTien").val(sum);
  $("#sumPhuTung").text(sum.toLocaleString('vi-VN'));
}
$('#btn-add-row').click(function(){
  let row = $('#tbl-phutung tbody tr:first').clone();
  row.find('select,input').val('');
  row.find('input[name="phutung_SoLuong[]"]').val(1);
  row.find('input[name="phutung_GiaTien[]"]').val(0);
  $('#tbl-phutung tbody').append(row);
});
$('#tbl-phutung').on('click', '.btn-remove-row', function(){
  if($('#tbl-phutung tbody tr').length > 1) $(this).closest('tr').remove();
  updateTongTienPhuTung();
});
$('#tbl-phutung').on('change', '.sl-phutung', function() {
  // Chống chọn trùng phụ tùng
  let vals = [];
  let isDuplicate = false;
  $('#tbl-phutung .sl-phutung').each(function(){
    let v = $(this).val();
    if (v && vals.includes(v)) {
      isDuplicate = true;
      $(this).val('');
      alert('Phụ tùng này đã được chọn ở dòng khác!');
    }
    vals.push(v);
  });
  // Tự động cập nhật giá
  let gia = $(this).find('option:selected').data('giatien') || 0;
  $(this).closest('tr').find('.inp-giatien').val(gia);
  updateTongTienPhuTung();
});
$('#tbl-phutung').on('input change', '.inp-soluong, .inp-giatien, .sl-dichvu', function() {
  updateTongTienPhuTung();
});
$("#frmHoadon").submit(function(){
  updateTongTienPhuTung();
});
$(document).ready(function() {
  updateTongTienPhuTung();
});
</script>