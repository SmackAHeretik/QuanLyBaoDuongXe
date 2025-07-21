<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN ĐƯỢC XEM
// ===============================
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

// ===============================
// ROUTER VÀ HIỂN THỊ - CHỈ GỌI CONTROLLER, KHÔNG TRỰC TIẾP TRUY VẤN DB Ở ĐÂY
// ===============================

// Kết nối DB (nếu controller/model cần dùng PDO)
require_once __DIR__ . '/db.php';
$db = connectDB();

// Mặc định controller là 'dichvu' để xem danh sách dịch vụ
$controller = $_GET['controller'] ?? 'dichvu';
$action = $_GET['action'] ?? 'index';

// Đảm bảo đúng phân biệt hoa thường tên file và class!
$controllerFile = __DIR__ . '/controllers/' . ucfirst($controller) . 'Controller.php';
if (!file_exists($controllerFile)) {
  die("<div class='p-4 text-danger'>Không tìm thấy controller <b>$controller</b></div>");
}
require_once $controllerFile;
$ctrlClass = ucfirst($controller) . 'Controller';
if (!class_exists($ctrlClass)) {
  die("<div class='p-4 text-danger'>Không tìm thấy class controller <b>$ctrlClass</b></div>");
}
// Truyền $db nếu controller cần (chuẩn MVC)
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
  <title>DASHMIN - Danh sách dịch vụ</title>
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
      <?php include('./layouts/navbar.php') ?>
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
// Loại bỏ dấu tiếng Việt
function stripVietnamese(str) {
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    return str;
}

// Xử lý loại bỏ khoảng trắng đầu/cuối, thừa giữa các từ trước khi submit (search server)
document.getElementById('searchForm').addEventListener('submit', function(e) {
    var input = document.getElementById('searchInput');
    input.value = input.value.trim().replace(/\s+/g, ' ');
});

// Lọc realtime trên bảng không phân biệt hoa/thường, có dấu/không dấu
document.getElementById('searchInput').addEventListener('input', function(e) {
    let searchValue = stripVietnamese(e.target.value.trim().replace(/\s+/g, ' '));
    let rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
        let rowText = stripVietnamese(row.textContent.trim().replace(/\s+/g, ' '));
        if (searchValue === "" || rowText.includes(searchValue)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>