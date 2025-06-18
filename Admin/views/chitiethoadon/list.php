<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0">Danh sách chi tiết hóa đơn</h5>
      <a href="?controller=chitiethoadon&action=add" class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm mới
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>STT</th>
            <th>Mã HD</th>
            <th>Mã PTung</th>
            <th>Mã DVu</th>
            <th>Giá tiền</th>
            <th>Số lượng</th>
            <th>Ngày bắt đầu BH</th>
            <th>Ngày kết thúc BH</th>
            <th>Số lần đã bảo hành</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($dsChiTietHD)): ?>
            <?php foreach ($dsChiTietHD as $key => $row): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= htmlspecialchars($row['hoadon_MaHD']) ?></td>
                <td><?= htmlspecialchars($row['phutungxemay_MaSP']) ?></td>
                <td><?= htmlspecialchars($row['dichvu_MaDV']) ?></td>
                <td><?= number_format($row['GiaTien'], 0, ',', '.') ?> VND</td>
                <td><?= htmlspecialchars($row['SoLuong']) ?></td>
                <td><?= htmlspecialchars($row['NgayBDBH']) ?></td>
                <td><?= htmlspecialchars($row['NgayKTBH']) ?></td>
                <td><?= htmlspecialchars($row['SoLanDaBaoHanh']) ?></td>
                <td class="text-center">
                  <a href="?controller=chitiethoadon&action=edit&id=<?= $row['MaCTHD'] ?>"
                    class="btn btn-sm btn-primary me-1" title="Sửa">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="?controller=chitiethoadon&action=delete&id=<?= $row['MaCTHD'] ?>" class="btn btn-sm btn-danger"
                    title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="10" class="text-center text-muted">Không có chi tiết hóa đơn nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- FontAwesome Icons (nếu chưa có) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">