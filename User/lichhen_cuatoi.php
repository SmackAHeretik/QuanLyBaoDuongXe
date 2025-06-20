<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
ini_set('display_errors', 0);
error_reporting(0);
include_once './utils/ConnectDb.php';
require_once __DIR__ . '/model/LichHenModel.php';

$db = (new ConnectDb())->connect();

$makh = $_SESSION['MaKH'] ?? null;

// XỬ LÝ HỦY LỊCH
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel' && isset($_POST['malich'])) {
  $model = new LichHenModel($db);
  $malich = intval($_POST['malich']);
  $lich = $model->getLichById($malich);
  if (
    $lich && ($lich['khachhang_MaKH'] ?? $lich['lichen_khachhang_MaKH'] ?? null) == $makh &&
    ($lich['TrangThai'] === 'pending' || $lich['TrangThai'] === 'cho duyet')
  ) {
    $model->updateTrangThai($malich, 'cancelled');
    header("Location: lichhen_cuatoi.php");
    exit;
  }
}

// Lấy danh sách lịch hẹn
$lichhen = [];
if ($makh) {
  $model = new LichHenModel($db);
  $lichhen = $model->getLichHenByKhachHang($makh);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Lịch hẹn của tôi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.css" rel="stylesheet">
  <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
  <style>
    .schedule-section {
      background: #f8f9fa;
      padding: 50px 0;
    }

    .schedule-table th,
    .schedule-table td {
      vertical-align: middle;
    }

    .schedule-table th {
      background: #20232a;
      color: #fff;
    }

    .schedule-table tr:nth-child(even) {
      background: #f4f6fb;
    }

    .badge-status {
      font-size: 1em;
    }
  </style>
</head>

<body>
  <?php include('./layouts/navbar/navbar.php'); ?>

  <section class="schedule-section">
    <div class="container">
      <div class="row mb-4">
        <div class="col-12 text-center">
          <h2 class="mb-3" style="font-weight:700;letter-spacing:2px;">LỊCH HẸN ĐÃ ĐẶT</h2>
          <p class="text-muted">Dưới đây là các lịch hẹn mà bạn đã đặt tại 67 Performance</p>
        </div>
      </div>
      <?php if (empty($lichhen)): ?>
        <div class="alert alert-info text-center">Bạn chưa có lịch hẹn nào!</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover schedule-table shadow">
            <thead>
              <tr>
                <th>STT</th>
                <th>Ngày hẹn</th>
                <th>Nhân viên</th>
                <th>Loại xe</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($lichhen as $i => $row): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td>
                    <?php
                    $ngay = isset($row['NgayHen']) ? date('d/m/Y', strtotime($row['NgayHen'])) : '';
                    $ca = $row['ThoiGianCa'] ?? '';
                    echo trim($ngay . ($ca ? ' - ' . $ca : ''));
                    ?>
                  </td>
                  <td><?= htmlspecialchars($row['TenNV'] ?? 'Chưa phân công') ?></td>
                  <td><?= htmlspecialchars($row['LoaiXe'] ?? '-') ?></td>
                  <td><?= htmlspecialchars($row['MoTaLyDo'] ?? '-') ?></td>
                  <td>
                    <?php
                    $status = $row['TrangThai'] ?? '';
                    if ($status === 'pending' || $status === 'cho duyet') {
                      echo '<span class="badge bg-warning text-dark badge-status">Chờ xét duyệt</span>';
                    } else if ($status === 'confirmed' || $status === 'da duyet') {
                      echo '<span class="badge bg-success badge-status">Đã xét duyệt</span>';
                    } else if ($status === 'cancelled' || $status === 'huy') {
                      echo '<span class="badge bg-danger badge-status">Hủy</span>';
                    } else {
                      echo '<span class="badge bg-secondary badge-status">' . htmlspecialchars($status) . '</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php if ($status === 'pending' || $status === 'cho duyet'): ?>
                      <form method="post" action="lichhen_cuatoi.php"
                        onsubmit="return confirm('Bạn có chắc muốn hủy lịch hẹn này không?');">
                        <input type="hidden" name="action" value="cancel">
                        <input type="hidden" name="malich" value="<?= $row['MaLich'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hủy lịch</button>
                      </form>
                    <?php else: ?>
                      <!-- Để trống, không echo gì cả -->
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
      <div class="text-center mt-4">
        <a href="index.php" class="btn custom-btn custom-border-btn">Quay về trang chủ</a>
      </div>
    </div>
  </section>

  <?php include('./layouts/footer/footer.php'); ?>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>