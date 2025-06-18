<?php
// ROUTER & HIỂN THỊ - CHI TIẾT HÓA ĐƠN

require_once __DIR__ . '/db.php';
$db = connectDB();

// Controller & action cho chi tiết hóa đơn
$controller = 'chitiethoadon';
$action = $_GET['action'] ?? 'list';

// Đảm bảo đúng tên file và class
$controllerFile = __DIR__ . '/controllers/' . ucfirst($controller) . 'Controller.php';
if (!file_exists($controllerFile)) {
  die("<div class='p-4 text-danger'>Không tìm thấy controller <b>$controller</b></div>");
}
require_once $controllerFile;
$ctrlClass = ucfirst($controller) . 'Controller';
if (!class_exists($ctrlClass)) {
  die("<div class='p-4 text-danger'>Không tìm thấy class controller <b>$ctrlClass</b></div>");
}
$ctrl = new $ctrlClass($db);

// Bắt đầu bộ nhớ đệm output
ob_start();
if (method_exists($ctrl, $action)) {
  $ctrl->$action();
} else {
  echo "<div class='p-4 text-danger'>Không tìm thấy chức năng <b>$action</b></div>";
}
$mainContent = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <title>DASHMIN - Chi Tiết Hóa Đơn</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="img/favicon.ico" rel="icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <div class="container-xxl position-relative bg-white d-flex p-0">
    <?php include('./layouts/sidebar.php') ?>
    <div class="content">
      <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
        <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
          <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
          <i class="fa fa-bars"></i>
        </a>
        <form class="d-none d-md-flex ms-4">
          <input class="form-control border-0" type="search" placeholder="Search">
        </form>
      </nav>
      <!-- MAIN CONTENT: CHI TIẾT HÓA ĐƠN -->
      <?= $mainContent ?>
      <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded-top p-4">
          <div class="row">
            <div class="col-12 col-sm-6 text-center text-sm-start">
              &copy; <a href="#">Your Site Name</a>, All Right Reserved.
            </div>
            <div class="col-12 col-sm-6 text-center text-sm-end">
              Designed By <a href="https://htmlcodex.com">HTML Codex</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/chart/chart.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/tempusdominus/js/moment.min.js"></script>
  <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
  <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>