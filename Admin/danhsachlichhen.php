<?php
// ===============================
// ROUTER CHUNG - DANH SÁCH LỊCH HẸN
// ===============================
include __DIR__ . '/auth_check.php';
// Kết nối DB và gọi controller
require_once __DIR__ . '/db.php';
$db = connectDB();
require_once __DIR__ . '/controllers/LichHenController.php';
$controller = new LichHenController($db);

// Lấy action từ URL (?action=add, ?action=edit...) hoặc mặc định là 'index'
$action = $_GET['action'] ?? 'index';

// Nếu action là AJAX (update_status), chỉ trả về JSON, không render layout
if ($action === 'update_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo json_encode(['status'=>'fail', 'msg'=>"Không tìm thấy chức năng $action"]);
    }
    exit;
}

// Bắt đầu bộ nhớ đệm output để lấy nội dung chính
ob_start();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "<div class='p-4 text-danger'>Không tìm thấy chức năng <b>$action</b></div>";
}
$mainContent = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <title>DASHMIN - Danh sách lịch hẹn</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
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
      <!-- MAIN CONTENT: GỌI ACTION SAU NAVBAR -->
      <?= $mainContent ?>
      <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded-top p-4">
        <?php include('layouts/form_layout.php'); ?>
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
<script>
document.getElementById('searchInput').addEventListener('input', function(e) {
    let searchValue = e.target.value.trim().toLowerCase().replace(/\s+/g, ' ');
    let rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
        // Ghép text của toàn bộ hàng, loại bỏ khoảng trắng thừa và chuyển về chữ thường
        let rowText = row.textContent.trim().toLowerCase().replace(/\s+/g, ' ');
        if (searchValue === "" || rowText.includes(searchValue)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>