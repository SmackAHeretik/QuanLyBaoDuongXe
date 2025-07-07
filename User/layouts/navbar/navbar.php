<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy danh sách phụ tùng cho mega menu động
$phutung_list = [];
$conn = mysqli_connect('localhost', 'root', '', 'quanlybaoduongxe');
if ($conn) {
    mysqli_set_charset($conn, 'utf8mb4');
    $sql = "SELECT MaSP, TenSP, DonGia, HinhAnh FROM phutungxemay WHERE TrangThai=1 LIMIT 12";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $phutung_list[] = $row;
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
                    <a class="nav-link" href="hienthi_phutung.php">Phụ Tùng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Về chúng tôi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_3">Dịch vụ</a>
                </li>
                <!-- Mega menu Sản phẩm -->
                <li class="nav-item dropdown position-static" onmouseover="showMegaMenu()" onmouseleave="hideMegaMenu()">
                    <a class="nav-link dropdown-toggle" href="#" id="productMegaMenu">Sản phẩm</a>
                    <div class="dropdown-menu w-100 mt-0 border-0 shadow mega-menu" id="megaMenu" style="display: none;">
                        <div class="container py-4">
                            <div class="row">
                                <!-- Xe tay ga -->
                                <div class="col-lg-6">
                                    <h6 class="text-uppercase">Xe Tay Ga</h6>
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <img src="images/janus.png" width="100" height="70">
                                            <p class="mb-0 small">JANUS</p>
                                            <small>Giá từ 28.6tr</small>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="images/grande.png" width="100" height="70">
                                            <p class="mb-0 small">GRANDE</p>
                                            <small>Giá từ 46tr</small>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="images/freego.png" width="100" height="70">
                                            <p class="mb-0 small">FREEGO</p>
                                            <small>Giá từ 30.3tr</small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Xe số -->
                                <div class="col-lg-6">
                                    <h6 class="text-uppercase">Xe Số</h6>
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <img src="images/sirius.png" width="100" height="70">
                                            <p class="mb-0 small">SIRIUS</p>
                                            <small>Giá từ 18tr</small>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="images/jupiter.png" width="100" height="70">
                                            <p class="mb-0 small">JUPITER</p>
                                            <small>Giá từ 30tr</small>
                                        </div>
                                        <div class="col-4 text-center">
                                            <img src="images/exciter.png" width="100" height="70">
                                            <p class="mb-0 small">EXCITER</p>
                                            <small>Giá từ 47tr</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Mega menu Phụ tùng -->
                <li class="nav-item dropdown position-static" onmouseover="$('#megaMenuPhutung').show()" onmouseleave="$('#megaMenuPhutung').hide()">
                    <a class="nav-link dropdown-toggle" href="#" id="phutungMegaMenu">Phụ tùng</a>
                    <div class="dropdown-menu w-100 mt-0 border-0 shadow mega-menu" id="megaMenuPhutung" style="display: none; min-width: 700px;">
                        <div class="container py-4">
                            <h6 class="text-uppercase mb-3">Phụ tùng nổi bật</h6>
                            <div class="row">
                                <?php foreach ($phutung_list as $sp): ?>
                                    <div class="col-6 col-md-4 col-lg-3 mb-3 text-center">
                                        <a href="chitiet_phutung.php?MaSP=<?php echo $sp['MaSP']; ?>" class="text-decoration-none text-dark">
                                            <img src="<?php
                                                echo !empty($sp['HinhAnh'])
                                                    ? '../' . $sp['HinhAnh']
                                                    : 'images/no-image.png';
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
                    <a class="nav-link click-scroll" href="#section_5">Tin tức</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_6">Liên hệ</a>
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
<script>
// Mega menu sản phẩm (JS thuần)
function showMegaMenu() {
    document.getElementById('megaMenu').style.display = 'block';
}
function hideMegaMenu() {
    document.getElementById('megaMenu').style.display = 'none';
}
</script>