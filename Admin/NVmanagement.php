<?php
// ===============================
// PHÂN QUYỀN: CHỈ ADMIN MỚI ĐƯỢC TẠO TÀI KHOẢN NHÂN VIÊN/QUẢN LÝ
// ===============================
$requiredRole = 'admin';
include __DIR__ . '/auth_check.php';

$adminName = isset($_SESSION['admin']['username']) ? $_SESSION['admin']['username'] : 'Admin';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Quản lý Nhân viên</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        $type = $_GET['type'] ?? '';
        if ($type == 'manager') {
            $msg = "Tài khoản Quản lý đã tạo thành công!";
        } elseif ($type == 'staff') {
            $msg = "Tài khoản Nhân viên đã tạo thành công!";
        } else {
            $msg = "Tạo tài khoản thành công!";
        }
        echo "<script>alert('$msg');</script>";
    }
    ?>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        <?php include('./layouts/sidebar.php') ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include('./layouts/navbar.php') ?>
            <!-- Navbar End -->

            <!-- Nội dung: Form đăng ký nhân viên/manager -->
            <div class="container-fluid pt-4 px-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="bg-light rounded p-4">
                            <h4 class="mb-4 text-center">Đăng ký tài khoản nhân viên / quản lý</h4>
                            <form method="post" action="controllers/register_staff.php">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="adminID" class="form-label">Loại tài khoản</label>
                                    <select class="form-control" id="adminID" name="adminID" required>
                                        <option value="">-- Chọn loại tài khoản --</option>
                                        <option value="2">Quản lý</option>
                                        <option value="3">Nhân viên</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kết thúc nội dung -->
        </div>
        <!-- Content End -->
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var password = document.getElementById('password');
        var confirm = document.getElementById('confirm_password');
        var submitBtn = document.querySelector('button[type="submit"]');

        function checkPasswordMatch() {
            if (password.value !== confirm.value || !password.value || !confirm.value) {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        }

        password.addEventListener('input', checkPasswordMatch);
        confirm.addEventListener('input', checkPasswordMatch);

        // Khóa nút ngay từ đầu
        checkPasswordMatch();
    });
    </script>
</body>
</html>