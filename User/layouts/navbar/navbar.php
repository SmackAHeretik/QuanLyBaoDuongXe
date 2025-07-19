<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy phụ tùng nổi bật
$phutung_list = [];
$bike_list = [];
$conn = mysqli_connect('localhost', 'root', '', 'quanlybaoduongxe');
if ($conn) {
    mysqli_set_charset($conn, 'utf8mb4');
    // Phụ tùng nổi bật
    $sql = "SELECT MaSP, TenSP, DonGia, HinhAnh FROM phutungxemay WHERE TrangThai=1 LIMIT 4";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $phutung_list[] = $row;
    }
    // Xe của bạn
    if (isset($_SESSION['MaKH'])) {
        $makh = (int)$_SESSION['MaKH'];
        $sql_bike = "SELECT MaXe, TenXe, BienSoXe, HinhAnhMatTruocXe FROM xemay WHERE khachhang_MaKH = $makh";
        $result_bike = mysqli_query($conn, $sql_bike);
        while ($row_bike = mysqli_fetch_assoc($result_bike)) {
            $bike_list[] = $row_bike;
        }
    }
    mysqli_close($conn);
}
?>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="images/logo.png" class="navbar-brand-image img-fluid" alt="Logo">
            <span class="navbar-brand-text">
                67 Performance
                <small>Chăm Sóc / Bảo Dưỡng Xe</small>
            </span>
        </a>
        <div class="d-lg-none ms-auto me-3">
            <a class="btn custom-btn custom-border-btn" data-bs-toggle="offcanvas" href="#offcanvasExample">Login</a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Về chúng tôi</a>
                </li>
                <!-- Mega menu Xe của bạn: luôn hiện -->
                <li class="nav-item dropdown position-static mega-hover">
                    <a class="nav-link dropdown-toggle" id="megaMenuButton" href="bike_list.php">Xe của bạn</a>
                    <div class="dropdown-menu w-100 mt-0 border-0 shadow mega-menu" id="megaMenu">
                        <div class="container py-4 position-relative">
                            <?php if (!isset($_SESSION['MaKH'])): ?>
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <div class="alert alert-warning d-inline-block px-4 py-3" style="background: #fffbe6; font-size: 1.2rem;">
                                            Bạn hãy <a href="login.php" class="text-primary text-decoration-underline">đăng nhập</a> để tiếp tục.
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="bike_list.php" class="h6 text-uppercase mb-3 d-inline-block text-decoration-none text-dark">Xe của bạn</a>
                                <!-- Nút thêm xe -->
                                <a href="/QuanLyBaoDuongXe/User/bikeprofile.php"
                                   class="btn btn-success position-absolute"
                                   style="top: 10px; right: 10px; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; padding:0;"
                                   title="Thêm xe">
                                    +
                                </a>
                                <div class="row justify-content-center">
                                    <?php if (!empty($bike_list)): ?>
                                        <?php foreach ($bike_list as $xe): ?>
                                            <div class="col-6 col-md-4 col-lg-3 mb-3 text-center">
                                                <a href="/QuanLyBaoDuongXe/User/bike_update.php?MaXe=<?php echo $xe['MaXe']; ?>" class="text-decoration-none text-dark">
                                                    <img src="<?php
                                                        $img = $xe['HinhAnhMatTruocXe'];
                                                        if (!empty($img) && file_exists($img)) {
                                                            echo $img;
                                                        } else {
                                                            echo 'images/no-image.png';
                                                        }
                                                    ?>"
                                                    alt="<?php echo htmlspecialchars($xe['TenXe']); ?>"
                                                    width="120" height="90" class="mb-2" style="object-fit:cover;">
                                                    <div class="fw-bold small"><?php echo htmlspecialchars($xe['TenXe']); ?></div>
                                                    <div class="small text-muted">Biển số: <?php echo htmlspecialchars($xe['BienSoXe']); ?></div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12 text-center mt-2">
                                            <span class="text-muted">
                                                Bạn chưa có thông tin xe trong danh sách,
                                                <a href="/QuanLyBaoDuongXe/User/bikeprofile.php" class="text-primary text-decoration-underline">
                                                    nhấn vào đây
                                                </a>
                                                để thêm thông tin.
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <!-- Mega menu Phụ tùng nổi bật -->
                <li class="nav-item dropdown position-static mega-hover">
                    <a class="nav-link dropdown-toggle" id="phutungMegaMenu" href="/QuanLyBaoDuongXe/User/hienthi_phutung.php">Phụ tùng</a>
                    <div class="dropdown-menu w-100 mt-0 border-0 shadow mega-menu" id="megaMenuPhutung">
                        <div class="container py-4">
                            <a href="/QuanLyBaoDuongXe/User/hienthi_phutung.php" class="h6 text-uppercase mb-3 d-block text-decoration-none text-dark">Phụ tùng nổi bật</a>
                            <div class="row">
                                <?php foreach ($phutung_list as $sp): ?>
                                    <div class="col-6 col-md-4 col-lg-3 mb-3 text-center">
                                        <a href="/QuanLyBaoDuongXe/User/chitiet_phutung.php?id=<?php echo $sp['MaSP']; ?>" class="text-decoration-none text-dark">
                                            <img src="<?php
                                                $img = $sp['HinhAnh'];
                                                if (!empty($img) && file_exists($img)) {
                                                    echo $img;
                                                } else {
                                                    echo 'images/no-image.png';
                                                }
                                            ?>"
                                            alt="<?php echo htmlspecialchars($sp['TenSP']); ?>"
                                            width="90" height="70" class="mb-2" style="object-fit:cover;">
                                            <div class="fw-bold small"><?php echo htmlspecialchars($sp['TenSP']); ?></div>
                                            <div class="text-danger small">
                                                <?php echo number_format($sp['DonGia'], 0, ',', '.'); ?> VNĐ
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (empty($phutung_list)): ?>
                                    <div class="col-12 text-center text-muted">Chưa có phụ tùng nào!</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#section_6">Liên hệ</a>
                </li>
            </ul>
            <!-- Nút bên phải -->
            <div class="d-none d-lg-flex align-items-center ms-lg-3">
                <?php if (isset($_SESSION['TenKH'])): ?>
                    <div class="dropdown me-2">
                        <button class="btn custom-btn custom-border-btn dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown">
                            <?php echo htmlspecialchars($_SESSION['TenKH']); ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="profile.php">Cập nhật tài khoản</a></li>
                            <li><a class="dropdown-item" href="baohanh.php">Đặt lịch bảo hành</a></li>
                            <li>
                                <span class="dropdown-header">Thông tin xe máy</span>
                            </li>
                            <li>
                                <a class="dropdown-item ps-4" href="bikeprofile.php">Thêm thông tin xe máy</a>
                            </li>
                            <li>
                                <a class="dropdown-item ps-4" href="bike_list.php">Xem danh sách xe</a>
                            </li>
                            <li><a class="dropdown-item" href="lichhen_cuatoi.php">Danh sách lịch hẹn</a></li>
                            <li><a class="dropdown-item" href="listbaohanh.php">Danh sách lịch bảo hành</a></li>
                            <li><a class="dropdown-item" href="listphutungdamua.php">Danh sách phụ tùng đã đặt</a></li>
                            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                        </ul>
                    </div>
                    <a class="btn custom-btn custom-border-btn me-2" href="datlich.php">Đặt lịch hẹn</a>
                    <!-- Giỏ hàng icon -->
                    <a class="btn custom-btn custom-border-btn position-relative" href="cart.php" title="Giỏ hàng">
                        <i class="bi bi-cart3" style="font-size: 1.3rem;"></i>
                        <?php
                        if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            $cartCount = 0;
                            foreach ($_SESSION['cart'] as $item) {
                                $cartCount += (int)($item['qty'] ?? 1);
                            }
                            if ($cartCount > 0) {
                                echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.8rem;">' . $cartCount . '</span>';
                            }
                        }
                        ?>
                    </a>
                <?php else: ?>
                    <a class="btn custom-btn custom-border-btn" href="login.php">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>