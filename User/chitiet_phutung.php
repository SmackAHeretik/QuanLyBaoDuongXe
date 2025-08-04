<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
$projectRoot = '/QuanLyBaoDuongXe';
require_once __DIR__ . '/utils/ConnectDb.php';
require_once __DIR__ . '/../Admin/models/phutungxemaymodel.php';

// Lấy danh sách xe của khách hàng nếu đã đăng nhập
$user_xemay = [];
$isLoggedIn = isset($_SESSION['MaKH']);
if ($isLoggedIn) {
    $db = new ConnectDb();
    $pdo = $db->connect();
    $makh = $_SESSION['MaKH'];
    $xeStmt = $pdo->prepare("SELECT MaXE, TenXe FROM xemay WHERE khachhang_MaKH = ?");
    $xeStmt->execute([$makh]);
    $user_xemay = $xeStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $db = new ConnectDb();
    $pdo = $db->connect();
}
require_once __DIR__ . '/../Admin/models/phutungxemaymodel.php';

if (!isset($_GET['id'])) {
    die("Thiếu mã sản phẩm.");
}
$maSP = intval($_GET['id']);

$model = new PhuTungXeMayModel($pdo);
$product = $model->getById($maSP);

// Sản phẩm liên quan - các phụ kiện khác (không cùng loại)
$related_others = [];
if ($product) {
    $relOtherStmt = $pdo->prepare("SELECT * FROM phutungxemay WHERE loaiphutung != ? AND MaSP != ? AND TrangThai = 1 ORDER BY RAND() LIMIT 4");
    $relOtherStmt->execute([$product['loaiphutung'], $maSP]);
    $related_others = $relOtherStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['TenSP'] ?? 'Chi tiết sản phẩm') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS FILES -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .main-section {
            background: #fff;
            padding: 70px 0 60px 0;
            min-height: 600px;
        }
        .product-detail-container {
            display: flex;
            align-items: center;
            gap: 64px;
            justify-content: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        .product-info {
            flex: 1.2;
            min-width: 340px;
            max-width: 600px;
            padding-right: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }
        .product-title {
            font-size: 2.4rem;
            font-weight: bold;
            color: #222;
            margin-bottom: 16px;
            margin-top: 0;
        }
        .product-price {
            color: #d40000;
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 18px;
        }
        .product-description {
            font-size: 1.13rem;
            margin: 20px 0 32px 0;
            color: #444;
            line-height: 1.6;
        }
        .buy-btn {
            margin-top: 8px;
            font-size: 1.09rem;
            width: 80px;
        }
        .product-image {
            flex: 1;
            min-width: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image img {
            width: 500px;
            height: 500px;
            max-width: 90vw;
            max-height: 90vw;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            margin: 0 auto;
            display: block;
        }
        .related-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin: 40px 0 16px 0;
            color: #444;
        }
        .related-products {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            justify-content: stretch;
            align-items: stretch;
            width: 100%;
        }
        .related-product {
            background: #fafbfc;
            border-radius: 12px;
            padding: 18px 8px 18px 8px;
            border: 1px solid #eee;
            transition: box-shadow 0.2s, transform 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1 1 0;
            min-width: 200px;
            max-width: 260px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        .related-product:hover {
            box-shadow: 0 8px 32px #ddd;
            transform: translateY(-2px) scale(1.03);
        }
        .related-product img {
            width: 110px;
            height: 110px;
            object-fit: contain;
            margin-bottom: 14px;
            background: #fff;
            border-radius: 8px;
        }
        .related-product .rel-name {
            font-size: 1.05rem;
            color: #222;
            margin-bottom: 6px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
        }
        .related-product .rel-price {
            color: #d40000;
            font-size: 1.07rem;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .related-product .color-dots {
            margin: 0 auto;
            display: flex;
            justify-content: center;
            gap: 7px;
        }
        .related-product .color-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1.5px solid #dedede;
            display: inline-block;
        }
        .dot-gray { background: #bbb; }
        /* MODAL */
        .modal-custom {
            z-index: 99999;
        }
        .modal-content-custom {
            border-radius: 12px;
        }
        @media (max-width: 991.98px) {
            .main-section { padding: 35px 0 40px 0; }
            .product-detail-container { flex-direction: column; align-items: stretch; }
            .product-image { text-align: center; }
            .product-info { padding-right: 0; }
            .product-image img { width: 350px; height: 350px; }
            .related-product { min-width: 140px; max-width: 48vw; padding: 12px 4px 12px 4px; }
        }
        @media (max-width: 575.98px) {
            .product-image img { width: 90vw; height: 90vw; max-width: 500px; max-height: 500px; }
            .related-products { flex-direction: column; gap: 12px; }
            .related-product { min-width: 0; max-width: 100%; width: 100%; }
        }
    </style>
</head>
<body>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>

    <main>
        <section class="main-section">
            <div class="container">
                <?php if ($product): ?>
                    <div class="product-detail-container">
                        <div class="product-info">
                            <div class="product-title"><?= htmlspecialchars($product['TenSP']) ?></div>
                            <div class="product-price">Giá từ: <?= number_format($product['DonGia'], 0, ',', '.') ?> VNĐ</div>
                            <div class="product-description">
                                <?= nl2br(htmlspecialchars($product['MieuTaSP'])) ?>
                            </div>
                            <!-- NÚT MUA: GỬI ĐỦ THÔNG TIN SANG controller/add_to_cart.php -->
                            <form method="get" action="controller/add_to_cart.php" style="display:inline;" id="buyForm">
                                <input type="hidden" name="MaSP" value="<?= $product['MaSP'] ?>">
                                <input type="hidden" name="TenSP" value="<?= htmlspecialchars($product['TenSP']) ?>">
                                <input type="hidden" name="DonGia" value="<?= $product['DonGia'] ?>">
                                <input type="hidden" name="HinhAnh" value="<?= htmlspecialchars($product['HinhAnh']) ?>">
                                <?php if ($isLoggedIn): ?>
                                    <div class="mb-3 mt-2">
                                        <label for="xemay_chon" class="form-label">Chọn xe cần phụ tùng:</label>
                                        <select id="xemay_chon" name="MaXE" class="form-select" required onchange="updateTenXe()">
                                            <option value="" disabled selected>-- Chọn xe của bạn --</option>
                                            <?php foreach ($user_xemay as $xe): ?>
                                                <option value="<?= htmlspecialchars($xe['MaXE']) ?>">
                                                    <?= htmlspecialchars($xe['TenXe']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="TenXE" id="TenXE_hidden" value="">
                                    </div>
                                    <script>
                                        function updateTenXe() {
                                            var select = document.getElementById('xemay_chon');
                                            var tenXe = select.options[select.selectedIndex] ? select.options[select.selectedIndex].text : '';
                                            document.getElementById('TenXE_hidden').value = tenXe;
                                        }
                                        document.addEventListener('DOMContentLoaded', function() {
                                            updateTenXe();
                                        });
                                    </script>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-danger buy-btn" id="buyBtn">Mua</button>
                            </form>
                        </div>
                        <div class="product-image">
                            <?php
                            // Đường dẫn hình ảnh
                            $src = '';
                            if (isset($product['HinhAnh'])) {
                                if (strpos($product['HinhAnh'], '/') === 0) {
                                    $src = $product['HinhAnh'];
                                } elseif (strpos($product['HinhAnh'], 'uploads/') === 0) {
                                    $src = $projectRoot . '/Admin/' . $product['HinhAnh'];
                                } else {
                                    $src = $projectRoot . '/Admin/uploads/' . $product['HinhAnh'];
                                }
                            }
                            ?>
                            <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>">
                        </div>
                    </div>
                    
                    <div class="related-title">Sản phẩm liên quan</div>
                    <div class="related-products">
                        <?php foreach ($related_others as $rel):
                            if (strpos($rel['HinhAnh'], '/') === 0) {
                                $rel_src = $rel['HinhAnh'];
                            } elseif (strpos($rel['HinhAnh'], 'uploads/') === 0) {
                                $rel_src = $projectRoot . '/Admin/' . $rel['HinhAnh'];
                            } else {
                                $rel_src = $projectRoot . '/Admin/uploads/' . $rel['HinhAnh'];
                            }
                        ?>
                        <div class="related-product">
                            <a href="chitiet_phutung.php?id=<?= $rel['MaSP'] ?>" style="text-decoration:none;">
                                <img src="<?= htmlspecialchars($rel_src) ?>" alt="<?= htmlspecialchars($rel['TenSP']) ?>">
                                <div class="rel-name"><?= htmlspecialchars($rel['TenSP']) ?></div>
                                <div class="rel-price"><?= number_format($rel['DonGia'], 0, ',', '.') ?> VNĐ</div>
                                <div class="color-dots">
                                    <span class='color-dot dot-gray'></span>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger mt-5">Không tìm thấy sản phẩm.</div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- MODAL: Thông báo phải thêm thông tin xe -->
    <div class="modal fade modal-custom" id="requireBikeModal" tabindex="-1" aria-labelledby="requireBikeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
          <div class="modal-header">
            <h5 class="modal-title" id="requireBikeModalLabel">Thông báo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
          <div class="modal-body">
            Bạn hãy thêm thông tin xe trước khi đặt hàng!
          </div>
          <div class="modal-footer">
            <a href="/QuanLyBaoDuongXe/User/bikeprofile.php" class="btn btn-primary">Thêm xe ngay</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL: Thông báo phải đăng nhập -->
    <div class="modal fade modal-custom" id="requireLoginModal" tabindex="-1" aria-labelledby="requireLoginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
          <div class="modal-header">
            <h5 class="modal-title" id="requireLoginModalLabel">Thông báo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
          <div class="modal-body">
            Bạn cần đăng nhập trước khi đặt hàng!
          </div>
          <div class="modal-footer">
            <a href="/QuanLyBaoDuongXe/User/login.php" class="btn btn-primary">Đăng nhập ngay</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>

    <?php include('./layouts/footer/footer.php') ?>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/animated-headline.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/mega-menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var buyBtn = document.getElementById('buyBtn');
        var buyForm = document.getElementById('buyForm');
        <?php if (!$isLoggedIn): ?>
            // Chưa đăng nhập, chặn submit và hiện modal đăng nhập
            buyBtn.onclick = function(e) {
                e.preventDefault();
                var modal = new bootstrap.Modal(document.getElementById('requireLoginModal'));
                modal.show();
                return false;
            };
            buyForm.onsubmit = function(e) {
                e.preventDefault();
                var modal = new bootstrap.Modal(document.getElementById('requireLoginModal'));
                modal.show();
                return false;
            };
        <?php elseif (count($user_xemay) == 0): ?>
            // Đã đăng nhập nhưng chưa có xe, chặn submit và hiện modal thêm xe
            buyBtn.onclick = function(e) {
                e.preventDefault();
                var modal = new bootstrap.Modal(document.getElementById('requireBikeModal'));
                modal.show();
                return false;
            };
            buyForm.onsubmit = function(e) {
                e.preventDefault();
                var modal = new bootstrap.Modal(document.getElementById('requireBikeModal'));
                modal.show();
                return false;
            };
        <?php endif; ?>
    });
    </script>
</body>
</html>