<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Lấy danh sách xe của khách hàng
include_once './utils/ConnectDb.php';
include_once './model/BikeProfileModel.php';
$bikeList = [];
if (isset($_SESSION['MaKH'])) {
    $db = (new ConnectDb())->connect();
    $bikeModel = new BikeProfileModel($db);
    $bikeList = $bikeModel->getBikesByCustomerId($_SESSION['MaKH']);
}

// Xử lý submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once './model/LichSuBaoHanhModel.php';
    $TenBHDK = $_POST['TenBHDK'] ?? '';
    $Ngay = $_POST['Ngay'] ?? '';
    $LoaiBaoHanh = $_POST['LoaiBaoHanh'] ?? '';
    $xemay_MaXE = $_POST['xemay_MaXE'] ?? '';

    if (!$TenBHDK || !$Ngay || !$LoaiBaoHanh || !$xemay_MaXE) {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    } else {
        $model = new LichSuBaoHanhModel();
        $result = $model->insertBaoHanh($TenBHDK, $Ngay, $LoaiBaoHanh, $xemay_MaXE);
        if ($result) {
            echo "<script>alert('Đặt lịch bảo dưỡng/bảo hành thành công!'); window.location='baohanh.php';</script>";
            exit;
        } else {
            $error = 'Có lỗi khi lưu dữ liệu!';
        }
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
    <title>Đặt Lịch Bảo Dưỡng/Bảo Hành</title>
    <!-- CSS FILES -->                
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>
<body>
<main>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>
    <section class="contact-section section-padding" id="section_5">
        <div class="container">
            <div class="row">
                <form action="baohanh.php" method="post" class="custom-form contact-form" role="form">
                    <h2 class="mb-4 pb-2">Đặt Lịch Bảo Dưỡng/Bảo Hành</h2>
                    <div class="row">
                        <!-- Lựa chọn tên xe -->
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select" name="xemay_MaXE" id="xemay_MaXE" required>
                                    <option value="" selected disabled>Chọn xe của bạn</option>
                                    <?php if (!empty($bikeList)): ?>
                                        <?php foreach ($bikeList as $bike): ?>
                                            <option 
                                                value="<?php echo htmlspecialchars($bike['MaXE']); ?>"
                                                data-loaixe="<?php echo htmlspecialchars($bike['LoaiXe']); ?>"
                                                data-phankhuc="<?php echo htmlspecialchars($bike['PhanKhuc']); ?>"
                                            >
                                                <?php echo htmlspecialchars($bike['TenXe'] . ' - ' . $bike['BienSoXe']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <label for="xemay_MaXE">Tên xe</label>
                            </div>
                        </div>
                        <!-- Loại xe (readonly) -->
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="loaixe" name="loaixe" readonly required placeholder="Loại xe">
                                <label for="loaixe">Loại xe</label>
                            </div>
                        </div>
                        <!-- Phân khúc (readonly) -->
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="phankhuc" name="phankhuc" readonly required placeholder="Phân khúc">
                                <label for="phankhuc">Phân khúc</label>
                            </div>
                        </div>
                        <!-- Ngày bảo dưỡng/bảo hành -->
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="Ngay" id="Ngay" required min="<?php echo date('Y-m-d'); ?>">
                                <label for="Ngay">Ngày bảo dưỡng/bảo hành</label>
                            </div>
                        </div>
                        <!-- Loại bảo hành -->
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-floating">
                                <select class="form-select" name="LoaiBaoHanh" id="LoaiBaoHanh" required>
                                    <option value="" selected disabled>Chọn loại bảo hành</option>
                                    <option value="bảo hành phụ tùng">Bảo hành phụ tùng</option>
                                    <option value="bảo dưỡng xe">Bảo dưỡng xe</option>
                                    <option value="bảo trì động cơ">Bảo trì động cơ</option>
                                </select>
                                <label for="LoaiBaoHanh">Loại bảo hành</label>
                            </div>
                        </div>
                        <!-- Tên bảo hành/đăng ký -->
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="TenBHDK" id="TenBHDK" required placeholder="Tên bảo hành/đăng ký">
                                <label for="TenBHDK">Tên bảo hành/đăng ký</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12">
                            <button type="submit" class="form-control">Đặt lịch bảo dưỡng</button>
                        </div>
                    </div>
                </form>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger mt-2"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <script>
            // Khi chọn xe, tự động fill loại xe và phân khúc
            document.getElementById('xemay_MaXE').addEventListener('change', function () {
                var selected = this.options[this.selectedIndex];
                document.getElementById('loaixe').value = selected.getAttribute('data-loaixe') || '';
                document.getElementById('phankhuc').value = selected.getAttribute('data-phankhuc') || '';
            });
        </script>
    </section>
</main>
<?php include('./layouts/footer/footer.php'); ?>
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