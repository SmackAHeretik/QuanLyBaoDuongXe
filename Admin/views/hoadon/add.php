<?php
// $xemays, $error đã có từ controller
?>
<div class="container-fluid pt-4 px-4">
  <div class="row g-4 justify-content-center">
    <div class="col-lg-8 col-md-10 bg-white p-4 rounded shadow">
      <h2 class="mb-4">Thêm hóa đơn</h2>
      <form method="post">
        <div class="mb-3">
          <label class="form-label fw-bold">Xe máy</label>
          <select name="xemay_MaXE" class="form-control" required>
            <option value="">-- Chọn xe máy --</option>
            <?php foreach($xemays as $xe): ?>
              <option value="<?= htmlspecialchars($xe['MaXE']) ?>">
                <?= htmlspecialchars($xe['TenXe'] . ' - ' . $xe['BienSoXe'] . ' - ' . $xe['TenKH']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Ngày</label>
          <input type="date" name="Ngay" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Tổng Tiền</label>
          <input type="number" name="TongTien" class="form-control" min="0" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Trạng Thái</label>
          <select name="TrangThai" class="form-control" required>
            <option value="cho_thanh_toan">Chờ thanh toán</option>
            <option value="da_thanh_toan">Đã thanh toán</option>
            <option value="huy">Hủy</option>
          </select>
        </div>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-success" name="save">Thêm hóa đơn</button>
        <a href="khachhang.php" class="btn btn-secondary">Quay lại</a>
      </form>
    </div>
  </div>
</div>