<div class="container mt-4">
    <h2>Cập nhật xe máy</h2>
    <?php if (!empty($msg) && $msg == 'edit_fail'): ?>
        <div class="alert alert-danger">Sửa xe máy thất bại!</div>
    <?php endif; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên xe</label>
            <input type="text" name="TenXe" class="form-control" value="<?= htmlspecialchars($xemay['TenXe']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Loại xe</label>
            <input type="text" name="LoaiXe" class="form-control" value="<?= htmlspecialchars($xemay['LoaiXe']) ?>">
        </div>
        <div class="mb-3">
            <label>Phân khúc</label>
            <input type="text" name="PhanKhuc" class="form-control" value="<?= htmlspecialchars($xemay['PhanKhuc']) ?>">
        </div>
        <div class="mb-3">
            <label>Biển số</label>
            <input type="text" name="BienSoXe" class="form-control" value="<?= htmlspecialchars($xemay['BienSoXe']) ?>">
        </div>
        <div class="mb-3">
            <label>Ảnh mặt trước</label>
            <?php if ($xemay['HinhAnhMatTruocXe']): ?>
                <div>
                    <img src="uploads/<?= htmlspecialchars($xemay['HinhAnhMatTruocXe']) ?>" style="max-width:100px;">
                </div>
            <?php endif; ?>
            <input type="file" name="HinhAnhMatTruocXe" class="form-control">
            <input type="hidden" name="HinhAnhMatTruocXe_current" value="<?= htmlspecialchars($xemay['HinhAnhMatTruocXe']) ?>">
        </div>
        <div class="mb-3">
            <label>Ảnh mặt sau</label>
            <?php if ($xemay['HinhAnhMatSauXe']): ?>
                <div>
                    <img src="uploads/<?= htmlspecialchars($xemay['HinhAnhMatSauXe']) ?>" style="max-width:100px;">
                </div>
            <?php endif; ?>
            <input type="file" name="HinhAnhMatSauXe" class="form-control">
            <input type="hidden" name="HinhAnhMatSauXe_current" value="<?= htmlspecialchars($xemay['HinhAnhMatSauXe']) ?>">
        </div>
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="khachhang_MaKH" class="form-control" required>
                <option value="">-- Chọn khách hàng --</option>
                <?php foreach ($khachhangs as $kh): ?>
                    <option value="<?= $kh['MaKH'] ?>" <?= $xemay['khachhang_MaKH']==$kh['MaKH'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kh['TenKH']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
        <a href="table.php?controller=xemay&action=index" class="btn btn-secondary">Quay lại</a>
    </form>
</div>