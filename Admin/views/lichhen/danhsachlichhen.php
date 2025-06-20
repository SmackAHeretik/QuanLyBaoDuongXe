<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Danh sách Lịch Hẹn</h3>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>Mã lịch hẹn</th>
        <th>Tên xe</th>
        <th>Loại xe</th>
        <th>Phân khúc</th>
        <th>Ngày hẹn</th>
        <th>Thời gian ca</th>
        <th>Trạng thái</th>
        <th>Mô tả lý do</th>
        <th>Nhân viên</th>
        <th>Khách hàng</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($lichhen)): foreach ($lichhen as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['MaLH']) ?></td>
        <td><?= htmlspecialchars($row['TenXe']) ?></td>
        <td><?= htmlspecialchars($row['LoaiXe']) ?></td>
        <td><?= htmlspecialchars($row['PhanKhuc']) ?></td>
        <td><?= htmlspecialchars($row['NgayHen']) ?></td>
        <td><?= htmlspecialchars($row['ThoiGianCa']) ?></td>
        <td><?= htmlspecialchars($row['TrangThai']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['MoTaLyDoHen'])) ?></td>
        <td><?= htmlspecialchars($row['nhanvien_MaNV']) ?></td>
        <td><?= htmlspecialchars($row['khachhang_MaKH']) ?></td>
      </tr>
      <?php endforeach; else: ?>
      <tr>
        <td colspan="10" class="text-center">Không có lịch hẹn nào.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>