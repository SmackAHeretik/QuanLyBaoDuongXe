<?php
session_start();
require_once(__DIR__ . '/utils/ConnectDb.php');
require_once(__DIR__ . '/model/userModel.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaKH'])) {
    header("Location: login.php");
    exit();
}

$userModel = new UserModel();
$MaKH = $_SESSION['MaKH'];
$user = $userModel->findById($MaKH);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quản Lý Bảo Dưỡng Xe</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
</head>

<body>
    <main>
        <?php
        include('./layouts/navbar/navbar.php');
        ?>
        <section class="membership-section section-padding" id="section_profile">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12 text-center mx-auto mb-lg-5 mb-4">
                        <h2><span>Thông tin</span> tài khoản</h2>
                    </div>

                    <div class="col-lg-6 col-12 mx-auto">
                        <form action="./controller/user_controller.php" method="POST"
                            class="custom-form membership-form shadow-lg" role="form">
                            <input type="hidden" name="update" value="1">
                            <input type="hidden" name="MaKH" value="<?php echo htmlspecialchars($user['MaKH']); ?>">
                            <div class="form-floating mb-3">
                                <input type="text" name="TenKH" id="TenKH" class="form-control"
                                    placeholder="Tên Khách Hàng" required
                                    value="<?php echo htmlspecialchars($user['TenKH']); ?>">
                                <label for="TenKH">Tên Khách Hàng</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="SDT" id="SDT" class="form-control" placeholder="Số điện thoại"
                                    required value="<?php echo htmlspecialchars($user['SDT']); ?>">
                                <label for="SDT">Số điện thoại</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="Email" id="Email" class="form-control" placeholder="Email"
                                    required value="<?php echo htmlspecialchars($user['Email']); ?>">
                                <label for="Email">Email</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="DiaChi" id="DiaChi" class="form-control" placeholder="Địa chỉ"
                                    value="<?php echo htmlspecialchars($user['DiaChi']); ?>">
                                <label for="DiaChi">Địa chỉ</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="MatKhau" id="MatKhau" class="form-control"
                                    placeholder="Mật khẩu" value="">
                                <label for="MatKhau">Mật khẩu (để trống nếu không đổi)</label>
                            </div>

                            <button type="submit" name="update" class="form-control">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
    include('./layouts/footer/footer.php');
    ?>

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