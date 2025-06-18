<div class="container mt-4">
  <h2>Thêm dịch vụ</h2>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Tên dịch vụ</label>
      <input name="TenDV" type="text" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Hình ảnh (chọn file từ máy)</label>
      <input name="HinhAnh" type="file" accept="image/*" class="form-control">
    </div>
    <div class="mb-3">
      <label>Đơn giá</label>
      <input name="DonGia" id="DonGia" type="number" min="1" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Thêm</button>
    <a href="?controller=dichvu&action=index" class="btn btn-secondary">Quay lại</a>
  </form>
</div>