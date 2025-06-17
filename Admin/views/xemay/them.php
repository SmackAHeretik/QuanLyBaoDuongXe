<div class="container mt-4">
    <h2>Thêm xe máy mới</h2>
    <?php if (!empty($msg) && $msg == 'add_fail'): ?>
        <div class="alert alert-danger">Thêm xe máy thất bại!</div>
    <?php endif; ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Tên xe</label>
            <input type="text" name="TenXe" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Loại xe</label>
            <input type="text" name="LoaiXe" class="form-control">
        </div>
        <div class="mb-3">
            <label>Phân khúc</label>
            <input type="text" name="PhanKhuc" class="form-control">
        </div>
        <div class="mb-3">
            <label>Biển số</label>
            <input type="text" name="BienSoXe" class="form-control">
        </div>
        <div class="mb-3">
            <label>Ảnh mặt trước</label>
            <input type="file" name="HinhAnhMatTruocXe" class="form-control">
        </div>
        <div class="mb-3">
            <label>Ảnh mặt sau</label>
            <input type="file" name="HinhAnhMatSauXe" class="form-control">
        </div>
        <div class="mb-3">
            <label>Khách hàng</label>
            <select name="khachhang_MaKH" class="form-control" required>
                <option value="">-- Chọn khách hàng --</option>
                <?php foreach ($khachhangs as $kh): ?>
                    <option value="<?= $kh['MaKH'] ?>"><?= htmlspecialchars($kh['TenKH']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="table.php?controller=xemay&action=index" class="btn btn-secondary">Quay lại</a>
    </form>
</div>