<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$projectRoot = '/QuanLyBaoDuongXe';
require_once __DIR__ . '/utils/ConnectDb.php';
require_once __DIR__ . '/../Admin/models/phutungxemaymodel.php';

$db = new ConnectDb();
$pdo = $db->connect();
$model = new PhuTungXeMayModel($pdo);
$products = $model->getAll();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$resultList = [];
if ($products && count($products) > 0) {
    foreach ($products as $item) {
        if ($item['TrangThai'] != 1)
            continue;
        if ($q !== '' && stripos($item['TenSP'], $q) === false)
            continue;
        $resultList[] = $item;
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>67 Performance - Phụ tùng xe máy</title>
    <!-- CSS FILES -->                
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        .section-fullwidth {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            background: #fff;
            padding: 0;
        }
        .card-list-section {
            padding: 40px 0 64px 0;
            background: #fff;
            min-height: 450px;
        }
        .card-list-title {
            text-align: center;
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 32px;
            letter-spacing: -1px;
        }
        .product-card-list {
            display: flex;
            gap: 32px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product-card {
            width: 260px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px #eee;
            text-align: center;
            padding: 28px 12px 22px 12px;
            transition: box-shadow 0.2s, transform 0.2s;
            cursor: pointer;
            margin-bottom: 0;
            position: relative;
            border: none;
            outline: none;
        }
        .product-card:hover, .product-card:focus {
            box-shadow: 0 8px 32px #ddd;
            transform: translateY(-4px) scale(1.03);
        }
        .product-card img {
            width: 200px !important;
            height: 200px !important;
            object-fit: contain;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 8px;
        }
        .product-card .product-title {
            font-size: 18px;
            font-weight: 600;
            color: #222;
            margin-bottom: 10px;
            min-height: 28px;
            line-height: 1.3;
        }
        .product-card .product-price {
            color: #d40000;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 0;
        }
        .product-card a {
            color: inherit;
            text-decoration: none;
            display: block;
            height: 100%;
            width: 100%;
        }
        .search-box-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 32px;
        }
        .custom-search-box {
            width: 350px;
            display: flex;
            align-items: center;
        }
        .custom-search-box input {
            border-radius: 6px 0 0 6px;
            border-right: none;
            height: 44px;
            font-size: 15px;
        }
        .custom-search-box button {
            border-radius: 0 6px 6px 0;
            border-left: none;
            height: 44px;
            background: #fff;
            border: 1px solid #ccc;
            border-left: none;
            color: #222;
            font-size: 19px;
            width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @media (max-width: 1199.98px) {
            .product-card { width: 22%; }
            .custom-search-box { width: 250px; }
        }
        @media (max-width: 991.98px) {
            .product-card-list { gap: 18px; }
            .product-card { width: 31%; }
            .custom-search-box { width: 100%; }
        }
        @media (max-width: 767.98px) {
            .product-card { width: 46%; }
            .custom-search-box { width: 100%; }
        }
        @media (max-width: 575.98px) {
            .product-card { width: 98%; min-width: 0; padding: 16px 4px 12px 4px;}
            .custom-search-box { width: 100%; }
        }
    </style>
</head>
<body>
    <?php include('./layouts/navbar/navbar.php') ?>
    <?php include('./layouts/hero/hero.php') ?>
    <main>
        <section class="section-fullwidth">
            <div class="container card-list-section">
                <div class="card-list-title">Phụ tùng xe máy</div>
                <div class="search-box-wrapper">
                    <form method="get" class="custom-search-box">
                        <input type="text" name="q" class="form-control" placeholder="Nhập tên sản phẩm"
                               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                        <button type="submit"><span class="bi bi-search"></span></button>
                    </form>
                </div>
                <div class="product-card-list">
                    <?php if (count($resultList) == 0): ?>
                        <div class="col-12 text-center text-muted mt-5">Không có sản phẩm nào phù hợp.</div>
                    <?php else: ?>
                        <?php foreach ($resultList as $item):
                            if (strpos($item['HinhAnh'], 'uploads/') === 0) {
                                $src = $projectRoot . '/Admin/' . $item['HinhAnh'];
                            } else {
                                $src = $projectRoot . '/Admin/uploads/' . $item['HinhAnh'];
                            }
                        ?>
                        <div class="product-card" tabindex="0" onclick="window.location.href='chitiet_phutung.php?id=<?= $item['MaSP'] ?>'">
                            <a href="chitiet_phutung.php?id=<?= $item['MaSP'] ?>">
                                <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($item['TenSP']) ?>">
                                <div class="product-title"><?= htmlspecialchars($item['TenSP']) ?></div>
                                <div class="product-price"><?= number_format($item['DonGia'], 0, ',', '.') ?> VNĐ</div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>