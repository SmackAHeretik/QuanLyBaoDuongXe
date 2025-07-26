<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? '';
$displayName = 'Jhon Doe'; // fallback nếu chưa có session
$roleLabel = 'Chưa xác định';

// Lấy label vai trò đúng theo dữ liệu bảng
if ($user) {
    if ($role === 'admin') {
        $displayName = $user['data']['username'] ?? $user['data']['name'] ?? 'Admin';
        // Lấy Roles từ bảng admin
        $roleLabel = $user['data']['Roles'] ?? 'Admin';
    } elseif ($role === 'staff') {
        $displayName = $user['data']['TenNV'] ?? 'Staff';
        // Lấy Roles từ bảng nhân viên
        $roleLabel = $user['data']['Roles'] ?? 'Nhân viên';
    }
}
?>
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0"><?php echo htmlspecialchars($displayName); ?></h6>
                <span><?php echo htmlspecialchars($roleLabel); ?></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <!-- Trang chủ: ai cũng thấy -->
            <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Trang Chủ</a>

            <?php if ($role === 'admin'): ?>
                <a href="NVmanagement.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Danh Sách Nhân Viên</a>
                <a href="khachhang.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Danh Sách Khách Hàng</a>
                <a href="form.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Danh Sách Phụ Tùng</a>
                <a href="table.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Danh Sách Xe Máy</a>
                <a href="nhasanxuat.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Nhà Sản Xuất</a>
                <a href="dichvu.php" class="nav-item nav-link"><i class="fa fa-concierge-bell me-2"></i>Danh Sách Dịch Vụ</a>
                <!-- DÒNG LỊCH HẸN CHO ADMIN -->
                <a href="danhsachlichhen.php" class="nav-item nav-link"><i class="fa fa-calendar-check me-2"></i>Danh sách Lịch Hẹn</a>
                                    <a href="danhsachlichlamviec.php" class="nav-item nav-link"><i class="fa fa-calendar-check me-2"></i>Lịch làm việc</a>

            <?php elseif ($role === 'staff'): ?>
                <?php if ($roleLabel === 'Thợ sửa xe'): ?>
                    <a href="danhsachlichhen.php" class="nav-item nav-link"><i class="fa fa-calendar-check me-2"></i>Danh sách Lịch Hẹn</a>
                <?php elseif ($roleLabel === 'Nhân viên kế toán'): ?>
                    <a href="NVmanagement.php" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Danh Sách Nhân Viên</a>
                    <a href="khachhang.php" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Danh Sách Khách Hàng</a>
                    <a href="danhsachlichhen.php" class="nav-item nav-link"><i class="fa fa-calendar-check me-2"></i>Danh sách Lịch Hẹn</a>

                <?php endif; ?>
            <?php endif; ?>
        </div>
    </nav>
</div>