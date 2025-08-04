<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
include './utils/ConnectDb.php';
include './model/BikeProfileModel.php';

if (!isset($_SESSION['MaKH'])) {
    header("Location: login.php");
    exit();
}

$customerId = $_SESSION['MaKH'];
$db = (new ConnectDb())->connect();
$bikeModel = new BikeProfileModel($db);
$bikes = $bikeModel->getBikesByCustomerId($customerId);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản Lý Bảo Dưỡng Xe</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
</head>
<body>
<main>
<?php include('./layouts/navbar/navbar.php') ?>
<?php include('./layouts/hero/hero.php') ?>   

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2>Danh sách xe máy của bạn</h2>
            </div>
            <div class="col-12">
                <?php if (empty($bikes)): ?>
                    <div class="alert alert-info text-center">Bạn chưa có xe nào.</div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Tên xe</th>
                                <th>Loại xe</th>
                                <th>Phân khúc</th>
                                <th>Biển số xe</th>
                                <th>Số khung</th>
                                <th>Số máy</th>
                                <th>Hình mặt trước</th>
                                <th>Hình mặt sau</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bikes as $index => $bike): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($bike['TenXe']); ?></td>
                                <td><?php echo htmlspecialchars($bike['LoaiXe']); ?></td>
                                <td><?php echo htmlspecialchars($bike['PhanKhuc']); ?></td>
                                <td><?php echo htmlspecialchars($bike['BienSoXe']); ?></td>
                                <td><?php echo htmlspecialchars($bike['SoKhung'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($bike['SoMay'] ?? ''); ?></td>
                                <td>
                                    <?php if (!empty($bike['HinhAnhMatTruocXe'])): ?>
                                        <img src="<?php echo htmlspecialchars($bike['HinhAnhMatTruocXe']); ?>" alt="Mặt trước" style="max-width:80px;max-height:60px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($bike['HinhAnhMatSauXe'])): ?>
                                        <img src="<?php echo htmlspecialchars($bike['HinhAnhMatSauXe']); ?>" alt="Mặt sau" style="max-width:80px;max-height:60px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="bike_update.php?MaXe=<?php echo $bike['MaXE']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                </td>
                                <td>
                                    <form action="controller/bike_delete.php" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa xe này?');" style="display:inline;">
                                        <input type="hidden" name="MaXe" value="<?php echo $bike['MaXE']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

</main>
<?php include('./layouts/footer/footer.php'); ?>  
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/click-scroll.js"></script>
<script src="js/animated-headline.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/custom.js"></script>
</body>
</html>