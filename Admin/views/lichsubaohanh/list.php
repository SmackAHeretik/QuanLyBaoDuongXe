<div class="modal show d-block" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lịch sử bảo hành của xe</h5>
                <a href="khachhang.php" class="btn-close" aria-label="Close"></a>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã BH</th>
                            <th>Tên bảo hành</th>
                            <th>Ngày</th>
                            <th>Loại bảo hành</th>
                            <th>Thông tin trước</th>
                            <th>Thông tin sau</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($list)) : ?>
                        <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['MaBHDK']) ?></td>
                            <td><?= htmlspecialchars($row['TenBHDK']) ?></td>
                            <td><?= htmlspecialchars($row['Ngay']) ?></td>
                            <td><?= htmlspecialchars($row['LoaiBaoHanh']) ?></td>
                            <td><?= htmlspecialchars($row['ThongTinTruocBaoHanh']) ?></td>
                            <td><?= htmlspecialchars($row['ThongTinSauBaoHanh']) ?></td>
                            <td>
                                <a href="?controller=lichsubaohanh&action=edit&id=<?= $row['MaBHDK'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                                <a href="?controller=lichsubaohanh&action=delete&id=<?= $row['MaBHDK'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa bản ghi này?')">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Không có dữ liệu.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <a href="?controller=lichsubaohanh&action=add" class="btn btn-success">Thêm bảo hành</a>
            </div>
        </div>
    </div>
</div>