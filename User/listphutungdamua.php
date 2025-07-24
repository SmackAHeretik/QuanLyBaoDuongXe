<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once './utils/ConnectDb.php';

// Lấy danh sách phụ tùng đã mua từ bảng hoadon (chỉ trạng thái đã thanh toán hoặc chờ thanh toán)
$db = new ConnectDb();
$pdo = $db->connect();

if (isset($_SESSION['MaKH'])) {
    // Nếu là khách hàng, chỉ lấy hoá đơn của mình thông qua mã xe của họ
    $maKH = $_SESSION['MaKH'];
    $sql = "SELECT h.MaHD, h.Ngay, h.TongTien, h.TrangThai, h.xemay_MaXE, h.phutungxemay_MaSP, 
                   xe.TenXe, xe.BienSoXe, pt.TenSP, pt.DonGia
            FROM hoadon h
            LEFT JOIN xemay xe ON h.xemay_MaXE = xe.MaXE
            LEFT JOIN phutungxemay pt ON h.phutungxemay_MaSP = pt.MaSP
            WHERE xe.khachhang_MaKH = ?
            ORDER BY h.Ngay DESC, h.MaHD DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$maKH]);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Nếu là admin, lấy tất cả
    $sql = "SELECT h.MaHD, h.Ngay, h.TongTien, h.TrangThai, h.xemay_MaXE, h.phutungxemay_MaSP, 
                   xe.TenXe, xe.BienSoXe, pt.TenSP, pt.DonGia
            FROM hoadon h
            LEFT JOIN xemay xe ON h.xemay_MaXE = xe.MaXE
            LEFT JOIN phutungxemay pt ON h.phutungxemay_MaSP = pt.MaSP
            ORDER BY h.Ngay DESC, h.MaHD DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm chuyển trạng thái thành chữ
function tenTrangThaiHD($tt) {
    switch ($tt) {
        case 'cho_thanh_toan': return 'Chờ thanh toán';
        case 'da_thanh_toan': return 'Đã thanh toán';
        case 'huy': return 'Đã huỷ';
        default: return 'Không rõ';
    }
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
</head>
<body>
<main>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>   
    <section class="section-padding">
        <div class="container">
            <h2 class="mb-4">Danh Sách Phụ Tùng Đã Mua</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Ngày mua</th>
                            <th>Tên phụ tùng</th>
                            <th>Đơn giá</th>
                            <th>Xe</th>
                            <th>Biển số xe</th>
                            <th>Trạng thái đơn</th>
                            <th></th><!-- Thêm cột nút chi tiết -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list)): ?>
                            <?php foreach ($list as $i => $item): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($item['Ngay']) ?></td>
                                    <td><?= htmlspecialchars($item['TenSP'] ?? '---') ?></td>
                                    <td><?= number_format($item['DonGia'] ?? $item['TongTien'], 0, ',', '.') ?> VNĐ</td>
                                    <td><?= htmlspecialchars($item['TenXe'] ?? '---') ?></td>
                                    <td><?= htmlspecialchars($item['BienSoXe'] ?? '---') ?></td>
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
                                        <!-- Modal chi tiết đơn hàng -->
                                        <div class="modal fade" id="orderDetailModal<?= $item['MaHD'] ?>" tabindex="-1" aria-labelledby="orderDetailLabel<?= $item['MaHD'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderDetailLabel<?= $item['MaHD'] ?>">Chi tiết đơn hàng #<?= $item['MaHD'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><b>Ngày mua:</b> <?= htmlspecialchars($item['Ngay']) ?></p>
                                                        <p><b>Trạng thái:</b> <?= tenTrangThaiHD($item['TrangThai']) ?></p>
                                                        <hr>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tên phụ tùng</th>
                                                                    <th>Đơn giá</th>
                                                                    <th>Xe</th>
                                                                    <th>Biển số xe</th>
                                                                    <th>Thành tiền</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= htmlspecialchars($item['TenSP'] ?? '---') ?></td>
                                                                    <td><?= number_format($item['DonGia'] ?? $item['TongTien'], 0, ',', '.') ?> VNĐ</td>
                                                                    <td><?= htmlspecialchars($item['TenXe'] ?? '---') ?></td>
                                                                    <td><?= htmlspecialchars($item['BienSoXe'] ?? '---') ?></td>
                                                                    <td><?= number_format($item['DonGia'] ?? $item['TongTien'], 0, ',', '.') ?> VNĐ</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <p class="text-end"><b>Tổng tiền: <?= number_format($item['TongTien'], 0, ',', '.') ?> VNĐ</b></p>
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
                                <td colspan="8" class="text-center">Không có phụ tùng nào đã mua.</td>
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
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $MaSP => $qty) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['MaSP'] == $MaSP) {
                $item['qty'] = max(1, intval($qty));
            }
        }
    }
    // Đảm bảo reference giữ lại
    unset($item);
}

exit;
?>

<?php
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['DonGia'] * $item['qty'];
}

$_SESSION['order'] = [
    'cart' => $_SESSION['cart'],
    'fullname' => $_POST['fullname'],
    'phone' => $_POST['phone'],
    'note' => $_POST['note'],
    'total' => $total,
    'date' => date('Y-m-d H:i:s'),
];
?>