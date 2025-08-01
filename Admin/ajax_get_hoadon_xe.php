<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/HoaDonModel.php';

$maXe = $_GET['xemay_MaXE'] ?? '';
if (!$maXe || !is_numeric($maXe)) {
    echo '<div class="text-danger">Dữ liệu không hợp lệ!</div>';
    exit;
}
$model = new HoaDonModel(connectDB());
$ds = $model->getHoaDonByMaXe($maXe);
?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã HĐ</th>
                <th>Ngày</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ds)): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">Không có hóa đơn nào cho xe này.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($ds as $hd): ?>
            <tr>
                <td><?= htmlspecialchars($hd['MaHD']) ?></td>
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
                <td>
                  <a href="hoadon.php?controller=hoadon&action=edit&id=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-primary" title="Sửa"><i class="fa fa-edit"></i></a>
                  <a href="hoadon.php?controller=hoadon&action=delete&id=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Xóa hóa đơn?')"><i class="fa fa-trash"></i></a>
                  <a href="chitiethoadon.php?hoadon_MaHD=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-info" title="Chi tiết hóa đơn"><i class="fa fa-list"></i></a>
                  <?php if ($hd['TrangThai'] === 'cho_thanh_toan'): ?>
                  <!-- Form thay thế cho button mã QR -->
                  <form action="checkout.php" method="post" style="display:inline;">
                      <input type="hidden" name="mahd" value="<?= htmlspecialchars($hd['MaHD']) ?>">
                      <input type="hidden" name="tongtien" value="<?= htmlspecialchars($hd['TongTien']) ?>">
                      <button
                          class="btn btn-sm btn-success"
                          title="Thanh toán QR"
                          type="submit"
                      >
                          <i class="fa fa-qrcode"></i>
                      </button>
                  </form>
                  <form action="checkout.php" method="post" style="display:inline;">
                      <input type="hidden" name="mahd" value="<?= htmlspecialchars($hd['MaHD']) ?>">
                      <input type="hidden" name="tienmat" value="1">
                      <button
                          class="btn btn-sm btn-warning"
                          title="Thanh toán tiền mặt"
                          type="submit"
                      >
                          <b>₫</b>
                      </button>
                  </form>
                  <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="5" class="text-end">
                    <a class="btn btn-success" href="hoadon.php?controller=hoadon&action=add&xemay_MaXE=<?= $maXe ?>" title="Tạo hóa đơn mới cho xe này">
                        <i class="fa fa-plus"></i> Tạo hóa đơn mới cho xe này
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>