<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/LichSuBaoHanhModel.php';

$maXe = $_GET['xemay_MaXE'] ?? '';
if (!$maXe || !is_numeric($maXe)) {
    echo '<div class="text-danger">Dữ liệu không hợp lệ!</div>';
    exit;
}
$model = new LichSuBaoHanhModel(connectDB());
$list = $model->getByXe($maXe);
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Mã BH</th>
                <th>Tên bảo hành</th>
                <th>Ngày</th>
                <th>Loại bảo hành</th>
                <th>Thông tin trước</th>
                <th>Thông tin sau</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($list)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Chưa có lịch sử bảo hành nào cho xe này.</td>
                </tr>
            <?php else: foreach ($list as $bh): ?>
                <tr>
                    <td><?= htmlspecialchars($bh['MaBHDK']) ?></td>
                    <td><?= htmlspecialchars($bh['TenBHDK']) ?></td>
                    <td><?= htmlspecialchars($bh['Ngay']) ?></td>
                    <td><?= htmlspecialchars($bh['LoaiBaoHanh']) ?></td>
                    <td><?= htmlspecialchars($bh['ThongTinTruocBaoHanh']) ?></td>
                    <td><?= htmlspecialchars($bh['ThongTinSauBaoHanh']) ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>