<div class="container mt-4">
    <h2>Thêm phụ tùng xe máy</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="TenSP" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Số series</label>
            <input type="text" name="SoSeriesSP" class="form-control">
        </div>
        <div class="mb-3">
            <label>Miêu tả</label>
            <textarea name="MieuTaSP" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Năm sản xuất</label>
            <input type="number" name="NamSX" class="form-control">
        </div>
        <div class="mb-3">
            <label>Xuất xứ</label>
            <input type="text" name="XuatXu" class="form-control">
        </div>
        <div class="mb-3">
            <label>Thời gian bảo hành định kỳ</label>
            <input type="text" name="ThoiGianBaoHanhDinhKy" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Đơn giá</label>
            <input type="number" name="DonGia" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label>Loại phụ tùng</label>
            <select name="loaiphutung" class="form-control" required>
                <option value="">-- Chọn loại phụ tùng --</option>
                <option value="Xe tay ga">Xe tay ga</option>
                <option value="Xe số">Xe số</option>
                <option value="Xe côn tay">Xe côn tay</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nhà sản xuất</label>
            <select name="nhasanxuat_MaNSX" class="form-control" required>
                <option value="">-- Chọn nhà sản xuất --</option>
                <?php foreach ($listNSX as $nsx): ?>
                    <option value="<?= $nsx['MaNSX'] ?>"><?= htmlspecialchars($nsx['TenNhaSX']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Số lần bảo hành tối đa</label>
            <input type="number" name="SoLanBaoHanhToiDa" class="form-control" min="0">
        </div>
        <div class="mb-3">
            <label>Hình ảnh</label>
            <input type="file" name="HinhAnh" class="form-control">
        </div>
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="TrangThai" class="form-control">
                <option value="1" selected>Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="?action=list" class="btn btn-secondary">Quay lại</a>
    </form>
</div>