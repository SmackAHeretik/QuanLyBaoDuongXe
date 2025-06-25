<h2>Thêm khách hàng</h2>
<form method="post">
    <div class="mb-3">
        <label class="form-label">Tên khách hàng</label>
        <input type="text" name="TenKH" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="Email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="MatKhau" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Điện thoại</label>
        <input type="text" name="SDT" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Địa chỉ</label>
        <textarea name="DiaChi" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="TrangThai" class="form-select">
            <option value="hoat_dong">Hoạt động</option>
            <option value="bi_khoa">Bị khóa</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm</button>
    <a href="khachhang_controller.php" class="btn btn-secondary">Hủy</a>
</form>