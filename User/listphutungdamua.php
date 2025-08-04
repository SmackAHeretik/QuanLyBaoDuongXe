<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once './utils/ConnectDb.php';

// Kết nối DB
$db = new ConnectDb();
$pdo = $db->connect();

function tenTrangThaiHD($tt) {
    switch ($tt) {
        case 'cho_thanh_toan': return 'Chờ thanh toán';
        case 'da_thanh_toan': return 'Đã thanh toán';
        case 'huy': return 'Đã huỷ';
        default: return 'Không rõ';
    }
}

// Lấy danh sách hóa đơn của user (hoặc tất cả nếu là admin)
if (isset($_SESSION['MaKH'])) {
    $maKH = $_SESSION['MaKH'];
    $sql = "SELECT h.MaHD, h.Ngay, h.TongTien, h.TrangThai, h.xemay_MaXE, xe.TenXe, xe.BienSoXe
            FROM hoadon h
            LEFT JOIN xemay xe ON h.xemay_MaXE = xe.MaXE
            WHERE xe.khachhang_MaKH = ?
            ORDER BY h.Ngay DESC, h.MaHD DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$maKH]);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT h.MaHD, h.Ngay, h.TongTien, h.TrangThai, h.xemay_MaXE, xe.TenXe, xe.BienSoXe
            FROM hoadon h
            LEFT JOIN xemay xe ON h.xemay_MaXE = xe.MaXE
            ORDER BY h.Ngay DESC, h.MaHD DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy chi tiết hóa đơn theo MaHD
function getChiTietHoaDon($pdo, $maHD) {
    $sql = "SELECT cthd.*, pt.TenSP, dv.TenDV
            FROM chitiethoadon cthd
            LEFT JOIN phutungxemay pt ON cthd.phutungxemay_MaSP = pt.MaSP
            LEFT JOIN dichvu dv ON cthd.dichvu_MaDV = dv.MaDV
            WHERE cthd.hoadon_MaHD = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$maHD]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>67 Performance - Phụ tùng đã mua</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .modal-xl { max-width: 90vw; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
<main>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>   
    <section class="section-padding">
        <div class="container">
            <h2 class="mb-4">Danh Sách Hóa Đơn Đã Mua</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Ngày mua</th>
                            <th>Xe</th>
                            <th>Biển số xe</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th></th><!-- Nút chi tiết -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $i => $item): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($item['Ngay']) ?></td>
                                    <td><?= htmlspecialchars($item['TenXe'] ?? '---') ?></td>
                                    <td><?= htmlspecialchars($item['BienSoXe'] ?? '---') ?></td>
                                    <td><?= number_format($item['TongTien'], 0, ',', '.') ?> VNĐ</td>
                                    <td>
                                        <?php
                                        $tt = $item['TrangThai'];
                                        $badge = 'secondary';
                                        if ($tt == 'cho_thanh_toan') $badge = 'warning';
                                        elseif ($tt == 'da_thanh_toan') $badge = 'success';
                                        elseif ($tt == 'huy') $badge = 'danger';
                                        ?>
                                        <span class="badge bg-<?= $badge ?>">
                                            <?= tenTrangThaiHD($tt) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Nút chi tiết đơn -->
                                        <button type="button" class="btn btn-link btn-sm p-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#orderDetailModal<?= $item['MaHD'] ?>">
                                            <i class="fa fa-info-circle"></i> Chi tiết
                                        </button>
                                        <!-- Modal chi tiết hóa đơn -->
                                        <div class="modal fade" id="orderDetailModal<?= $item['MaHD'] ?>" tabindex="-1" aria-labelledby="orderDetailLabel<?= $item['MaHD'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderDetailLabel<?= $item['MaHD'] ?>">Chi tiết hóa đơn #<?= $item['MaHD'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><b>Ngày mua:</b> <?= htmlspecialchars($item['Ngay']) ?></p>
                                                        <p><b>Tổng tiền:</b> <?= number_format($item['TongTien'], 0, ',', '.') ?> VNĐ</p>
                                                        <p><b>Trạng thái:</b> <?= tenTrangThaiHD($item['TrangThai']) ?></p>
                                                        <hr>
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>MaCTHD</th>
                                                                    <th>Mã SP</th>
                                                                    <th>Tên phụ tùng</th>
                                                                    <th>Giá tiền</th>
                                                                    <th>Số lượng</th>
                                                                    <th>Ngày BD bảo hành</th>
                                                                    <th>Ngày KT bảo hành</th>
                                                                    <th>Số lần còn bảo hành</th>
                                                                    <th>Mã DV</th>
                                                                    <th>Tên dịch vụ</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $ctList = getChiTietHoaDon($pdo, $item['MaHD']);
                                                                if (!empty($ctList)):
                                                                    foreach ($ctList as $ct): ?>
                                                                        <tr>
                                                                            <td><?= htmlspecialchars($ct['MaCTHD']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['MaSP'] ?? $ct['phutungxemay_MaSP']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['TenSP'] ?? '---') ?></td>
                                                                            <td><?= number_format($ct['GiaTien'], 0, ',', '.') ?></td>
                                                                            <td><?= htmlspecialchars($ct['SoLuong']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['NgayBDBH']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['NgayKTBH']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['SoLanDaBaoHanh']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['dichvu_MaDV']) ?></td>
                                                                            <td><?= htmlspecialchars($ct['TenDV'] ?? '---') ?></td>
                                                                        </tr>
                                                                    <?php endforeach;
                                                                else: ?>
                                                                    <tr>
                                                                        <td colspan="10" class="text-center">Không có chi tiết hóa đơn.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Không có hóa đơn nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="btn custom-btn custom-border-btn">Quay về trang chủ</a>
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