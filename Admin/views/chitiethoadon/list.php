<?php
// $dsChiTietHD đã có từ controller, mỗi row có: hoadon_MaHD, phutungxemay_MaSP, TenSP, dichvu_MaDV, TenDV, GiaTien, SoLuong, NgayBDBH, NgayKTBH, SoLanDaBaoHanh, MaCTHD
// $trangThaiHoaDon đã được truyền từ controller
// Tính tổng tiền phụ tùng & tổng tiền dịch vụ
$tongPhuTung = 0;
$tongDichVu = 0;
foreach ($dsChiTietHD as $row) {
  $thanhTien = $row['GiaTien'] * $row['SoLuong'];
  if (!empty($row['phutungxemay_MaSP'])) {
    $tongPhuTung += $thanhTien;
  } elseif (!empty($row['dichvu_MaDV'])) {
    $tongDichVu += $thanhTien;
  }
}
?>
<div class="container-fluid pt-4 px-4">
  <div class="bg-light rounded p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0">Chi tiết hóa đơn
        <?php if (isset($_GET['hoadon_MaHD']) && $_GET['hoadon_MaHD']): ?>
          <span class="badge bg-info">Mã HĐ: <?= htmlspecialchars($_GET['hoadon_MaHD']) ?></span>
        <?php endif; ?>
      </h5>
      <div class="d-flex align-items-center gap-2">
        <?php if ($trangThaiHoaDon === 'da_thanh_toan'): ?>
          <a href="inhoadon.php?mahd=<?= intval($_GET['hoadon_MaHD']) ?>" class="btn btn-dark" target="_blank">
            <i class="fa fa-print"></i> In hóa đơn
          </a>
        <?php endif; ?>
        <a href="?controller=chitiethoadon&action=add<?= isset($_GET['hoadon_MaHD']) ? '&hoadon_MaHD='.intval($_GET['hoadon_MaHD']) : '' ?>" class="btn btn-success">
          <i class="fa fa-plus"></i> Thêm mới
        </a>
      </div>
    </div>
    <div class="mb-3">
      <span class="fw-bold">Tổng tiền phụ tùng:</span> <span class="text-primary"><?= number_format($tongPhuTung, 0, ',', '.') ?> VND</span> &nbsp; | &nbsp;
      <span class="fw-bold">Tổng tiền dịch vụ:</span> <span class="text-success"><?= number_format($tongDichVu, 0, ',', '.') ?> VND</span>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-primary">
          <tr>
            <th>STT</th>
            <th>Mã HĐ</th>
            <th>Phụ tùng</th>
            <th>Mã DVu</th>
            <th>Tên dịch vụ</th>
            <th>Giá tiền</th>
            <th>Số lượng</th>
            <th>Ngày bắt đầu BH</th>
            <th>Ngày kết thúc BH</th>
            <th>Số lần bảo hành còn lại</th>
            <th class="text-center">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($dsChiTietHD)): ?>
            <?php foreach ($dsChiTietHD as $key => $row): ?>
              <tr>
                <td><?= $key + 1 ?></td>
                <td><?= htmlspecialchars($row['hoadon_MaHD']) ?></td>
                <td>
                  <?php if (!empty($row['phutungxemay_MaSP'])): ?>
                    <?= htmlspecialchars($row['phutungxemay_MaSP']) ?>
                    <?php if (!empty($row['TenSP'])): ?>
                      <br><span class="text-muted small"><?= htmlspecialchars($row['TenSP']) ?></span>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted">--</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($row['dichvu_MaDV'])): ?>
                    <?= htmlspecialchars($row['dichvu_MaDV']) ?>
                  <?php else: ?>
                    <span class="text-muted">--</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($row['TenDV'])): ?>
                    <?= htmlspecialchars($row['TenDV']) ?>
                  <?php else: ?>
                    <span class="text-muted">--</span>
                  <?php endif; ?>
                </td>
                <td><?= number_format($row['GiaTien'], 0, ',', '.') ?> VND</td>
                <td><?= htmlspecialchars($row['SoLuong']) ?></td>
                <td>
                  <?= !empty($row['NgayBDBH']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($row['NgayBDBH']))) : '<span class="text-muted">--</span>' ?>
                </td>
                <td>
                  <?= !empty($row['NgayKTBH']) ? htmlspecialchars(date('d/m/Y H:i', strtotime($row['NgayKTBH']))) : '<span class="text-muted">--</span>' ?>
                </td>
                <td><?= htmlspecialchars($row['SoLanDaBaoHanh']) ?></td>
                <td class="text-center">
                  <a href="?controller=chitiethoadon&action=edit&id=<?= $row['MaCTHD'] ?>&hoadon_MaHD=<?= htmlspecialchars($row['hoadon_MaHD']) ?>"
                    class="btn btn-sm btn-primary me-1" title="Sửa">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="?controller=chitiethoadon&action=delete&id=<?= $row['MaCTHD'] ?>&hoadon_MaHD=<?= htmlspecialchars($row['hoadon_MaHD']) ?>" class="btn btn-sm btn-danger"
                    title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="11" class="text-center text-muted">Không có chi tiết hóa đơn cho hóa đơn này.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <a href="khachhang.php?controller=hoadon&action=index" class="btn btn-secondary mt-3"><i class="fa fa-arrow-left"></i> Quay lại danh sách hóa đơn</a>
  </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">