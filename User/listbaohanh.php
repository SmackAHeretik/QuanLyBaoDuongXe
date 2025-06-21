<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once './utils/ConnectDb.php';
include_once './model/DSLichBaoHanh.php';

$model = new DSLichBaoHanh();

// Nếu là khách hàng, chỉ hiện lịch của mình; nếu là admin, có thể lấy tất cả
if (isset($_SESSION['MaKH'])) {
    $maKH = $_SESSION['MaKH'];
    $baohanhList = $model->getBaoHanhByKhachHang($maKH);
} else {
    $baohanhList = $model->getAllBaoHanh();
}

// Hàm chuyển số phân loại thành tên (tuỳ ý, có thể bỏ nếu muốn hiển thị số)
function tenLoaiLichHen($phanLoai) {
    switch ($phanLoai) {
        case 1: return "Bảo hành";
        case 0: return "Bảo dưỡng";
        default: return "Khác";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>67 Performance</title>
    <!-- CSS FILES -->                
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>
<body>
    <main>
        <?php include('./layouts/navbar/navbar.php') ?>
        <?php include('./layouts/hero/hero.php') ?>   
        <section class="section-padding">
        <div class="container">
            <h2 class="mb-4">Danh Sách Bảo Dưỡng/Bảo Hành</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Ngày</th>
                            <th>Thời gian</th>
                            <th>Loại lịch hẹn</th>
                            <th>Tên nhân viên đặt</th>
                            <th>Tên xe</th>
                            <th>Biển số xe</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($baohanhList)): ?>
                            <?php foreach ($baohanhList as $i => $item): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($item['Ngay']); ?></td>
                                    <td><?php echo htmlspecialchars($item['ThoiGianCa'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars(tenLoaiLichHen($item['PhanLoai'])); ?></td>
                                    <td><?php echo htmlspecialchars($item['TenNhanVien'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($item['TenXe'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($item['BienSoXe'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($item['ThongTinTruocBaoHanh'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Không có lịch bảo hành nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center mt-4">
              <a href="index.php" class="btn custom-btn custom-border-btn">Quay về trang chủ</a>
        </div>
    </section>
        <?php include('./layouts/button/button.php') ?>
    </main>
    <?php include('./layouts/footer/footer.php') ?>  
    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/animated-headline.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/mega-menu.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const newsSwiper = new Swiper('.news-swiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                576: { slidesPerView: 1.5 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 }
            }
        });
    </script>
    <script src="js/custom.js"></script>
</body>
</html>