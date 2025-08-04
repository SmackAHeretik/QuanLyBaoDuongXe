<h3>Thêm chi tiết hóa đơn</h3>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
  <div class="form-group">
    <label for="hoadon_MaHD">Hóa đơn</label>
    <select name="hoadon_MaHD" id="hoadon_MaHD" class="form-control">
      <option value="">-- Chọn hóa đơn --</option>
      <?php foreach ($listHD as $hd): ?>
        <option value="<?= $hd['MaHD'] ?>" <?= isset($data['hoadon_MaHD']) && $data['hoadon_MaHD'] == $hd['MaHD'] ? 'selected' : '' ?>>
          <?= $hd['MaHD'] ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="phutungxemay_MaSP">Phụ tùng</label>
    <select name="phutungxemay_MaSP" id="phutungxemay_MaSP" class="form-control">
      <option value="">-- Chọn phụ tùng --</option>
      <?php foreach ($listPT as $pt): ?>
        <option value="<?= $pt['MaSP'] ?>" data-giatien="<?= $pt['DonGia'] ?>" <?= isset($data['phutungxemay_MaSP']) && $data['phutungxemay_MaSP'] == $pt['MaSP'] ? 'selected' : '' ?>>
          <?= $pt['TenSP'] ?> (<?= $pt['MaSP'] ?>) - <?= number_format($pt['DonGia'], 0, ',', '.') ?> VNĐ
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="dichvu_MaDV">Dịch vụ</label>
    <select name="dichvu_MaDV" id="dichvu_MaDV" class="form-control">
      <option value="">-- Chọn dịch vụ --</option>
      <?php foreach ($listDV as $dv): ?>
        <option value="<?= $dv['MaDV'] ?>" data-giatien="<?= $dv['DonGia'] ?>" <?= isset($data['dichvu_MaDV']) && $data['dichvu_MaDV'] == $dv['MaDV'] ? 'selected' : '' ?>>
          <?= $dv['TenDV'] ?> (<?= $dv['MaDV'] ?>) - <?= number_format($dv['DonGia'],0,',','.') ?> VNĐ
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="GiaTien">Giá tiền</label>
    <input type="text" name="GiaTien" id="GiaTien" class="form-control"
      value="<?= isset($data['GiaTien']) ? number_format($data['GiaTien'], 0, '.', '.') : '' ?>" readonly>
  </div>
  <div class="form-group">
    <label for="SoLuong">Số lượng</label>
    <input type="number" name="SoLuong" id="SoLuong" class="form-control" value="<?= $data['SoLuong'] ?? 0 ?>">
  </div>
  <div class="form-group">
    <label for="NgayBDBH">Ngày bắt đầu BH</label>
    <input type="datetime-local" name="NgayBDBH" id="NgayBDBH" class="form-control"
      value="<?= isset($data['NgayBDBH']) ? date('Y-m-d\TH:i', strtotime($data['NgayBDBH'])) : '' ?>">
  </div>
  <div class="form-group">
    <label for="NgayKTBH">Ngày kết thúc BH</label>
    <input type="datetime-local" name="NgayKTBH" id="NgayKTBH" class="form-control"
      value="<?= isset($data['NgayKTBH']) ? date('Y-m-d\TH:i', strtotime($data['NgayKTBH'])) : '' ?>">
  </div>
  <div class="form-group">
    <label for="SoLanDaBaoHanh">Số lần đã bảo hành</label>
    <input type="number" name="SoLanDaBaoHanh" id="SoLanDaBaoHanh" class="form-control"
      value="<?= $data['SoLanDaBaoHanh'] ?? 0 ?>">
  </div>
  <button type="submit" class="btn btn-primary">Lưu</button>
  <a href="?controller=chitiethoadon&action=list" class="btn btn-secondary">Quay lại</a>
</form>
<script>
function formatVND(number) {
  if (!number) return '';
  return Number(number).toLocaleString('vi-VN');
}
document.getElementById('phutungxemay_MaSP').addEventListener('change', function() {
  var selected = this.options[this.selectedIndex];
  var gia = selected.getAttribute('data-giatien');
  document.getElementById('GiaTien').value = gia ? formatVND(gia) : '';
  document.getElementById('dichvu_MaDV').selectedIndex = 0;
});
document.getElementById('dichvu_MaDV').addEventListener('change', function() {
  var selected = this.options[this.selectedIndex];
  var gia = selected.getAttribute('data-giatien');
  document.getElementById('GiaTien').value = gia ? formatVND(gia) : '';
  document.getElementById('phutungxemay_MaSP').selectedIndex = 0;
});
</script>