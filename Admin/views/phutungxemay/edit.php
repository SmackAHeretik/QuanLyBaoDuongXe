<div class="container mt-4">
    <h2>Cập nhật phụ tùng xe máy</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="TenSP" class="form-control" value="<?= htmlspecialchars($item['TenSP']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Số series</label>
            <input type="text" name="SoSeriesSP" class="form-control" value="<?= htmlspecialchars($item['SoSeriesSP']) ?>">
        </div>
        <div class="mb-3">
            <label>Miêu tả</label>
            <textarea name="MieuTaSP" class="form-control"><?= htmlspecialchars($item['MieuTaSP']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Năm sản xuất</label>
            <input type="number" name="NamSX" class="form-control" value="<?= htmlspecialchars($item['NamSX']) ?>">
        </div>
        <div class="mb-3">
            <label>Xuất xứ</label>
            <input type="text" name="XuatXu" class="form-control" value="<?= htmlspecialchars($item['XuatXu']) ?>">
        </div>
        <div class="mb-3">
            <label>Thời gian bảo hành định kỳ</label>
            <input type="text" name="ThoiGianBaoHanhDinhKy" class="form-control" value="<?= htmlspecialchars($item['ThoiGianBaoHanhDinhKy']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Đơn giá</label>
            <input type="number" name="DonGia" class="form-control" min="1" value="<?= htmlspecialchars($item['DonGia']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Loại phụ tùng</label>
            <select name="loaiphutung" class="form-control" required>
                <option value="">-- Chọn loại phụ tùng --</option>
                <option value="Xe tay ga" <?= ($item['loaiphutung']=="Xe tay ga") ? 'selected' : '' ?>>Xe tay ga</option>
                <option value="Xe số" <?= ($item['loaiphutung']=="Xe số") ? 'selected' : '' ?>>Xe số</option>
                <option value="Xe côn tay" <?= ($item['loaiphutung']=="Xe côn tay") ? 'selected' : '' ?>>Xe côn tay</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nhà sản xuất</label>
            <select name="nhasanxuat_MaNSX" class="form-control" required>
                <option value="">-- Chọn nhà sản xuất --</option>
                <?php foreach ($listNSX as $nsx): ?>
                    <option value="<?= $nsx['MaNSX'] ?>" <?= ($item['nhasanxuat_MaNSX'] == $nsx['MaNSX']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nsx['TenNhaSX']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Số lần bảo hành tối đa</label>
            <input type="number" name="SoLanBaoHanhToiDa" class="form-control" min="0" value="<?= htmlspecialchars($item['SoLanBaoHanhToiDa']) ?>">
        </div>
        <div class="mb-3">
            <label>Hình ảnh</label>
            <?php if (!empty($item['HinhAnh'])): ?>
                <div>
                    <img src="<?= htmlspecialchars($item['HinhAnh']) ?>" style="max-width:100px;">
                </div>
            <?php endif; ?>
            <input type="file" name="HinhAnh" class="form-control">
        </div>
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="TrangThai" class="form-control">
                <option value="1" <?= $item['TrangThai']==1 ? 'selected' : '' ?>>Hiển thị</option>
                <option value="0" <?= $item['TrangThai']==0 ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
        <a href="?action=list" class="btn btn-secondary">Quay lại</a>
    </form>
</div>