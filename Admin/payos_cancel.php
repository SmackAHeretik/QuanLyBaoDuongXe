<?php $mahd = $_GET['mahd'] ?? ''; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Thanh toán thất bại</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <div class="main-box" style="max-width:400px;margin:40px auto;padding:24px;border-radius:12px;box-shadow:0 2px 12px #0001;background:#fff;">
        <h4 style="color:red;margin-bottom:20px;">Thanh toán thất bại hoặc bị hủy!</h4>
        <p>Bạn có thể thử lại thanh toán cho hóa đơn #<?= htmlspecialchars($mahd) ?>.</p>
        <a href="index.php" class="btn btn-primary">Về trang chủ</a>
    </div>
</body>
</html>