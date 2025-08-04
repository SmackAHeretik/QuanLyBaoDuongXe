<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('USERSESSID');
    session_start();
}
$projectRoot = '/QuanLyBaoDuongXe';
require_once __DIR__ . '/utils/ConnectDb.php';
require_once __DIR__ . '/../Admin/models/phutungxemaymodel.php';

// Kết nối DB
$db = new ConnectDb();
$pdo = $db->connect();
$model = new PhuTungXeMayModel($pdo);
$products = $model->getAll();

// Lấy các loại phụ tùng DISTINCT từ DB
$categoryList = [];
$stmt = $pdo->query("SELECT DISTINCT loaiphutung FROM phutungxemay WHERE loaiphutung IS NOT NULL AND loaiphutung <> ''");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categoryList[] = $row['loaiphutung'];
}

// Lấy các hãng từ bảng nhasanxuat
$brandList = [];
$stmt = $pdo->query("SELECT MaNSX, TenNhaSX FROM nhasanxuat WHERE TenNhaSX IS NOT NULL AND TenNhaSX <> ''");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $brandList[$row['MaNSX']] = $row['TenNhaSX'];
}

// Lấy filter từ GET
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : [];
$brand = isset($_GET['brand']) ? $_GET['brand'] : [];
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Hàm chuẩn hóa tiếng Việt
function normalize($str) {
    $str = strtolower($str);
    $unicode = [
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ'
    ];
    foreach($unicode as $nonUnicode=>$uni){
        $str = preg_replace("/($uni)/u", $nonUnicode, $str);
    }
    $str = preg_replace('/\s+/', '', $str);
    $str = trim($str);
    return $str;
}

// Lọc kết quả
$resultList = [];
if ($products && count($products) > 0) {
    foreach ($products as $item) {
        if ($item['TrangThai'] != 1) continue;

        $isMatch = true;

        // Tìm kiếm gần đúng tên hoặc giá
        if ($q !== '') {
            $searchNorm = normalize($q);
            $tenspNorm = normalize($item['TenSP']);

            if (is_numeric($q)) {
                $giaSanPham = (int)preg_replace('/[^\d]/', '', $item['DonGia']);
                if (strpos((string)$giaSanPham, $q) === false) {
                    $isMatch = false;
                }
            } else {
                if (strpos($tenspNorm, $searchNorm) === false) {
                    $giaSanPham = (int)preg_replace('/[^\d]/', '', $item['DonGia']);
                    if (strpos((string)$giaSanPham, $searchNorm) === false) {
                        $isMatch = false;
                    }
                }
            }
        }

        // Lọc loại phụ tùng
        if (!empty($category) && !in_array($item['loaiphutung'], $category)) continue;

        // Lọc theo hãng (MaNSX)
        if (!empty($brand) && !in_array($item['nhasanxuat_MaNSX'], $brand)) continue;

        if ($isMatch) $resultList[] = $item;
    }
    // Sắp xếp
    if ($sort === 'price_asc') {
        usort($resultList, fn($a, $b) => $a['DonGia'] - $b['DonGia']);
    } elseif ($sort === 'price_desc') {
        usort($resultList, fn($a, $b) => $b['DonGia'] - $a['DonGia']);
    } elseif ($sort === 'name_asc') {
        usort($resultList, fn($a, $b) => strcmp($a['TenSP'], $b['TenSP']));
    } elseif ($sort === 'name_desc') {
        usort($resultList, fn($a, $b) => strcmp($b['TenSP'], $a['TenSP']));
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
        .main-flex { display: flex; gap: 32px; }
        .sidebar-left {
            width: 280px;
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 10px;
            padding: 24px 20px;
            min-height: 420px;
            margin-top: 32px;
            height: fit-content;
        }
        .sidebar-left h3 { font-size: 20px; font-weight: bold; margin-bottom: 16px; }
        .sidebar-group { margin-bottom: 32px; }
        .sidebar-group label { display: block; margin-bottom: 8px; font-size: 15px;}
        .sidebar-group input[type="checkbox"] { margin-right: 8px;}
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
        .filters-flex { display: flex; gap: 24px; align-items: center; margin-bottom: 32px;}
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
        .sort-dropdown {
            height: 44px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ececec;
            background: #fff;
            color: #222;
            min-width: 170px;
            padding: 0 12px;
        }
        .all-option-label {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 18px;
            margin-top: 12px;
            cursor: pointer;
            display: block;
        }
        .all-option-checkbox {
            accent-color: #222;
            margin-right: 8px;
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }
        @media (max-width: 991.98px) {
            .main-flex { flex-direction: column; }
            .sidebar-left { width: 100%; margin-bottom: 24px;}
            .product-card-list { gap: 18px; }
            .product-card { width: 31%; }
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
                <div class="main-flex">
                    <!-- SIDEBAR BÊN TRÁI -->
                    <form method="get" class="sidebar-left">
                        <h3>Danh mục phụ tùng</h3>
                        <!-- Tất cả phụ tùng Option -->
                        <label class="all-option-label">
                            <input type="checkbox" class="all-option-checkbox"
                                   name="all_parts"
                                   value="1"
                                   onchange="if(this.checked){this.form.querySelectorAll('input[type=checkbox][name^=category],input[type=checkbox][name^=brand]').forEach(cb=>cb.checked=false);}this.form.submit();"
                                   <?= (isset($_GET['all_parts']) && $_GET['all_parts']=='1') ? 'checked' : '' ?>>
                            Tất cả phụ tùng
                        </label>
                        <div class="sidebar-group">
                            <div style="font-weight:600; margin-bottom:8px;">Loại phụ tùng</div>
                            <?php foreach ($categoryList as $cat): ?>
                                <label>
                                    <input type="checkbox" name="category[]" value="<?= htmlspecialchars($cat) ?>"
                                        <?= !empty($category) && in_array($cat, $category) ? 'checked' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="sidebar-group">
                            <div style="font-weight:600; margin-bottom:8px;">Hãng</div>
                            <?php foreach ($brandList as $brandId => $brandName): ?>
                                <label>
                                    <input type="checkbox" name="brand[]" value="<?= htmlspecialchars($brandId) ?>"
                                        <?= !empty($brand) && in_array($brandId, $brand) ? 'checked' : '' ?>>
                                    <?= htmlspecialchars($brandName) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-3">Áp dụng bộ lọc</button>
                    </form>
                    <!-- NỘI DUNG CHÍNH -->
                    <div style="flex:1;">
                        <div class="filters-flex">
                            <form method="get" class="custom-search-box" style="flex:1">
                                <?php foreach ($category as $cat): ?>
                                    <input type="hidden" name="category[]" value="<?= htmlspecialchars($cat) ?>">
                                <?php endforeach; ?>
                                <?php foreach ($brand as $b): ?>
                                    <input type="hidden" name="brand[]" value="<?= htmlspecialchars($b) ?>">
                                <?php endforeach; ?>
                                <input type="text" name="q" class="form-control" placeholder="Nhập tên sản phẩm hoặc giá..."
                                    value="<?= htmlspecialchars($q) ?>">
                                <button type="submit"><span class="bi bi-search"></span></button>
                            </form>
                            <form method="get">
                                <?php foreach ($category as $cat): ?>
                                    <input type="hidden" name="category[]" value="<?= htmlspecialchars($cat) ?>">
                                <?php endforeach; ?>
                                <?php foreach ($brand as $b): ?>
                                    <input type="hidden" name="brand[]" value="<?= htmlspecialchars($b) ?>">
                                <?php endforeach; ?>
                                <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
                                <select name="sort" class="sort-dropdown" onchange="this.form.submit()">
                                    <option value="">Sắp xếp theo</option>
                                    <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                                    <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                                    <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                                    <option value="name_desc" <?= $sort == 'name_desc' ? 'selected' : '' ?>>Tên Z-A</option>
                                </select>
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