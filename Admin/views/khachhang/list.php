<h2>Danh sách khách hàng</h2>
<a href="khachhang.php?action=add" class="btn btn-primary mb-3">Thêm khách hàng</a>
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
            <td>
                <?= htmlspecialchars($kh['TenKH']) ?>
                <!-- Nút "Xe của khách" -->
                <button class="btn btn-sm btn-info ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#xe-<?= $kh['MaKH'] ?>">Xe của khách</button>
                <div class="collapse mt-2" id="xe-<?= $kh['MaKH'] ?>">
                    <?php if (!empty($kh['ds_xe'])): ?>
                        <ul class="list-group">
                            <?php foreach ($kh['ds_xe'] as $xe): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <?= htmlspecialchars($xe['TenXe']) ?> - <?= htmlspecialchars($xe['BienSoXe']) ?>
                                    </span>
                                    <!-- Nút Hóa đơn -->
                                    <button
                                        class="btn btn-sm btn-primary btn-hoa-don"
                                        data-maxe="<?= $xe['MaXE'] ?>"
                                        data-tenxe="<?= htmlspecialchars($xe['TenXe']) ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHoaDonXe"
                                    >
                                        Hóa đơn
                                    </button>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <em>Không có xe nào</em>
                    <?php endif; ?>
                </div>
            </td>
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
                <a href="khachhang.php?action=edit&id=<?= $kh['MaKH'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                <a href="khachhang.php?action=delete&id=<?= $kh['MaKH'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                <?php if ($kh['TrangThai'] == 'hoat_dong'): ?>
                    <a href="khachhang.php?action=block&id=<?= $kh['MaKH'] ?>" class="btn btn-secondary btn-sm">Khóa</a>
                <?php else: ?>
                    <a href="khachhang.php?action=unblock&id=<?= $kh['MaKH'] ?>" class="btn btn-success btn-sm">Mở khóa</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal hiện hóa đơn -->
<div class="modal fade" id="modalHoaDonXe" tabindex="-1" aria-labelledby="hoaDonXeLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hoaDonXeLabel">Danh sách hóa đơn xe: <span id="modalTenXe"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body" id="modalHoaDonContent">
        <div class="text-center text-muted py-3"><i>Đang tải...</i></div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-hoa-don').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const maXe = btn.dataset.maxe;
            const tenXe = btn.dataset.tenxe;
            document.getElementById('modalTenXe').textContent = tenXe;
            document.getElementById('modalHoaDonContent').innerHTML = '<div class="text-center text-muted py-3"><i>Đang tải...</i></div>';
            fetch('ajax_get_hoadon_xe.php?xemay_MaXE=' + maXe)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('modalHoaDonContent').innerHTML = html;
                });
        });
    });
});
</script>