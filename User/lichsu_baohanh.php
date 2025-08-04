<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once './utils/ConnectDb.php';
include_once './model/LichSuBaoHanhModel.php';

// Đồng bộ session lấy MaKH user
if (isset($_SESSION['user']) && isset($_SESSION['user']['MaKH'])) {
    $maKH = $_SESSION['user']['MaKH'];
} else if (isset($_SESSION['MaKH'])) {
    $maKH = $_SESSION['MaKH'];
} else {
    // Chưa đăng nhập thì chuyển về login
    header('Location: login.php');
    exit();
}

// Kết nối DB, lấy lịch sử bảo hành của user
$pdo = (new ConnectDb("localhost:3306", "root", "", "quanlybaoduongxe"))->connect();
$model = new LichSuBaoHanhModel($pdo);
$lichsuList = $model->getByUser($maKH);

function safe($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lịch Sử Bảo Hành Xe Của Bạn</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .section-padding { padding: 40px 0; }
        .table th, .table td { vertical-align: middle; }
        .custom-btn {
            background: #3b3663;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 10px 30px;
            transition: all 0.2s;
        }
        .custom-btn:hover { background: #5b52a3; color: #fff; }
        .custom-border-btn {
            border: 2px solid #3b3663;
            color: #3b3663;
            background: #fff;
        }
        .custom-border-btn:hover {
            background: #3b3663;
            color: #fff;
        }
    </style>
</head>
<body>
<main>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>   
    <section class="section-padding">
        <div class="container">
            <h2 class="mb-4 text-center">Lịch Sử Bảo Hành Xe Của Bạn</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Mã bảo hành</th>
                            <th>Tên bảo hành</th>
                            <th>Ngày</th>
                            <th>Loại</th>
                            <th>Mã Series SP</th>
                            <th>Trước bảo hành</th>
                            <th>Sau bảo hành</th>
                            <th>Tên xe</th>
                            <th>Biển số xe</th>
                            <!-- Nếu muốn có chi tiết modal thì mở cột này -->
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($lichsuList)): ?>
                        <?php foreach ($lichsuList as $i => $item): ?>
                            <tr>
                                <td class="text-center"><?= $i + 1 ?></td>
                                <td><?= safe($item['MaBHDK']) ?></td>
                                <td><?= safe($item['TenBHDK']) ?></td>
                                <td><?= safe($item['Ngay']) ?></td>
                                <td>
                                    <?php
                                        $loai = safe($item['LoaiBaoHanh']);
                                        $badge = 'secondary';
                                        if ($loai === 'Định kỳ') $badge = 'info';
                                        elseif ($loai === 'Sửa chữa') $badge = 'warning';
                                        elseif ($loai === 'Bảo hành') $badge = 'success';
                                        elseif ($loai === 'Kiểm tra') $badge = 'primary';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>">
                                        <?= $loai ?>
                                    </span>
                                </td>
                                <td><?= safe($item['MaSeriesSP']) ?></td>
                                <td><?= safe($item['ThongTinTruocBaoHanh']) ?></td>
                                <td><?= safe($item['ThongTinSauBaoHanh']) ?></td>
                                <td><?= safe($item['TenXe']) ?></td>
                                <td><?= safe($item['BienSoXe']) ?></td>
                                <!-- Nếu muốn có modal, thêm nút tại đây -->
                                <!--
                                <td>
                                    <button class="btn btn-link btn-sm p-0" data-bs-toggle="modal" data-bs-target="#modal<?= $item['MaBHDK'] ?>">
                                        <i class="fa fa-info-circle"></i> Chi tiết
                                    </button>
                                </td>
                                -->
                            </tr>
                            <!-- Modal chi tiết (nếu muốn, copy modal ở file phụ tùng đã mua) -->
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">Bạn chưa có lịch sử bảo hành nào.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="btn custom-btn custom-border-btn">
                    <i class="fa fa-arrow-left"></i> Quay về trang chủ
                </a>
            </div>
        </div>
    </section>
    <?php include('./layouts/button/button.php') ?>
</main>
<?php include('./layouts/footer/footer.php') ?>  
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/click-scroll.js"></script>
<script src="js/animated-headline.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/mega-menu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>