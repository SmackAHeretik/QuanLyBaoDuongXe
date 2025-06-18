<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0">Danh sách dịch vụ</h5>
      <a href="?controller=dichvu&action=add" class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm dịch vụ
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Tên dịch vụ</th>
            <th class="text-center">Hình ảnh</th>
            <th class="text-center">Đơn giá</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($dichvus)): ?>
            <?php foreach ($dichvus as $key => $dv): ?>
              <tr>
                <td class="text-center"><?= $key + 1 ?></td>
                <td class="text-center"><?= htmlspecialchars($dv['TenDV']) ?></td>
                <td class="text-center">
                  <?php if (!empty($dv['HinhAnh'])): ?>
                    <img src="<?= htmlspecialchars($dv['HinhAnh']) ?>" alt="Hình dịch vụ" style="height:40px;max-width:60px;">
                  <?php else: ?>
                    <span class="text-muted">Không có</span>
                  <?php endif ?>
                </td>
                <td class="text-center"><?= number_format($dv['DonGia'], 0, ',', '.') ?> VND</td>
                <td class="text-center">
                  <a href="?controller=dichvu&action=edit&id=<?= $dv['MaDV'] ?>" class="btn btn-sm btn-primary me-1"
                    title="Sửa">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="?controller=dichvu&action=delete&id=<?= $dv['MaDV'] ?>" class="btn btn-sm btn-danger" title="Xóa"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">Không có dịch vụ nào.</td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
    </div>
  </div>
</div>