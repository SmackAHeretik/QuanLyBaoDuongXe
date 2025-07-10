<?php
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/HoaDonModel.php';

$maXe = $_GET['xemay_MaXE'] ?? '';
if (!$maXe || !is_numeric($maXe)) {
    echo '<div class="text-danger">Dữ liệu không hợp lệ!</div>';
    exit;
}

$model = new HoaDonModel(connectDB());
$ds = $model->getHoaDonByMaXe($maXe);

if (empty($ds)) {
    echo '<div class="text-muted">Không có hóa đơn nào cho xe này.</div>';
    exit;
}
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
                  <a href="index.php?controller=hoadon&action=edit&id=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-primary" title="Sửa"><i class="fa fa-edit"></i></a>
                  <a href="index.php?controller=hoadon&action=delete&id=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Xóa hóa đơn?')"><i class="fa fa-trash"></i></a>
                  <!-- Nút chi tiết hóa đơn -->
                  <a href="chitiethoadon.php?hoadon_MaHD=<?= $hd['MaHD'] ?>" class="btn btn-sm btn-info" title="Chi tiết hóa đơn">
                    <i class="fa fa-list"></i>
                  </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>