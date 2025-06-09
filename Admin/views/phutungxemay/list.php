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
        <th>DonGia</th>
        <th>loaiphutung</th>
        <th>nhasanxuat_MaNSX</th>
        <th>SoLanBaoHanhToiDa</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($data && $data->num_rows > 0): ?>
        <?php while ($row = $data->fetch_assoc()): ?>
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
            <td><?= htmlspecialchars($row['MieuTaSP']) ?></td>
            <td><?= htmlspecialchars($row['NamSX']) ?></td>
            <td><?= htmlspecialchars($row['XuatXu']) ?></td>
            <td><?= htmlspecialchars($row['ThoiGianBaoHanhDinhKy']) ?></td>
            <td><?= htmlspecialchars($row['DonGia']) ?></td>
            <td><?= htmlspecialchars($row['loaiphutung']) ?></td>
            <td><?= htmlspecialchars($row['nhasanxuat_MaNSX']) ?></td>
            <td><?= htmlspecialchars($row['SoLanBaoHanhToiDa']) ?></td>
            <td>
              <a href="form.php?action=edit&id=<?= urlencode($row['MaSP']) ?>" class="btn btn-sm btn-warning">Sửa</a>
              <a href="form.php?action=delete&id=<?= urlencode($row['MaSP']) ?>" class="btn btn-sm btn-danger"
                onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="13" class="text-center">Không có dữ liệu</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>