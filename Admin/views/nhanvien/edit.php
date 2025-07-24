<h3>Sửa thông tin nhân viên</h3>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
    <div class="form-group mb-2">
        <label for="tennv">Họ và tên</label>
        <input type="text" name="tennv" id="tennv" class="form-control" value="<?= htmlspecialchars($data['TenNV'] ?? '') ?>">
    </div>
    <div class="form-group mb-2">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['Email'] ?? '') ?>">
    </div>
    <div class="form-group mb-2">
        <label for="sdt">Số điện thoại</label>
        <input type="text" name="sdt" id="sdt" class="form-control" value="<?= htmlspecialchars($data['SDT'] ?? '') ?>">
    </div>
    <div class="form-group mb-2">
        <label for="roles">Vai trò</label>
        <select name="roles" id="roles" class="form-control" required>
            <option value="">Chọn vai trò</option>
            <option value="Thợ sửa xe" <?= (isset($data['Roles']) && $data['Roles'] === 'Thợ sửa xe') ? 'selected' : '' ?>>Thợ sửa xe</option>
            <option value="Nhân viên kế toán" <?= (isset($data['Roles']) && $data['Roles'] === 'Nhân viên kế toán') ? 'selected' : '' ?>>Nhân viên kế toán</option>
        </select>
    </div>
    <div class="form-group mb-2">
        <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-group mb-2">
        <label for="confirm">Xác nhận mật khẩu mới</label>
        <input type="password" name="confirm" id="confirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    <a href="?action=list" class="btn btn-secondary">Quay lại</a>
</form>