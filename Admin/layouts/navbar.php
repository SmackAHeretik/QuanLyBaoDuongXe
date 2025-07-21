<?php
            // Bắt đầu session nếu chưa có (đề phòng trường hợp auth_check không start)
            if (session_status() === PHP_SESSION_NONE) 
            session_start();
            $user = $_SESSION['user'] ?? null;
            $displayName = '';
            $roleLabel = '';
            if ($user) {
                if ($user['role'] === 'admin') {
                    $displayName = $user['data']['username'] ?? $user['data']['name'] ?? 'Admin';
                    $roleLabel = '<span class="badge bg-primary ms-2">ADMIN</span>';
                } elseif ($user['role'] === 'staff') {
                    $displayName = $user['data']['TenNV'] ?? 'Staff';
                    $roleLabel = '<span class="badge bg-success ms-2">STAFF</span>';
                }
            } else {
                $displayName = 'User';
            }
            ?>
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt=""
                                style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">
                                <?php echo htmlspecialchars($displayName); ?><?php echo $roleLabel; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="editprofile.php" class="dropdown-item">Cập Nhật Thông Tin</a>
                            <a href="logout.php" class="dropdown-item">Đăng Xuất</a>
                        </div>
                    </div>
                </div>
            </nav>