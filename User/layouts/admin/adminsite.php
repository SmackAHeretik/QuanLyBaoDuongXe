<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Quản Trị Hệ Thống - Quản Lý Bảo Dưỡng Xe</title>

        <!-- CSS FILES -->                
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    </head>
    
    <body>

        <main>
            <!-- Admin Navbar -->
            <nav class="navbar navbar-expand-lg">                
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center" href="adminsite.php">
                        <img src="images/logo.png" class="navbar-brand-image img-fluid" alt="Logo">
                        <span class="navbar-brand-text">
                            Quản Trị
                            <small>Hệ Thống</small>
                        </span>
                    </a>
                    <div class="d-lg-none ms-auto me-3">
                        <a class="btn custom-btn custom-border-btn" href="../index.php">Về trang người dùng</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminNav" aria-controls="navbarAdminNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarAdminNav">
                        <ul class="navbar-nav ms-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#admin_dashboard">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#admin_customers">Quản lý khách hàng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#admin_services">Quản lý dịch vụ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#admin_appointments">Quản lý lịch hẹn</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#admin_reports">Báo cáo</a>
                            </li>
                        </ul>
                        <div class="d-none d-lg-block ms-lg-3">
                            <a class="btn custom-btn custom-border-btn" href="../index.php">Về trang người dùng</a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Admin Dashboard Section -->
            <section id="admin_dashboard" class="section-padding">
                <div class="container">
                    <h2 class="mb-4">Bảng Điều Khiển</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-people-fill display-5"></i>
                                    <h5 class="card-title mt-2">Khách hàng</h5>
                                    <p class="card-text">100+</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-tools display-5"></i>
                                    <h5 class="card-title mt-2">Dịch vụ</h5>
                                    <p class="card-text">20+</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-calendar-check display-5"></i>
                                    <h5 class="card-title mt-2">Lịch hẹn</h5>
                                    <p class="card-text">30+</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-bar-chart-fill display-5"></i>
                                    <h5 class="card-title mt-2">Doanh thu</h5>
                                    <p class="card-text">50.000.000đ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Customers Management Section -->
            <section id="admin_customers" class="section-padding bg-light">
                <div class="container">
                    <h2 class="mb-4">Quản lý khách hàng</h2>
                    <!-- Table or content quản lý khách hàng tại đây -->
                    <div class="alert alert-info">Chức năng quản lý khách hàng (Thêm/Sửa/Xóa...)</div>
                </div>
            </section>

            <!-- Services Management Section -->
            <section id="admin_services" class="section-padding">
                <div class="container">
                    <h2 class="mb-4">Quản lý dịch vụ</h2>
                    <!-- Table or content quản lý dịch vụ tại đây -->
                    <div class="alert alert-info">Chức năng quản lý dịch vụ (Thêm/Sửa/Xóa...)</div>
                </div>
            </section>

            <!-- Appointments Management Section -->
            <section id="admin_appointments" class="section-padding bg-light">
                <div class="container">
                    <h2 class="mb-4">Quản lý lịch hẹn</h2>
                    <!-- Table or content quản lý lịch hẹn tại đây -->
                    <div class="alert alert-info">Chức năng quản lý lịch hẹn (Thêm/Sửa/Xóa...)</div>
                </div>
            </section>

            <!-- Reports Section -->
            <section id="admin_reports" class="section-padding">
                <div class="container">
                    <h2 class="mb-4">Báo cáo thống kê</h2>
                    <!-- Biểu đồ/ báo cáo doanh thu, khách hàng, dịch vụ... -->
                    <div class="alert alert-info">Chức năng xem báo cáo, thống kê...</div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="site-footer section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="mb-0">© 2025 Quản Trị Hệ Thống - Quản Lý Bảo Dưỡng Xe. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/animated-headline.js"></script>
        <script src="js/modernizr.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>