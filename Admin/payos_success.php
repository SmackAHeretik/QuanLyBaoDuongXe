<?php $mahd = $_GET['mahd'] ?? ''; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Thanh toán thành công</title>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <div class="main-box" style="max-width:400px;margin:40px auto;padding:24px;border-radius:12px;box-shadow:0 2px 12px #0001;background:#fff;">
        <h4 style="color:green;margin-bottom:20px;">Thanh toán thành công!</h4>
        <p>Bạn đã thanh toán thành công cho hóa đơn #<?= htmlspecialchars($mahd) ?>.</p>
        <a href="index.php" class="btn btn-success">Về trang chủ</a>
    </div>
</body>
</html>