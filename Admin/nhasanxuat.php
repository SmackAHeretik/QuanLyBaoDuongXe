<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN ĐƯỢC QUẢN LÝ NHÀ SẢN XUẤT
// ===============================
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

require_once 'controllers/NhaSanXuatController.php';

$controller = new NhaSanXuatController();
$action = $_GET['action'] ?? 'list';

switch ($action) {
  case 'add':
    $controller->add();
    break;
  case 'edit':
    $controller->edit();
    break;
  case 'delete':
    $controller->delete();
    break;
  default:
    $controller->list(); // mặc định là hiển thị danh sách
}
?>
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