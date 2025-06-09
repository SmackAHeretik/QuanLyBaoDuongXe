<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Thêm phụ tùng xe máy</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Template style.css -->
  <link href="style.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-8 col-md-10">
        <div class="card shadow border-0">
          <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Thêm Phụ Tùng Xe Máy</h4>
          </div>
          <div class="card-body p-4">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            <!-- Sửa ở đây: thêm enctype để upload file -->
            <form method="post" enctype="multipart/form-data" autocomplete="off">
              <div class="mb-3">
                <label for="TenSP" class="form-label">Tên SP <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenSP" name="TenSP" required>
              </div>
              <div class="mb-3">
                <label for="SoSeriesSP" class="form-label">Số Series SP</label>
                <input type="text" class="form-control" id="SoSeriesSP" name="SoSeriesSP">
              </div>
              <div class="mb-3">
                <label for="MieuTaSP" class="form-label">Miêu tả SP</label>
                <textarea class="form-control" id="MieuTaSP" name="MieuTaSP" rows="2"></textarea>
              </div>
              <div class="row g-2">
                <div class="col-md-4 mb-3">
                  <label for="NamSX" class="form-label">Năm SX</label>
                  <input type="number" class="form-control" id="NamSX" name="NamSX" min="1900" max="2100">
                </div>
                <div class="col-md-4 mb-3">
                  <label for="XuatXu" class="form-label">Xuất xứ</label>
                  <input type="text" class="form-control" id="XuatXu" name="XuatXu">
                </div>
                <div class="col-md-4 mb-3">
                  <label for="loaiphutung" class="form-label">Loại phụ tùng</label>
                  <input type="text" class="form-control" id="loaiphutung" name="loaiphutung">
                </div>
              </div>
              <div class="mb-3">
                <label for="nhasanxuat_MaNSX" class="form-label">Nhà sản xuất <span class="text-danger">*</span></label>
                <select id="nhasanxuat_MaNSX" name="nhasanxuat_MaNSX" class="form-select" required>
                  <option value="">-- Chọn nhà sản xuất --</option>
                  <?php foreach ($listNSX as $nsx): ?>
                    <option value="<?= $nsx['MaNSX'] ?>"><?= htmlspecialchars($nsx['TenNhaSX']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="SoLanBaoHanhToiDa" class="form-label">Số lần bảo hành tối đa</label>
                <input type="number" class="form-control" id="SoLanBaoHanhToiDa" name="SoLanBaoHanhToiDa">
              </div>
              <div class="mb-3">
                <label for="HinhAnh" class="form-label">Hình ảnh</label>
                <!-- Sửa ở đây: đổi type="text" thành type="file" -->
                <input type="file" class="form-control" id="HinhAnh" name="HinhAnh" accept="image/*">
              </div>
              <div class="mb-3">
                <label class="form-label">Thời gian bảo hành định kỳ <span class="text-danger">*</span></label>
                <div class="row g-2">
                  <div class="col-4">
                    <input type="number" class="form-control" name="ngay" min="0" max="31" placeholder="Ngày">
                  </div>
                  <div class="col-4">
                    <input type="number" class="form-control" name="thang" min="0" max="12" placeholder="Tháng">
                  </div>
                  <div class="col-4">
                    <input type="number" class="form-control" name="nam" placeholder="Năm">
                  </div>
                </div>
                <div class="form-text text-muted ms-1">Nhập ít nhất 1 trường trong 3 trường Ngày, Tháng, Năm.</div>
              </div>
              <div class="mb-3">
                <label for="DonGia" class="form-label">Đơn giá <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="DonGia" name="DonGia" step="0.01" min="0.01" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save me-2"></i>Thêm mới
              </button>
            </form>
          </div>
          <div class="card-footer text-center bg-white">
            <a href="?action=list" class="btn btn-link text-primary text-decoration-none">
              <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS (for validation, if needed) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>