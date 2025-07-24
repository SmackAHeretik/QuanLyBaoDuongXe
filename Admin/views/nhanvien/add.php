<h3>Thêm nhân viên</h3>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>
<form method="post">
    <div class="form-group mb-2">
        <label for="tennv">Họ và tên</label>
        <input type="text" name="tennv" id="tennv" class="form-control" value="<?= htmlspecialchars($data['tennv'] ?? '') ?>">
    </div>
    <div class="form-group mb-2">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
    </div>
    <div class="form-group mb-2">
        <label for="sdt">Số điện thoại</label>
        <input type="text" name="sdt" id="sdt" class="form-control" value="<?= htmlspecialchars($data['sdt'] ?? '') ?>">
    </div>
    <div class="form-group mb-2">
        <label for="roles">Vai trò</label>
        <select name="roles" id="roles" class="form-control" required>
            <option value="">Chọn vai trò</option>
            <option value="Thợ sửa xe" <?= (isset($data['roles']) && $data['roles'] === 'Thợ sửa xe') ? 'selected' : '' ?>>Thợ sửa xe</option>
            <option value="Nhân viên kế toán" <?= (isset($data['roles']) && $data['roles'] === 'Nhân viên kế toán') ? 'selected' : '' ?>>Nhân viên kế toán</option>
        </select>
    </div>
    <div class="form-group mb-2">
        <label for="password">Mật khẩu</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-group mb-2">
        <label for="confirm">Xác nhận mật khẩu</label>
        <input type="password" name="confirm" id="confirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="?action=list" class="btn btn-secondary">Quay lại</a>
</form>