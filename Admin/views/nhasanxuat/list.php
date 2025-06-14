<?php if (!empty($success)): ?>
  <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Danh sách Nhà Sản Xuất</h3>
  <a href="nhasanxuat.php?action=add" class="btn btn-primary">Thêm mới</a>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>MaNSX</th>
        <th>TenNhaSX</th>
        <th>XuatXu</th>
        <th>MoTa</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($dsNSX)): ?>
        <?php foreach ($dsNSX as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['MaNSX']) ?></td>
            <td><?= htmlspecialchars($row['TenNhaSX']) ?></td>
            <td><?= htmlspecialchars($row['XuatXu']) ?></td>
            <td><?= htmlspecialchars($row['MoTa']) ?></td>
            <td>
              <a href="nhasanxuat.php?action=edit&id=<?= urlencode($row['MaNSX']) ?>" class="btn btn-sm btn-warning">Sửa</a>
              <a href="nhasanxuat.php?action=delete&id=<?= urlencode($row['MaNSX']) ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('Bạn chắc chắn muốn xóa nhà sản xuất này?')">Xóa</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center">Không có dữ liệu</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
