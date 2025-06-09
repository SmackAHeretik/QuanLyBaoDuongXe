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

        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">

    </head>
    
    <body>

        <main>
        <?php 
                include('./layouts/navbar/navbar.php')
        ?>
        <?php 
                include('./layouts/hero/hero.php')
        ?>
        <section class="membership-section section-padding" id="section_3">
                <div class="container">
                        <div class="row">
                                <div class="col-lg-12 col-12 text-center mx-auto mb-lg-5 mb-4">
                                        <h2><span>Membership</span> at Tiya</h2>
                                </div>

                                <!-- FORM ĐĂNG NHẬP -->
                                <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                                        <h4 class="mb-4 pb-lg-2">Membership Fees</h4>
                                        <div class="table-responsive">
                                        <form action="./controller/user_controller.php" method="POST" class="custom-form membership-form shadow-lg" role="form">
                                                <h4 class="text-white mb-4">Đăng Nhập</h4>

                                                <div class="form-floating">
                                                <input type="email" name="Email" id="Email" class="form-control" placeholder="Email" required>
                                                <label for="Email">Email</label>
                                                </div>

                                                <div class="form-floating">
                                                <input type="password" name="MatKhau" id="MatKhau" class="form-control" placeholder="Mật khẩu" required>
                                                <label for="MatKhau">Mật khẩu</label>
                                                </div>

                                                <button type="submit" name="login" class="form-control">Đăng nhập</button>
                                        </form>
                                        </div>
                                </div>

                                <!-- FORM ĐĂNG KÝ -->
                                <div class="col-lg-5 col-12 mx-auto">
                                        <h4 class="mb-4 pb-lg-2">Please join us!</h4>
                                        <form action="./controller/user_controller.php" method="POST" class="custom-form membership-form shadow-lg" role="form">
                                        <h4 class="text-white mb-4">Member Register</h4>

                                        <div class="form-floating">
                                                <input type="text" name="TenKH" id="TenKH" class="form-control" placeholder="Tên Khách Hàng" required>
                                                <label for="TenKH">Tên Khách Hàng</label>
                                        </div>

                                        <div class="form-floating">
                                                <input type="text" name="SDT" id="SDT" class="form-control" placeholder="Số điện thoại" required>
                                                <label for="SDT">Số điện thoại</label>
                                        </div>

                                        <div class="form-floating">
                                                <input type="email" name="Email" id="Email" class="form-control" placeholder="Email" required>
                                                <label for="Email">Email</label>
                                        </div>

                                        <div class="form-floating">
                                                <input type="password" name="MatKhau" id="MatKhau" class="form-control" placeholder="Mật khẩu" required>
                                                <label for="MatKhau">Mật khẩu</label>
                                        </div>

                                        <button type="submit" name="register" class="form-control">Đăng ký</button>
                                        </form>
                                </div>
                        </div>
                </div>
        </section>   
        </main>

        <?php 
                include('./layouts/footer/footer.php')
        ?>  


        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/animated-headline.js"></script>
        <script src="js/modernizr.js"></script>
        <script src="js/custom.js"></script>
        <script>
        document.querySelector('form[action="./controller/user_controller.php"][method="POST"]:nth-of-type(2)').addEventListener('submit', function(e) {
        const ten = document.getElementById('TenKH').value.trim();
        const email = document.getElementById('Email').value.trim();
        const sdt = document.getElementById('SDT').value.trim();
        const matkhau = document.getElementById('MatKhau').value;

        // Kiểm tra mật khẩu
        if (!/(?=.*[a-z])(?=.*[A-Z]).{8,}/.test(matkhau)) {
                alert('Mật khẩu phải có ít nhất 8 ký tự, 1 chữ hoa và 1 chữ thường!');
                e.preventDefault();
                return;
        }

        // Kiểm tra email
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Email không hợp lệ!');
                e.preventDefault();
                return;
        }

        // Kiểm tra số điện thoại
        if (!/^\d{10}$/.test(sdt)) {
                alert('Số điện thoại phải đúng 10 số!');
                e.preventDefault();
                return;
        }
        });
        </script>
    </body>
</html>