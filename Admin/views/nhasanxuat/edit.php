<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Sửa nhà sản xuất</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-7 col-md-9">
        <div class="card shadow border-0">
          <div class="card-header bg-warning text-dark text-center">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Sửa Nhà Sản Xuất</h4>
          </div>
          <div class="card-body p-4">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            <form method="post" autocomplete="off">
              <div class="mb-3">
                <label for="TenNhaSX" class="form-label">Tên nhà sản xuất <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenNhaSX" name="TenNhaSX" required
                  value="<?= htmlspecialchars($item['TenNhaSX']) ?>">
              </div>
              <div class="mb-3">
                <label for="XuatXu" class="form-label">Xuất xứ</label>
                <input type="text" class="form-control" id="XuatXu" name="XuatXu"
                  value="<?= htmlspecialchars($item['XuatXu']) ?>">
              </div>
              <div class="mb-3">
                <label for="MoTa" class="form-label">Mô tả</label>
                <textarea class="form-control" id="MoTa" name="MoTa" rows="2"><?= htmlspecialchars($item['MoTa']) ?></textarea>
              </div>
              <button type="submit" class="btn btn-warning w-100">
                <i class="fas fa-save me-2"></i>Lưu thay đổi
              </button>
            </form>
          </div>
          <div class="card-footer text-center bg-white">
            <a href="?action=list" class="btn btn-link text-warning text-decoration-none">
              <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
