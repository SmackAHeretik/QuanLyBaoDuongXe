<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Danh sách nhân viên</h4>
            <a href="?action=add" class="btn btn-success">
                <i class="fa fa-plus"></i> Thêm nhân viên
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>STT</th>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Vai trò</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dsStaff)): ?>
                        <?php foreach ($dsStaff as $key => $nv): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($nv['MaNV']) ?></td>
                                <td><?= htmlspecialchars($nv['TenNV']) ?></td>
                                <td><?= htmlspecialchars($nv['Email']) ?></td>
                                <td><?= htmlspecialchars($nv['SDT']) ?></td>
                                <td><?= htmlspecialchars($nv['Roles'] ?? 'Chưa xác định') ?></td>
                                <td class="text-center">
                                    <a href="?action=edit&id=<?= $nv['MaNV'] ?>" class="btn btn-sm btn-primary me-1" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="?action=delete&id=<?= $nv['MaNV'] ?>" class="btn btn-sm btn-danger"
                                       title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Không có nhân viên nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>