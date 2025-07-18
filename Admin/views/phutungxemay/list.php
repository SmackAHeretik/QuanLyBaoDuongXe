<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Danh sách Phụ Tùng Xe Máy</h3>
  <a href="form.php?action=add" class="btn btn-primary">Thêm mới</a>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>MaSP</th>
        <th>TenSP</th>
        <th>Hình ảnh</th>
        <th>SoSeriesSP</th>
        <th>MieuTaSP</th>
        <th>NamSX</th>
        <th>XuatXu</th>
        <th>ThoiGianBaoHanhDinhKy</th>
        <th>Đơn giá</th>
        <th>loaiphutung</th>
        <th>nhasanxuat_MaNSX</th>
        <th>SoLanBaoHanhToiDa</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($phutungxemay)): ?>
        <?php foreach ($phutungxemay as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['MaSP']) ?></td>
            <td><?= htmlspecialchars($row['TenSP']) ?></td>
            <td>
              <?php if (!empty($row['HinhAnh'])): ?>
                <img src="<?= htmlspecialchars($row['HinhAnh']) ?>" alt="Hình ảnh"
                  style="width: 80px; height: auto;max-height:80px;">
              <?php else: ?>
                <span class="text-muted">Không có</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['SoSeriesSP']) ?></td>
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
            <td><?= htmlspecialchars($row['NamSX']) ?></td>
            <td><?= htmlspecialchars($row['XuatXu']) ?></td>
            <td><?= htmlspecialchars($row['ThoiGianBaoHanhDinhKy']) ?></td>
            <td><?= number_format($row['DonGia'], 0, ',', '.') ?> VND</td>
            <td><?= htmlspecialchars($row['loaiphutung']) ?></td>
            <td><?= htmlspecialchars($row['nhasanxuat_MaNSX']) ?></td>
            <td><?= htmlspecialchars($row['SoLanBaoHanhToiDa']) ?></td>
            <td>
              <button class="btn btn-sm <?= $row['TrangThai'] == 1 ? 'btn-success' : 'btn-secondary' ?> btn-toggle-status"
                data-id="<?= $row['MaSP'] ?>" data-status="<?= $row['TrangThai'] ?>">
                <?= $row['TrangThai'] == 1 ? 'Hiển thị' : 'Ẩn' ?>
              </button>
            </td>
            <td>
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