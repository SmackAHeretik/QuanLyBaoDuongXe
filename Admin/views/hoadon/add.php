<div class="container mt-4">
  <h2>Thêm hóa đơn</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" id="hoadonForm">
    <div class="mb-3">
      <label>Xe máy (Tên xe - Biển số - Tên khách hàng)</label>
      <select name="xemay_MaXE" class="form-control" required>
        <option value="">-- Chọn xe máy --</option>
        <?php foreach ($xemays as $xe): ?>
          <option value="<?= $xe['MaXE'] ?>">
            <?= htmlspecialchars($xe['TenXe']) ?> - <?= htmlspecialchars($xe['BienSoXe']) ?> -
            <?= htmlspecialchars($xe['TenKH'] ?? 'Chưa có') ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Ngày</label>
      <input name="Ngay" type="date" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Tổng Tiền</label>
      <input id="TongTien" name="TongTien" type="number" step="0.01" min="0.01" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Tiền Khuyến Mãi</label>
      <input id="TienKhuyenMai" name="TienKhuyenMai" type="number" step="0.01" min="0" class="form-control">
    </div>
    <div class="mb-3">
      <label>Tiền Sau Khi Giảm</label>
      <input id="TienSauKhiGiam" name="TienSauKhiGiam" type="number" step="0.01" min="0.01" class="form-control"
        readonly required>
    </div>
    <div class="mb-3">
      <label>Trạng Thái</label>
      <select name="TrangThai" class="form-control" required>
        <option value="cho_thanh_toan">Chờ thanh toán</option>
        <option value="da_thanh_toan">Đã thanh toán</option>
        <option value="huy">Hủy</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Thêm</button>
    <a href="?controller=hoadon&action=index" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
<script>
  function updateTienSauKhiGiam() {
    let tongTien = parseFloat(document.getElementById('TongTien').value) || 0;
    let tienKM = parseFloat(document.getElementById('TienKhuyenMai').value) || 0;
    let result = tongTien - tienKM;
    if (result < 0) result = 0;
    document.getElementById('TienSauKhiGiam').value = result;
  }
  document.getElementById('TongTien').addEventListener('input', updateTienSauKhiGiam);
  document.getElementById('TienKhuyenMai').addEventListener('input', updateTienSauKhiGiam);
</script>