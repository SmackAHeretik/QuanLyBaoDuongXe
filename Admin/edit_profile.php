<?php
// ===============================
// PHÂN QUYỀN: CHỈ NHÂN VIÊN ĐĂNG NHẬP MỚI ĐƯỢC SỬA
// ===============================
$requiredRole = 'staff';
include __DIR__ . '/auth_check.php';

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/StaffModel.php';

// Lấy thông tin nhân viên từ session
$user = $_SESSION['user'] ?? null;
$staffId = $user['data']['MaNV'] ?? null;

// Khởi tạo model và lấy dữ liệu mới nhất
$db = connectDB();
$model = new StaffModel($db);
$staffData = $model->getById($staffId);

$error = '';
$success = '';

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tennv = trim($_POST['tennv'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sdt = trim($_POST['sdt'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$tennv || !$email || !$sdt) {
        $error = "Vui lòng điền đầy đủ thông tin!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    } elseif ($password && $password !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp!";
    } else {
        $data = [
            'tennv' => $tennv,
            'email' => $email,
            'sdt' => $sdt,
            'password' => $password // để trống nếu không đổi
        ];
        if ($model->update($staffId, $data)) {
            // Cập nhật lại session cho nhân viên
            $updatedStaff = $model->getById($staffId);
            $_SESSION['user']['data'] = $updatedStaff;
            $success = "Cập nhật thành công!";
            $staffData = $updatedStaff;
        } else {
            $error = "Cập nhật thất bại!";
        }
    }
}

// build nội dung chính
ob_start();
?>
<div class="container py-4">
    <h3 class="mb-4">Cập nhật thông tin cá nhân</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <form method="post" class="bg-light p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="tennv" class="form-label">Tên nhân viên</label>
            <input type="text" class="form-control" id="tennv" name="tennv"
                   value="<?php echo htmlspecialchars($staffData['TenNV']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?php echo htmlspecialchars($staffData['Email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="sdt" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt"
                   value="<?php echo htmlspecialchars($staffData['SDT']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
            <small class="text-muted">Để trống nếu không muốn đổi mật khẩu.</small>
        </div>
        <div class="mb-3">
            <label for="confirm" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control" id="confirm" name="confirm" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
<?php
$mainContent = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Cập nhật thông tin nhân viên</title>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>