<?php
$projectRoot = '/QuanLyBaoDuongXe';
require_once __DIR__ . '/utils/ConnectDb.php';
require_once __DIR__ . '/../Admin/models/phutungxemaymodel.php';

$db = new ConnectDb();
$pdo = $db->connect();
$model = new PhuTungXeMayModel($pdo);
$products = $model->getAll(); // hoặc getAllHienThi() nếu muốn chỉ lấy sản phẩm TrangThai = 1
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Phụ tùng xe máy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 40px 0;
    }

    .product-item {
      width: 25%;
      text-align: center;
      margin-bottom: 40px;
      cursor: pointer;
      transition: box-shadow .2s;
    }

    .product-item:hover {
      box-shadow: 0 0 8px #bbb;
    }

    .product-item img {
      max-width: 180px;
      height: 120px;
      object-fit: contain;
      margin-bottom: 16px;
      transition: transform .2s;
    }

    .product-item:hover img {
      transform: scale(1.07);
    }

    .product-title {
      font-weight: 600;
      margin-bottom: 6px;
      font-size: 18px;
    }

    .product-price {
      color: #d40000;
      font-size: 18px;
      font-weight: 700;
    }

    @media (max-width: 991.98px) {
      .product-item {
        width: 33.333%;
      }
    }

    @media (max-width: 767.98px) {
      .product-item {
        width: 50%;
      }
    }

    @media (max-width: 575.98px) {
      .product-item {
        width: 100%;
      }
    }

    .search-box {
      width: 350px;
      float: right;
      margin-bottom: 30px;
    }

    a.product-link {
      text-decoration: none;
      color: inherit;
      display: block;
      height: 100%;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="row mb-3 align-items-center">
      <div class="col">
        <h2 class="mb-0">Phụ tùng xe máy</h2>
      </div>
      <div class="col-auto">
        <form method="get" class="search-box" style="display:flex;">
          <input type="text" name="q" class="form-control" placeholder="Nhập tên sản phẩm"
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
          <button type="submit" class="btn btn-outline-secondary ms-2"><span class="bi bi-search"></span>🔍</button>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="product-grid">
        <?php
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
        if (count($resultList) == 0) {
          echo '<div class="col-12 text-center text-muted mt-5">Không có sản phẩm nào phù hợp.</div>';
        }
        foreach ($resultList as $item):
          if (strpos($item['HinhAnh'], 'uploads/') === 0) {
            $src = $projectRoot . '/Admin/' . $item['HinhAnh'];
          } else {
            $src = $projectRoot . '/Admin/uploads/' . $item['HinhAnh'];
          }
          ?>
          <div class="product-item">
            <a class="product-link" href="chitiet_phutung.php?id=<?= $item['MaSP'] ?>">
              <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($item['TenSP']) ?>">
              <div class="product-title"><?= htmlspecialchars($item['TenSP']) ?></div>
              <div class="product-price"><?= number_format($item['DonGia'], 0, ',', '.') ?> VNĐ</div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</body>

</html>