<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0">Danh sách hóa đơn</h5>
      <a href="?controller=hoadon&action=add" class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm hóa đơn
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>Mã HĐ</th>
            <th>Mã Xe</th>
            <th>Tên KH</th>
            <th>Ngày</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($hoadons)): ?>
            <?php foreach ($hoadons as $hd): ?>
              <tr>
                <td><?= htmlspecialchars($hd['MaHD']) ?></td>
                <td><?= htmlspecialchars($hd['xemay_MaXE']) ?></td>
                <td><?= htmlspecialchars($hd['TenKH'] ?? 'Chưa có') ?></td>
                <td><?= htmlspecialchars($hd['Ngay']) ?></td>
                <td><?= number_format($hd['TongTien'], 0, ',', '.') ?> VND</td>
                <td>
                  <?php
                  $status = [
                    'cho_thanh_toan' => ['Chờ thanh toán', 'warning'],
                    'da_thanh_toan' => ['Đã thanh toán', 'success'],
                    'huy' => ['Hủy', 'danger'],
                  ];
                  [$label, $color] = $status[$hd['TrangThai']] ?? ['Không rõ', 'secondary'];
                  ?>
                  <span class="badge bg-<?= $color ?>"><?= $label ?></span>
                </td>
                <td class="text-center">
                  <a href="?controller=hoadon&action=edit&id=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="?controller=hoadon&action=delete&id=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted">Không có hóa đơn nào.</td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
    </div>
  </div>
</div>