<?php
session_start();
require_once(__DIR__ . '/utils/ConnectDb.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaKH'])) {
  header("Location: login.php");
  exit();
}

$MaKH = $_SESSION['MaKH'];
$db = new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe");
$conn = $db->connect();

// Xử lý hủy lịch hẹn (chỉ cho phép nếu pending)
if (isset($_GET['cancel']) && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("UPDATE lichhen SET TrangThai = 'cancelled' WHERE MaLich = ? AND TrangThai = 'pending' AND lichen_khachhang_MaKH = ?");
  $stmt->execute([$id, $MaKH]);
  header("Location: xemlichhen.php");
  exit();
}

// Lấy lịch hẹn của user
$stmt = $conn->prepare("SELECT MaLich, NgayHen, TrangThai, LoaiXe, MoTaLyDoHen FROM lichhen WHERE lichen_khachhang_MaKH = ? ORDER BY NgayHen DESC");
$stmt->execute([$MaKH]);
$lichhen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
  <style>
    .thead-blue {
      background-color: #2563eb !important;
      color: #fff !important;
    }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lịch hẹn của tôi</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap"
    rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-icons.css" rel="stylesheet">
  <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">

</head>

<body>
  <main>

    <?php include('./layouts/navbar/navbar.php'); ?>
    <section class="membership-section section-padding" id="section_lichhen">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-12 text-center mx-auto mb-lg-5 mb-4">
            <h2><span>Lịch hẹn</span> của tôi</h2>
          </div>
          <div class="col-lg-10 col-12 mx-auto">
            <div class="custom-form membership-form shadow-lg p-4">
              <?php if (count($lichhen) == 0): ?>
                <div class="alert alert-info text-center mb-0">Bạn chưa có lịch hẹn nào.</div>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-bordered align-middle text-center mb-0">
                    <thead class="thead-blue">
                      <tr>
                        <th>#</th>
                        <th>Ngày hẹn</th>
                        <th>Loại xe</th>
                        <th>Lý do hẹn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    <?php foreach ($lichhen as $i => $lh): ?>
                      <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($lh['NgayHen'])) ?></td>
                        <td><?= htmlspecialchars($lh['LoaiXe']) ?></td>
                        <td class="text-start"><?= nl2br(htmlspecialchars($lh['MoTaLyDoHen'])) ?></td>
                        <td>
                          <?php if ($lh['TrangThai'] == 'pending'): ?>
                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                          <?php elseif ($lh['TrangThai'] == 'confirmed'): ?>
                            <span class="badge bg-success">Đã duyệt</span>
                          <?php else: ?>
                            <span class="badge bg-danger">Đã hủy</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($lh['TrangThai'] == 'pending'): ?>
                            <a href="?cancel=1&id=<?= $lh['MaLich'] ?>" class="btn btn-outline-danger btn-sm"
                              onclick="return confirm('Bạn có chắc muốn hủy lịch hẹn này không?');">
                              Hủy
                            </a>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include('./layouts/footer/footer.php'); ?>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/click-scroll.js"></script>
  <script src="js/animated-headline.js"></script>
  <script src="js/modernizr.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>