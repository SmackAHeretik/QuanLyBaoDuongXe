<div class="container" style="max-width:700px;">
    <div class="card mt-4 mb-5">
        <div class="card-header bg-light">
            <h4 class="mb-0">Thêm mới lịch sử bảo hành</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Tên bảo hành</label>
                    <input type="text" name="TenBHDK" class="form-control" placeholder="Nhập tên bảo hành" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày</label>
                    <input type="date" name="Ngay" class="form-control" required min="<?= date('Y-m-d') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Loại bảo hành</label>
                    <input type="text" name="LoaiBaoHanh" class="form-control" placeholder="Nhập loại bảo hành" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thông tin trước</label>
                    <input type="text" name="ThongTinTruocBaoHanh" class="form-control" placeholder="Nhập thông tin trước khi bảo hành">
                </div>
                <div class="mb-3">
                    <label class="form-label">Thông tin sau</label>
                    <input type="text" name="ThongTinSauBaoHanh" class="form-control" placeholder="Nhập thông tin sau khi bảo hành">
                </div>
                <div class="mb-3">
                    <label class="form-label">Chọn xe</label>
                    <select name="xemay_MaXE" class="form-select" required onchange="this.form.submit()">
                        <option value="">-- Chọn xe --</option>
                        <?php foreach ($listXe as $xe): ?>
                            <option value="<?= $xe['MaXE'] ?>" <?= (!empty($item['xemay_MaXE']) && $item['xemay_MaXE'] == $xe['MaXE']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($xe['TenXe'].' - '.$xe['BienSoXe']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if (!empty($listCTHD)): ?>
                <div class="mb-3">
                    <label class="form-label">Chọn phụ tùng (cần bảo hành)</label>
                    <select name="chitiethoadon_MaCTHD[]" class="form-select" multiple required>
                        <option value="">-- Chọn phụ tùng --</option>
                        <?php foreach ($listCTHD as $cthd): ?>
                            <option value="<?= $cthd['MaCTHD'] ?>">
                                <?= htmlspecialchars(
                                    (isset($cthd['TenSP']) ? $cthd['TenSP'] : (isset($cthd['TenPhuTung']) ? $cthd['TenPhuTung'] : ('Mã SP: '.$cthd['phutungxemay_MaSP']))) .
                                    ' | Series: ' . (isset($cthd['SoSeriesSP']) ? $cthd['SoSeriesSP'] : '') .
                                    ' | SL bảo hành còn lại: ' . (isset($cthd['SoLanDaBaoHanh']) ? $cthd['SoLanDaBaoHanh'] : (isset($cthd['SoLanBaoHanhConLai']) ? $cthd['SoLanBaoHanhConLai'] : ''))
                                ) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Nhấn Ctrl (Windows) hoặc Cmd (Mac) để chọn nhiều phụ tùng.</small>
                </div>
                <?php endif; ?>
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-success px-4">Lưu</button>
                    <a href="khachhang.php" class="btn btn-secondary px-4">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>