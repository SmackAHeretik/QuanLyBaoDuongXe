<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
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
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>67 Performance</title>
  <!-- CSS FILES -->                
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.css" rel="stylesheet">
  <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
  <style>
    .section-padding {
      padding: 120px 0 50px 0;
    }
    @media (max-width: 991px) {
      .section-padding {
        padding-top: 100px;
      }
    }
    .schedule-table th, .schedule-table td {
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
  <main>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>
    <section class="section-padding">
      <div class="container">
        <h2 class="mb-4">Lịch Hẹn Đã Đặt</h2>
        <p class="text-muted text-center mb-4">Dưới đây là các lịch hẹn mà bạn đã đặt tại 67 Performance</p>
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle schedule-table shadow">
            <thead class="table-dark">
              <tr>
                <th>STT</th>
                <th>Ngày hẹn</th>
                <th>Thời gian</th>
                <th>Thợ sửa xe</th>
                <th>Loại xe</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($lichhen)): ?>
                <tr>
                  <td colspan="8" class="text-center">Bạn chưa có lịch hẹn nào!</td>
                </tr>
              <?php else: ?>
                <?php foreach ($lichhen as $i => $row): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                      <?php
                      $ngay = isset($row['NgayHen']) ? date('d/m/Y', strtotime($row['NgayHen'])) : '';
                      echo $ngay;
                      ?>
                    </td>
                    <td><?= htmlspecialchars($row['ThoiGianCa'] ?? '') ?></td>
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
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="text-center mt-4">
          <a href="index.php" class="btn custom-btn custom-border-btn">Quay về trang chủ</a>
        </div>
      </div>
    </section>
    <?php include('./layouts/button/button.php') ?>
  </main>
  <?php include('./layouts/footer/footer.php') ?>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/click-scroll.js"></script>
  <script src="js/animated-headline.js"></script>
  <script src="js/modernizr.js"></script>
  <script src="js/mega-menu.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script>
    const newsSwiper = new Swiper('.news-swiper', {
      slidesPerView: 3,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        0: { slidesPerView: 1 },
        576: { slidesPerView: 1.5 },
        768: { slidesPerView: 2 },
        992: { slidesPerView: 3 }
      }
    });
  </script>
  <script src="js/custom.js"></script>
</body>
</html>