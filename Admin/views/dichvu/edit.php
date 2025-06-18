<div class="container mt-4">
  <h2>Sửa dịch vụ</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Tên dịch vụ</label>
      <input name="TenDV" type="text" class="form-control" value="<?= htmlspecialchars($dichvu['TenDV']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Hình ảnh (chọn file mới nếu muốn đổi)</label>
      <input name="HinhAnh" type="file" accept="image/*" class="form-control">
      <?php if (!empty($dichvu['HinhAnh'])): ?>
        <div class="mt-2">
          <img src="<?= htmlspecialchars($dichvu['HinhAnh']) ?>" alt="Hình dịch vụ"
            style="max-width:120px;max-height:90px;">
        </div>
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label>Đơn giá</label>
      <input name="DonGia" id="DonGia" type="number" min="1" class="form-control"
        value="<?= htmlspecialchars($dichvu['DonGia']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    <a href="?controller=dichvu&action=index" class="btn btn-secondary">Quay lại</a>
  </form>
</div>