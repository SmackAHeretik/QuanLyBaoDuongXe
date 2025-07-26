<h3>Thêm lịch làm việc</h3>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
    <div class="form-group mb-2">
        <label for="ngay">Ngày</label>
        <input type="date" name="ngay" id="ngay" class="form-control" value="<?= htmlspecialchars($data['ngay'] ?? '') ?>" required>
    </div>
    <div class="form-group mb-2">
        <label for="TrangThai">Trạng thái</label>
        <select name="TrangThai" id="TrangThai" class="form-control" required>
            <option value="">-- Chọn trạng thái --</option>
            <option value="cho duyet" <?= (isset($data['TrangThai']) && $data['TrangThai'] == 'cho duyet') ? 'selected' : '' ?>>Chờ duyệt</option>
            <option value="da duyet" <?= (isset($data['TrangThai']) && $data['TrangThai'] == 'da duyet') ? 'selected' : '' ?>>Đã duyệt</option>
            <option value="huy" <?= (isset($data['TrangThai']) && $data['TrangThai'] == 'huy') ? 'selected' : '' ?>>Huỷ</option>
        </select>
    </div>
    <div class="form-group mb-2">
        <label for="ThoiGianCa">Ca làm việc</label>
        <input type="text" name="ThoiGianCa" id="ThoiGianCa" class="form-control" value="<?= htmlspecialchars($data['ThoiGianCa'] ?? '') ?>" required>
    </div>
    <div class="form-check mb-2">
        <input type="checkbox" name="LaNgayCuoiTuan" id="LaNgayCuoiTuan" class="form-check-input" <?= (!empty($data['LaNgayCuoiTuan'])) ? 'checked' : '' ?>>
        <label class="form-check-label" for="LaNgayCuoiTuan">Là ngày cuối tuần</label>
    </div>
    <div class="form-check mb-2">
        <input type="checkbox" name="LaNgayNghiLe" id="LaNgayNghiLe" class="form-check-input" <?= (!empty($data['LaNgayNghiLe'])) ? 'checked' : '' ?>>
        <label class="form-check-label" for="LaNgayNghiLe">Là ngày nghỉ lễ</label>
    </div>
    <div class="form-group mb-2">
        <label for="admin_AdminID">Admin ID</label>
        <input type="number" name="admin_AdminID" id="admin_AdminID" class="form-control" value="<?= htmlspecialchars($data['admin_AdminID'] ?? '') ?>" required>
    </div>
    <div class="form-group mb-2">
        <label for="thoSuaXe">Chọn thợ sửa xe</label>
        <select name="thoSuaXe[]" id="thoSuaXe" class="form-control" multiple required>
            <?php foreach ($dsThoSuaXe as $tho): ?>
                <option value="<?= $tho['MaNV'] ?>"
                    <?= !empty($data['thoSuaXe']) && in_array($tho['MaNV'], $data['thoSuaXe']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tho['TenNV']) ?> (<?= htmlspecialchars($tho['SDT']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <small>Nhấn Ctrl để chọn nhiều thợ</small>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="?controller=lichlamviec" class="btn btn-secondary">Quay lại</a>
</form>