<div class="container" style="max-width:700px;">
    <div class="card mt-4 mb-5">
        <div class="card-header bg-light">
            <h4 class="mb-0">Sửa lịch sử bảo hành</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Tên bảo hành</label>
                    <input type="text" name="TenBHDK" class="form-control" value="<?= htmlspecialchars($item['TenBHDK'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày</label>
                    <input type="date" name="Ngay" class="form-control" value="<?= htmlspecialchars($item['Ngay'] ?? '') ?>" required min="<?= date('Y-m-d') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Loại bảo hành</label>
                    <input type="text" name="LoaiBaoHanh" class="form-control" value="<?= htmlspecialchars($item['LoaiBaoHanh'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thông tin trước</label>
                    <input type="text" name="ThongTinTruocBaoHanh" class="form-control" value="<?= htmlspecialchars($item['ThongTinTruocBaoHanh'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Thông tin sau</label>
                    <input type="text" name="ThongTinSauBaoHanh" class="form-control" value="<?= htmlspecialchars($item['ThongTinSauBaoHanh'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Chọn xe</label>
                    <select name="xemay_MaXE" class="form-select" required>
                        <option value="">-- Chọn xe --</option>
                        <?php foreach ($listXe as $xe): ?>
                            <option value="<?= $xe['MaXE'] ?>" <?= ($item['xemay_MaXE'] == $xe['MaXE']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($xe['TenXe'].' - '.$xe['BienSoXe']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php
                // Hiển thị phụ tùng liên quan (chitiethoadon_MaCTHD, MaSeriesSP) nếu có
                if (!empty($item['chitiethoadon_MaCTHD'])):
                    // Nếu bạn có thể lấy thông tin phụ tùng từ $item thì hiển thị dưới đây
                ?>
                <div class="mb-3">
                    <label class="form-label">Phụ tùng bảo hành đi kèm</label>
                    <div class="form-control-plaintext">
                        Mã CTHĐ: <b><?= htmlspecialchars($item['chitiethoadon_MaCTHD']) ?></b>
                        <?php if (!empty($item['MaSeriesSP'])): ?>
                            | Series: <b><?= htmlspecialchars($item['MaSeriesSP']) ?></b>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-success px-4">Cập nhật</button>
                    <a href="?controller=lichsubaohanh&action=index" class="btn btn-secondary px-4">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>