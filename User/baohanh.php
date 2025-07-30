<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once './utils/ConnectDb.php';
include_once './model/BikeProfileModel.php';
include_once './model/NhanVienModel.php';
include_once './model/LichHenModel.php';

$bikeList = [];
if (isset($_SESSION['MaKH'])) {
    $db = (new ConnectDb())->connect();
    $bikeModel = new BikeProfileModel($db);
    $bikeList = $bikeModel->getBikesByCustomerId($_SESSION['MaKH']);
}

$error = '';
$success = '';
$nhanvien_TenNV = '';

// Xử lý POST - Đặt lịch bảo hành và chuyển hướng PRG
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaXE = $_POST['xemay_MaXE'] ?? '';
    $NgayHen = $_POST['NgayHen'] ?? '';
    $ThoiGianCa = $_POST['ThoiGianCa'] ?? '';
    $MoTaLyDo = $_POST['MoTaLyDo'] ?? '';
    $PhanLoai = 1; // 1: đặt lịch bảo hành
    $TrangThai = 'cho duyet';
    $nhanvien_MaNV = $_POST['nhanvien_MaNV'] ?? '';

    if (!$MaXE || !$NgayHen || !$ThoiGianCa || !$MoTaLyDo || !$nhanvien_MaNV) {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
        header('Location: baohanh.php');
        exit;
    } else {
        $xeInfo = $bikeModel->getBikeById($MaXE);
        $nvModel = new NhanVienModel($db);
        $nvInfo = $nvModel->getNhanVienById($nhanvien_MaNV);
        $nhanvien_TenNV = $nvInfo['TenNV'];

        $data = [
            'TenXe' => $xeInfo['TenXe'] ?? '',
            'LoaiXe' => $xeInfo['LoaiXe'] ?? '',
            'PhanKhuc' => $xeInfo['PhanKhuc'] ?? '',
            'MoTaLyDo' => $MoTaLyDo,
            'nhanvien_MaNV' => $nhanvien_MaNV,
            'NgayHen' => $NgayHen,
            'ThoiGianCa' => $ThoiGianCa,
            'PhanLoai' => $PhanLoai, // 1: lịch bảo hành
            'TrangThai' => $TrangThai,
            'xemay_MaXE' => $MaXE,
            'khachhang_MaKH' => $_SESSION['MaKH'],
        ];
        $model = new LichHenModel($db);
        $ok = $model->insertLichHen($data);
        if ($ok) {
            $_SESSION['success'] = 'Đặt lịch bảo hành thành công!';
            $_SESSION['nhanvien_TenNV'] = $nhanvien_TenNV;
        } else {
            $_SESSION['error'] = 'Có lỗi khi lưu dữ liệu!';
        }
        header('Location: baohanh.php');
        exit;
    }
}

// Hiển thị thông báo từ session
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    $nhanvien_TenNV = $_SESSION['nhanvien_TenNV'] ?? '';
    unset($_SESSION['success'], $_SESSION['nhanvien_TenNV']);
}
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>67 Performance - Đặt Lịch Bảo Hành</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .block-ca {
            min-width: 100px;
            min-height: 50px;
            border-radius: 8px;
            font-size: 1.2rem;
            margin-bottom: 10px;
            margin-right: 10px;
            border: 2px solid #f4b860;
            background: #fff;
            transition: background 0.2s, color 0.2s;
        }

        .block-ca.active,
        .block-ca:focus {
            background-color: #f4b860 !important;
            color: #fff !important;
            border-color: #f4b860 !important;
        }
    </style>
</head>

<body>
    <main>
        <?php include('./layouts/navbar/navbar.php') ?>
        <?php include('./layouts/hero/hero.php') ?>
        <section class="contact-section section-padding" id="section_5">
            <div class="container">
                <div class="row">
                    <form action="" method="post" class="custom-form contact-form" role="form">
                        <h2 class="mb-4 pb-2">Đặt Lịch Bảo Hành</h2>
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
                                    <label for="NgayHen">Ngày bảo hành</label>
                                </div>
                            </div>
                            <!-- Ca làm việc dạng block -->
                            <div class="col-lg-12 col-12 mb-3">
                                <label class="form-label" for="ThoiGianCaBlocks">Ca làm việc</label>
                                <div id="ThoiGianCaBlocks" class="d-flex flex-wrap gap-2"></div>
                                <input type="hidden" name="ThoiGianCa" id="ThoiGianCa" required>
                            </div>
                            <!-- Nhân viên phục vụ (readonly + hidden id) -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nhanvienTen" name="nhanvienTen" readonly
                                        placeholder="Thợ sửa xe"
                                        value="<?= htmlspecialchars($nhanvien_TenNV) ?>">
                                    <label for="nhanvienTen">Thợ sửa xe</label>
                                    <input type="hidden" name="nhanvien_MaNV" id="nhanvien_MaNV">
                                </div>
                            </div>
                            <!-- Lý do bảo hành -->
                            <div class="col-lg-12 col-12 mb-3">
                                <div class="form-floating">
                                    <textarea name="MoTaLyDo" id="MoTaLyDo" class="form-control" style="height:100px"
                                        required placeholder="Nhập lý do bảo hành"></textarea>
                                    <label for="MoTaLyDo">Lý do bảo hành</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <button type="submit" class="form-control">Đặt lịch bảo hành</button>
                            </div>
                        </div>
                    </form>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger mt-2"><?= $error; ?></div>
                    <?php elseif (!empty($success)): ?>
                        <div class="alert alert-success mt-2">
                            <?= $success; ?>
                            <?php if (!empty($nhanvien_TenNV)): ?>
                                <br>Thợ sửa xe: <strong><?= htmlspecialchars($nhanvien_TenNV); ?></strong>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <script src="js/jquery.min.js"></script>
            <script>
                // Set loại xe & phân khúc khi chọn xe
                document.getElementById('xemay_MaXE').addEventListener('change', function () {
                    var selected = this.options[this.selectedIndex];
                    document.getElementById('loaixe').value = selected.getAttribute('data-loaixe') || '';
                    document.getElementById('phankhuc').value = selected.getAttribute('data-phankhuc') || '';
                });

                // Khi chọn ngày, load ca làm việc qua AJAX và hiển thị dạng block
                $('#NgayHen').on('change', function () {
                    var ngay = $(this).val();
                    $('#ThoiGianCaBlocks').html("Đang tải ca...");
                    $('#nhanvienTen').val(""); // reset nhân viên
                    $('#nhanvien_MaNV').val("");
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

                // Khi chọn ca, đổi màu, set value và random nhân viên phục vụ
                $(document).on('click', '.block-ca', function () {
                    if ($(this).prop('disabled')) return;
                    $('.block-ca').removeClass('active');
                    $(this).addClass('active');
                    $('#ThoiGianCa').val($(this).data('ca'));

                    // Random nhân viên phục vụ qua AJAX
                    var ngay = $('#NgayHen').val();
                    var ca = $(this).data('ca');
                    $.get('api/random_nhanvien.php', { ngay: ngay, ca: ca }, function (data) {
                        if (data && data.TenNV && data.MaNV) {
                            $('#nhanvienTen').val(data.TenNV);
                            $('#nhanvien_MaNV').val(data.MaNV); // gửi cả mã NV về server
                        } else {
                            $('#nhanvienTen').val("Không có nhân viên!");
                            $('#nhanvien_MaNV').val("");
                        }
                    }, 'json');
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