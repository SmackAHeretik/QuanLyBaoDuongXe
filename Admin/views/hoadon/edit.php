<?php
// $hoadon, $xemays, $error đã có từ controller
?>
<div class="container-fluid pt-4 px-4">
  <div class="row g-4 justify-content-center">
    <div class="col-lg-8 col-md-10 bg-white p-4 rounded shadow">
      <h2 class="mb-4">Sửa hóa đơn</h2>
      <form method="post">
        <div class="mb-3">
          <label class="form-label fw-bold">Xe máy (Tên xe - Biển số - Tên khách hàng)</label>
          <input type="text" class="form-control" 
                 value="<?= htmlspecialchars($hoadon['TenXe'] . ' - ' . $hoadon['BienSoXe'] . ' - ' . $hoadon['TenKH']) ?>" 
                 readonly>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Ngày</label>
          <input type="date" name="Ngay" class="form-control" value="<?= htmlspecialchars(date('Y-m-d', strtotime($hoadon['Ngay']))) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Tổng Tiền</label>
          <input type="number" name="TongTien" class="form-control" value="<?= htmlspecialchars($hoadon['TongTien']) ?>" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Trạng Thái</label>
          <select name="TrangThai" class="form-control" required>
            <option value="cho_thanh_toan" <?= $hoadon['TrangThai'] == 'cho_thanh_toan' ? 'selected' : '' ?>>Chờ thanh toán</option>
            <option value="da_thanh_toan" <?= $hoadon['TrangThai'] == 'da_thanh_toan' ? 'selected' : '' ?>>Đã thanh toán</option>
            <option value="huy" <?= $hoadon['TrangThai'] == 'huy' ? 'selected' : '' ?>>Hủy</option>
          </select>
        </div>
        <input type="hidden" name="xemay_MaXE" value="<?= htmlspecialchars($hoadon['xemay_MaXE']) ?>">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-success" name="save">Lưu thay đổi</button>
        <a href="khachhang.php" class="btn btn-secondary">Quay lại</a>
      </form>
    </div>
  </div>
</div>