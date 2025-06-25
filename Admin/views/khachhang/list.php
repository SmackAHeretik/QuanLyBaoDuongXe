<h2>Danh sách khách hàng</h2>
<a href="khachhang_controller.php?action=add" class="btn btn-primary mb-3">Thêm khách hàng</a>
<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Mã KH</th>
            <th>Tên KH</th>
            <th>Email</th>
            <th>Điện thoại</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_khachhang as $kh): ?>
        <tr>
            <td><?= htmlspecialchars($kh['MaKH']) ?></td>
            <td><?= htmlspecialchars($kh['TenKH']) ?></td>
            <td><?= htmlspecialchars($kh['Email']) ?></td>
            <td><?= htmlspecialchars($kh['SDT']) ?></td>
            <td><?= htmlspecialchars($kh['DiaChi']) ?></td>
            <td>
                <?php if ($kh['TrangThai'] == 'hoat_dong'): ?>
                    <span class="badge bg-success">Hoạt động</span>
                <?php else: ?>
                    <span class="badge bg-danger">Bị khóa</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="khachhang_controller.php?action=edit&id=<?= $kh['MaKH'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="khachhang_controller.php?action=delete&id=<?= $kh['MaKH'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                <?php if ($kh['TrangThai'] == 'hoat_dong'): ?>
                    <a href="khachhang_controller.php?action=block&id=<?= $kh['MaKH'] ?>" class="btn btn-secondary btn-sm">Khóa</a>
                <?php else: ?>
                    <a href="khachhang_controller.php?action=unblock&id=<?= $kh['MaKH'] ?>" class="btn btn-success btn-sm">Mở khóa</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>