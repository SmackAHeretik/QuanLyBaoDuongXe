<?php
$projectRoot = '/QuanLyBaoDuongXe';
require_once __DIR__ . '/utils/ConnectDb.php';
require_once __DIR__ . '/../Admin/models/phutungxemaymodel.php';

if (!isset($_GET['id'])) {
  die("Thiếu mã sản phẩm.");
}
$maSP = intval($_GET['id']);

$db = new ConnectDb();
$pdo = $db->connect();
$model = new PhuTungXeMayModel($pdo);
$product = $model->getById($maSP);

// Lấy sản phẩm liên quan (cùng loại, khác mã)
$related = [];
if ($product) {
  $related = $pdo->prepare("SELECT * FROM phutungxemay WHERE loaiphutung = ? AND MaSP != ? AND TrangThai = 1 LIMIT 4");
  $related->execute([$product['loaiphutung'], $maSP]);
  $related = $related->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['TenSP']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .product-detail-container {
      display: flex;
      align-items: flex-start;
      margin-top: 40px;
    }

    .product-info {
      flex: 1.2;
      padding-right: 60px;
    }

    .product-image {
      flex: 1;
      text-align: right;
    }

    .product-image img {
      max-width: 350px;
      height: auto;
    }

    .product-title {
      font-size: 2rem;
      font-weight: bold;
    }

    .product-price {
      color: #d40000;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .related-title {
      font-size: 1.3rem;
      font-weight: bold;
      margin-top: 60px;
    }

    .related-products {
      display: flex;
      gap: 28px;
      margin-top: 18px;
    }

    .related-product {
      width: 160px;
      text-align: center;
    }

    .related-product img {
      max-width: 120px;
      height: 90px;
      object-fit: contain;
    }

    .buy-btn {
      margin-top: 28px;
      font-size: 1.1rem;
    }

    .product-description {
      font-size: 1.15rem;
      /* hoặc tăng số lớn hơn nếu muốn to hơn nữa */
      margin: 20px 0;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php if ($product): ?>
      <div class="product-detail-container">
        <div class="product-info">
          <div class="product-title"><?= htmlspecialchars($product['TenSP']) ?></div>
          <div class="product-price">Giá từ: <?= number_format($product['DonGia'], 0, ',', '.') ?> VNĐ</div>
          <div class="product-description">
            <?= nl2br(htmlspecialchars($product['MieuTaSP'])) ?>
          </div>
          <button class="btn btn-danger buy-btn">Mua</button>
        </div>
        <div class="product-image">
          <?php
          // Đường dẫn hình ảnh
          if (strpos($product['HinhAnh'], 'uploads/') === 0) {
            $src = $projectRoot . '/Admin/' . $product['HinhAnh'];
          } else {
            $src = $projectRoot . '/Admin/uploads/' . $product['HinhAnh'];
          }
          ?>
          <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>">
        </div>
      </div>
      <div class="related-title">Sản phẩm liên quan</div>
      <div class="related-products">
        <?php foreach ($related as $rel):
          if (strpos($rel['HinhAnh'], 'uploads/') === 0) {
            $rel_src = $projectRoot . '/Admin/' . $rel['HinhAnh'];
          } else {
            $rel_src = $projectRoot . '/Admin/uploads/' . $rel['HinhAnh'];
          }
          ?>
          <div class="related-product">
            <a href="chitiet_phutung.php?id=<?= $rel['MaSP'] ?>">
              <img src="<?= htmlspecialchars($rel_src) ?>" alt="<?= htmlspecialchars($rel['TenSP']) ?>">
              <div><?= htmlspecialchars($rel['TenSP']) ?></div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-danger mt-5">Không tìm thấy sản phẩm.</div>
    <?php endif; ?>
  </div>
</body>

</html>