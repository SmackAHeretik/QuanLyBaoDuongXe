<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once './utils/ConnectDb.php';
include_once './model/BikeProfileModel.php';
include_once './model/NhanVienModel.php';
include_once './model/LichHenModel.php';

// Lấy danh sách xe của khách hàng
$bikeList = [];
if (isset($_SESSION['MaKH'])) {
    $db = (new ConnectDb())->connect();
    $bikeModel = new BikeProfileModel($db);
    $bikeList = $bikeModel->getBikesByCustomerId($_SESSION['MaKH']);
}

$error = '';
$success = '';
$tenNhanVien = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaXE = $_POST['xemay_MaXE'] ?? '';
    $NgayHen = $_POST['NgayHen'] ?? '';
    $ThoiGianCa = $_POST['ThoiGianCa'] ?? '';
    $MoTaLyDo = $_POST['MoTaLyDo'] ?? '';
    $PhanLoai = 0;
    $TrangThai = 'cho duyet';

    if (!$MaXE || !$NgayHen || !$ThoiGianCa || !$MoTaLyDo) {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    } else {
        $xeInfo = $bikeModel->getBikeById($MaXE);

        // Random nhân viên
        $nvModel = new NhanVienModel($db);
        $nhanviens = $nvModel->getAllNhanVien();
        $nhanvien_MaNV = null;
        $tenNhanVien = '';
        if ($nhanviens && count($nhanviens) > 0) {
            $randomIdx = array_rand($nhanviens);
            $nhanvien_MaNV = $nhanviens[$randomIdx]['MaNV'];
            $tenNhanVien = $nhanviens[$randomIdx]['TenNV'];
        }

        $data = [
            'TenXe' => $xeInfo['TenXe'] ?? '',
            'LoaiXe' => $xeInfo['LoaiXe'] ?? '',
            'PhanKhuc' => $xeInfo['PhanKhuc'] ?? '',
            'MoTaLyDo' => $MoTaLyDo,
            'nhanvien_MaNV' => $nhanvien_MaNV,
            'NgayHen' => $NgayHen,
            'ThoiGianCa' => $ThoiGianCa,
            'PhanLoai' => $PhanLoai,
            'TrangThai' => $TrangThai,
            'xemay_MaXE' => $MaXE,
            'khachhang_MaKH' => $_SESSION['MaKH'],
        ];
        $model = new LichHenModel($db);
        $ok = $model->insertLichHen($data);
        if ($ok) {
            $success = 'Đặt lịch hẹn thành công! Nhân viên phục vụ: ' . $tenNhanVien;
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
    <title>67 Performance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>

<body>
    <main>
        <?php include('./layouts/navbar/navbar.php') ?>
        <?php include('./layouts/hero/hero.php') ?>
        <section class="contact-section section-padding" id="section_5">
            <div class="container">
                <div class="row">
                    <form action="" method="post" class="custom-form contact-form" role="form">
                        <h2 class="mb-4 pb-2">Đặt Lịch Hẹn</h2>
                        <div class="row">
                            <!-- Chọn tên xe -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" name="xemay_MaXE" id="xemay_MaXE" required>
                                        <option value="" selected disabled>Chọn xe của bạn</option>
                                        <?php if (!empty($bikeList)): ?>
                                            <?php foreach ($bikeList as $bike): ?>
                                                <option value="<?= htmlspecialchars($bike['MaXE']) ?>"
                                                    data-loaixe="<?= htmlspecialchars($bike['LoaiXe']) ?>"
                                                    data-phankhuc="<?= htmlspecialchars($bike['PhanKhuc']) ?>">
                                                    <?= htmlspecialchars($bike['TenXe'] . ' - ' . $bike['BienSoXe']) ?>
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
                                    <input type="text" class="form-control" id="loaixe" name="loaixe" readonly required
                                        placeholder="Loại xe">
                                    <label for="loaixe">Loại xe</label>
                                </div>
                            </div>
                            <!-- Phân khúc (readonly) -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="phankhuc" name="phankhuc" readonly
                                        required placeholder="Phân khúc">
                                    <label for="phankhuc">Phân khúc</label>
                                </div>
                            </div>
                            <!-- Ngày hẹn -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="NgayHen" id="NgayHen" required
                                        min="<?= date('Y-m-d'); ?>">
                                    <label for="NgayHen">Ngày hẹn</label>
                                </div>
                            </div>
                            <!-- Ca làm việc -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" name="ThoiGianCa" id="ThoiGianCa" required>
                                        <option value="" selected disabled>Chọn ca làm việc</option>
                                    </select>
                                    <label for="ThoiGianCa">Ca làm việc</label>
                                </div>
                            </div>
                            <!-- Nhân viên phục vụ (readonly) -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="TenNhanVien" name="TenNhanVien" readonly
                                        placeholder="Nhân viên phục vụ">
                                    <label for="TenNhanVien">Nhân viên phục vụ</label>
                                </div>
                            </div>
                            <!-- Lý do hẹn -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <textarea name="MoTaLyDo" id="MoTaLyDo" class="form-control" style="height:100px"
                                        required placeholder="Nhập lý do hẹn"></textarea>
                                    <label for="MoTaLyDo">Lý do hẹn</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <button type="submit" class="form-control">Đặt lịch</button>
                            </div>
                        </div>
                    </form>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger mt-2"><?= $error; ?></div>
                    <?php elseif (!empty($success)): ?>
                        <div class="alert alert-success mt-2"><?= $success; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <script src="js/jquery.min.js"></script>
            <script>
                // Fill loại xe, phân khúc
                $('#xemay_MaXE').on('change', function () {
                    var selected = this.options[this.selectedIndex];
                    $('#loaixe').val(selected.getAttribute('data-loaixe') || '');
                    $('#phankhuc').val(selected.getAttribute('data-phankhuc') || '');
                });

                // Lấy ca làm việc khi chọn ngày
                $('#NgayHen').on('change', function () {
                    var ngay = $(this).val();
                    $('#ThoiGianCa').html('<option value="" selected disabled>Đang tải ca...</option>');
                    $('#TenNhanVien').val('');
                    $.get('api/get_ca.php', { ngay: ngay }, function (data) {
                        $('#ThoiGianCa').html(data);
                    });
                });

                // Random nhân viên khi chọn ca
                $('#ThoiGianCa').on('change', function () {
                    var ngay = $('#NgayHen').val();
                    var ca = $(this).val();
                    $.get('api/random_nhanvien.php', { ngay: ngay, ca: ca }, function (data) {
                        $('#TenNhanVien').val(data);
                    });
                });
            </script>
            <script>
                // Set loại xe & phân khúc khi chọn xe
                document.getElementById('xemay_MaXE').addEventListener('change', function () {
                    var selected = this.options[this.selectedIndex];
                    document.getElementById('loaixe').value = selected.getAttribute('data-loaixe') || '';
                    document.getElementById('phankhuc').value = selected.getAttribute('data-phankhuc') || '';
                });

                // Khi chọn ngày hẹn, load ca làm việc qua AJAX và hiển thị dạng block
                $('#NgayHen').on('change', function () {
                    var ngay = $(this).val();
                    $('#ThoiGianCaBlocks').html("Đang tải ca...");
                    $.get('api/get_ca.php', { ngay: ngay }, function (data) {
                        var cas = data;
                        if (typeof data === "string") cas = JSON.parse(data);
                        var html = '';
                        cas.forEach(function (ca) {
                            let disabled = ca.disabled ? 'disabled' : '';
                            html += `<button type="button" class="btn block-ca btn-outline-primary" data-ca="${ca.ThoiGianCa}" ${disabled}>
                            ${ca.ThoiGianCa}
                        </button>`;
                        });
                        $('#ThoiGianCaBlocks').html(html);
                        $('#ThoiGianCa').val(""); // reset chọn cũ
                    });
                });

                // Khi chọn ca, đổi màu và set value
                $(document).on('click', '.block-ca', function () {
                    if ($(this).prop('disabled')) return;
                    $('.block-ca').removeClass('active');
                    $(this).addClass('active');
                    $('#ThoiGianCa').val($(this).data('ca'));
                });
            </script>
        </section>
    </main>
    <?php include('./layouts/footer/footer.php') ?>
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