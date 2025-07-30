<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<!-- Tiêu đề căn giữa, nút bên phải -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="flex-grow-1 mb-0">Danh sách Phụ Tùng Xe Máy</h3>
  <a href="form.php?action=add" class="btn btn-primary">Thêm mới</a>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th class="text-center" style="vertical-align: middle;">Mã<br>sản phẩm</th>
        <th class="text-center" style="vertical-align: middle;">Tên<br>sản phẩm</th>
        <th class="text-center" style="vertical-align: middle;">Hình ảnh</th>
        <th class="text-center" style="vertical-align: middle;">Số Serial</th>
        <th class="text-center" style="vertical-align: middle;">Miêu tả</th>
        <th class="text-center" style="vertical-align: middle;">Năm<br>sản xuất</th>
        <th class="text-center" style="vertical-align: middle;">Xuất xứ</th>
        <th class="text-center" style="vertical-align: middle;">Thời gian<br>bảo hành<br>định kỳ</th>
        <th class="text-center" style="vertical-align: middle;">Đơn giá</th>
        <th class="text-center" style="vertical-align: middle;">Loại<br>phụ tùng</th>
        <th class="text-center" style="vertical-align: middle;">Mã<br>hãng xe</th>
        <th class="text-center" style="vertical-align: middle;">Số lần<br>bảo hành<br>tối đa</th>
        <th class="text-center" style="vertical-align: middle;">Trạng thái</th>
        <th class="text-center" style="vertical-align: middle;">Thao tác</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($phutungxemay)): ?>
        <?php foreach ($phutungxemay as $row): ?>
          <tr>
            <td class="text-center"><?= htmlspecialchars($row['MaSP']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['TenSP']) ?></td>
            <td class="text-center">
              <?php if (!empty($row['HinhAnh'])): ?>
                <img src="<?= htmlspecialchars($row['HinhAnh']) ?>" alt="Hình ảnh"
                  style="width: 80px; height: auto;max-height:80px;">
              <?php else: ?>
                <span class="text-muted">Không có</span>
              <?php endif; ?>
            </td>
            <td class="text-center"><?= htmlspecialchars($row['SoSeriesSP']) ?></td>
            <td>
              <?php
                $desc = $row['MieuTaSP'];
                $shortDesc = mb_substr($desc, 0, 40) . (mb_strlen($desc) > 40 ? '...' : '');
                $modalId = 'descModal' . $row['MaSP'];
              ?>
              <span><?= htmlspecialchars($shortDesc) ?></span>
              <?php if (mb_strlen($desc) > 40): ?>
                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                  Xem chi tiết
                </button>
                <!-- Modal -->
                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="<?= $modalId ?>Label">Mô tả sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                      </div>
                      <div class="modal-body">
                        <?= nl2br(htmlspecialchars($desc)) ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </td>
            <td class="text-center"><?= htmlspecialchars($row['NamSX']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['XuatXu']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['ThoiGianBaoHanhDinhKy']) ?></td>
            <td class="text-center"><?= number_format($row['DonGia'], 0, ',', '.') ?> VND</td>
            <td class="text-center"><?= htmlspecialchars($row['loaiphutung']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['nhasanxuat_MaNSX']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['SoLanBaoHanhToiDa']) ?></td>
            <td class="text-center">
              <button class="btn btn-sm <?= $row['TrangThai'] == 1 ? 'btn-success' : 'btn-secondary' ?> btn-toggle-status"
                data-id="<?= $row['MaSP'] ?>" data-status="<?= $row['TrangThai'] ?>">
                <?= $row['TrangThai'] == 1 ? 'Hiển thị' : 'Ẩn' ?>
              </button>
            </td>
            <td class="text-center">
              <a href="form.php?action=edit&id=<?= urlencode($row['MaSP']) ?>" class="btn btn-sm btn-warning">Sửa</a>
              <a href="form.php?action=delete&id=<?= urlencode($row['MaSP']) ?>" class="btn btn-sm btn-danger"
                onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="14" class="text-center">Không có dữ liệu</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-toggle-status').forEach(function (btn) {
      btn.addEventListener('click', function () {
        let id = this.dataset.id;
        let btnEl = this;
        fetch('form.php?action=toggleStatus&id=' + id, { method: 'POST' })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              btnEl.dataset.status = data.newStatus;
              btnEl.textContent = data.newStatus == 1 ? 'Hiển thị' : 'Ẩn';
              btnEl.className = 'btn btn-sm ' + (data.newStatus == 1 ? 'btn-success' : 'btn-secondary') + ' btn-toggle-status';
            } else {
              alert('Lỗi thao tác!');
            }
          });
      });
    });
  });
</script>