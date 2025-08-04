<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
include './utils/ConnectDb.php';
include './model/BikeProfileModel.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaKH'])) {
    header("Location: login.php");
    exit();
}

$db = (new ConnectDb())->connect();
$bikeModel = new BikeProfileModel($db);

// Lấy thông tin xe để hiển thị form
if (!isset($_GET['MaXe'])) {
    header("Location: bike_list.php");
    exit();
}
$MaXe = $_GET['MaXe'];
$bikes = $bikeModel->getBikesByCustomerId($_SESSION['MaKH']);
$bike = null;
foreach ($bikes as $b) {
    if ($b['MaXE'] == $MaXe) {
        $bike = $b;
        break;
    }
}
if (!$bike) {
    header("Location: bike_list.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Quản Lý Bảo Dưỡng Xe</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
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
                    <div class="col-lg-8 col-12 mx-auto">
                        <h2 class="mb-4 text-center">Sửa thông tin xe</h2>
                        <form action="controller/bike_update.php" method="POST" enctype="multipart/form-data" class="shadow-lg p-4 rounded bg-light">
                            <input type="hidden" name="MaXe" value="<?php echo htmlspecialchars($bike['MaXE']); ?>">
                            <input type="hidden" name="old_HinhAnhMatTruocXe" value="<?php echo htmlspecialchars($bike['HinhAnhMatTruocXe']); ?>">
                            <input type="hidden" name="old_HinhAnhMatSauXe" value="<?php echo htmlspecialchars($bike['HinhAnhMatSauXe']); ?>">

                            <div class="form-floating mb-3">
                                <input type="text" name="TenXe" id="TenXe" class="form-control" required value="<?php echo htmlspecialchars($bike['TenXe']); ?>">
                                <label for="TenXe">Tên Xe</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="LoaiXe" id="LoaiXe" class="form-control" required>
                                    <option value="">Chọn loại xe</option>
                                    <option value="Xe tay ga" <?php if($bike['LoaiXe']=='Xe tay ga') echo 'selected'; ?>>Xe tay ga</option>
                                    <option value="Xe số" <?php if($bike['LoaiXe']=='Xe số') echo 'selected'; ?>>Xe số</option>
                                    <option value="Xe côn tay" <?php if($bike['LoaiXe']=='Xe côn tay') echo 'selected'; ?>>Xe côn tay</option>
                                </select>
                                <label for="LoaiXe">Loại Xe</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="PhanKhuc" id="PhanKhuc" class="form-control" required>
                                    <option value="">Chọn phân khúc</option>
                                    <option value="50cc" <?php if($bike['PhanKhuc']=='50cc') echo 'selected'; ?>>50cc</option>
                                    <option value="110cc" <?php if($bike['PhanKhuc']=='110cc') echo 'selected'; ?>>110cc</option>
                                    <option value="125cc" <?php if($bike['PhanKhuc']=='125cc') echo 'selected'; ?>>125cc</option>
                                    <option value="150cc" <?php if($bike['PhanKhuc']=='150cc') echo 'selected'; ?>>150cc</option>
                                    <option value="250cc" <?php if($bike['PhanKhuc']=='250cc') echo 'selected'; ?>>250cc</option>
                                    <option value="500cc" <?php if($bike['PhanKhuc']=='500cc') echo 'selected'; ?>>500cc</option>
                                    <option value="1000cc" <?php if($bike['PhanKhuc']=='1000cc') echo 'selected'; ?>>1000cc</option>
                                </select>
                                <label for="PhanKhuc">Phân khúc</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="BienSoXe" id="BienSoXe" class="form-control" required value="<?php echo htmlspecialchars($bike['BienSoXe']); ?>">
                                <label for="BienSoXe">Biển số xe</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white">Hình ảnh mặt trước xe hiện tại:</label><br>
                                <?php if (!empty($bike['HinhAnhMatTruocXe'])): ?>
                                    <img src="<?php echo htmlspecialchars($bike['HinhAnhMatTruocXe']); ?>" alt="Mặt trước" style="max-width:120px;max-height:90px;">
                                <?php endif; ?>
                                <input type="file" name="HinhAnhMatTruocXe" class="form-control mt-2" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white">Hình ảnh mặt sau xe hiện tại:</label><br>
                                <?php if (!empty($bike['HinhAnhMatSauXe'])): ?>
                                    <img src="<?php echo htmlspecialchars($bike['HinhAnhMatSauXe']); ?>" alt="Mặt sau" style="max-width:120px;max-height:90px;">
                                <?php endif; ?>
                                <input type="file" name="HinhAnhMatSauXe" class="form-control mt-2" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cập nhật xe</button>
                        </form>
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