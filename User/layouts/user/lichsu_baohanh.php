<div class="container py-5">
    <h2 class="mb-4">Lịch sử bảo hành xe của bạn</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tên xe</th>
                    <th>Biển số</th>
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
                        <td colspan="7" class="text-center text-muted">Bạn chưa có lịch sử bảo hành nào.</td>
                    </tr>
                <?php else: foreach ($list as $bh): ?>
                    <tr>
                        <td><?= htmlspecialchars($bh['TenXe']) ?></td>
                        <td><?= htmlspecialchars($bh['BienSoXe']) ?></td>
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
</div>