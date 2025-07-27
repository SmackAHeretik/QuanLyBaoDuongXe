<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Danh sách lịch làm việc</h4>
            <a href="?action=add" class="btn btn-success">
                <i class="fa fa-plus"></i> Thêm lịch làm việc
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>STT</th>
                        <th>Mã LLV</th>
                        <th>Ngày</th>
                        <th>Trạng thái</th>
                        <th>Ca làm việc</th>
                        <th>Cuối tuần</th>
                        <th>Nghỉ lễ</th>
                        <th>Nhân viên đảm nhiệm</th>
                        <th>Admin ID</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dsLich)): ?>
                        <?php
                        foreach ($dsLich as $key => $llv):
                            $dsNhanVien = $phancongModel->getNhanVienByMaLLV($llv['MaLLV']); // Trả về mảng ['MaNV', 'TenNV']
                            $tenNhanVien = array_column($dsNhanVien, 'TenNV');
                        ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($llv['MaLLV']) ?></td>
                                <td><?= htmlspecialchars($llv['ngay']) ?></td>
                                <td><?= htmlspecialchars($llv['TrangThai']) ?></td>
                                <td><?= htmlspecialchars($llv['ThoiGianCa']) ?></td>
                                <td><?= $llv['LaNgayCuoiTuan'] ? 'Có' : 'Không' ?></td>
                                <td><?= $llv['LaNgayNghiLe'] ? 'Có' : 'Không' ?></td>
                                <td>
                                    <?php
                                    if (!empty($tenNhanVien)) {
                                        echo htmlspecialchars(implode(', ', $tenNhanVien));
                                    } else {
                                        echo '<span class="text-muted">Chưa phân công</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($llv['admin_AdminID']) ?></td>
                                <td class="text-center">
                                    <a href="?action=edit&id=<?= $llv['MaLLV'] ?>" class="btn btn-sm btn-primary me-1" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="?action=delete&id=<?= $llv['MaLLV'] ?>" class="btn btn-sm btn-danger"
                                       title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch này?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">Không có lịch làm việc nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>