<?php
// Có thể nhận $mahd nếu muốn, nhưng không cần thiết ở đây
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanh toán thất bại hoặc bị hủy</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Thanh toán thất bại hoặc bị hủy',
        text: 'Bạn có thể thử lại thanh toán sau!',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = 'khachhang.php';
    });
});
</script>
</body>
</html>