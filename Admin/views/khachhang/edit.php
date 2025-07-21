<h2>Sửa khách hàng</h2>
<?php if ($kh): ?>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Tên khách hàng</label>
        <input type="text" name="TenKH" class="form-control" value="<?= htmlspecialchars($kh['TenKH']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($kh['Email']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Điện thoại</label>
        <input type="text" name="SDT" class="form-control" value="<?= htmlspecialchars($kh['SDT']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Địa chỉ</label>
        <textarea name="DiaChi" class="form-control"><?= htmlspecialchars($kh['DiaChi']) ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="TrangThai" class="form-select">
            <option value="hoat_dong" <?= $kh['TrangThai'] == 'hoat_dong' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="bi_khoa" <?= $kh['TrangThai'] == 'bi_khoa' ? 'selected' : '' ?>>Bị khóa</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="khachhang.php" class="btn btn-secondary">Hủy</a>
</form>
<?php else: ?>
    <div class="alert alert-danger">Không tìm thấy khách hàng!</div>
    <a href="khachhang.php" class="btn btn-secondary">Quay lại danh sách</a>
<?php endif; ?>