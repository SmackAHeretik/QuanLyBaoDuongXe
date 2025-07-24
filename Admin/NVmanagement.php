<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN VÀ KẾ TOÁN ĐƯỢC QUẢN LÝ NHÂN VIÊN
// ===============================
$requiredRole = 'ketoan'; // đổi từ 'admin' sang 'ketoan'
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/controllers/StaffController.php';
$action = $_GET['action'] ?? 'list';
$ctrl = new StaffController();

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
    <title>Quản lý Nhân viên</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <?php include('./layouts/sidebar.php') ?>
        <div class="content">
            <?php include('./layouts/navbar.php') ?>
            <?= $mainContent ?>
        </div>
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
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