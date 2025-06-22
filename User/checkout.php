<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>67 Performance - Đặt hàng</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>
<body>
    <main>
        <?php include('./layouts/navbar/navbar.php') ?>
        <?php include('./layouts/hero/hero.php') ?>  
        <section class="section-padding">
            <div class="container">
                <h2 class="mb-4">Đặt hàng</h2>
                <?php if (empty($cart)): ?>
                    <div class="alert alert-info">Giỏ hàng trống. <a href="index.php">Quay về trang chủ</a></div>
                <?php else: ?>
                    <form action="controller/process_checkout.php" method="post" class="bg-white p-4 rounded shadow-sm">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th width="120">Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $item): 
                                        $thanhtien = $item['DonGia'] * $item['qty'];
                                        $total += $thanhtien;
                                    ?>
                                    <tr>
                                        <td class="d-flex align-items-center gap-3">
                                            <?php
                                                $img = $item['HinhAnh'];
                                                if (strpos($img, '/') === 0 || strpos($img, 'uploads/') === 0 || strpos($img, 'Admin/') === 0) {
                                                    $imgSrc = $img;
                                                } else {
                                                    $imgSrc = 'images/' . $img;
                                                }
                                            ?>
                                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" width="60" class="rounded" alt="">
                                            <div>
                                                <strong><?php echo htmlspecialchars($item['TenSP']); ?></strong>
                                            </div>
                                        </td>
                                        <td><?php echo number_format($item['DonGia'], 0, ',', '.'); ?> VNĐ</td>
                                        <td><?php echo $item['qty']; ?></td>
                                        <td><?php echo number_format($thanhtien, 0, ',', '.'); ?> VNĐ</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><b>Tổng cộng:</b></td>
                                        <td><b><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5 class="mt-4 mb-3">Thông tin khách hàng</h5>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú (không bắt buộc)</label>
                            <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="cart.php" class="btn btn-secondary">Quay lại giỏ hàng</a>
                            <button type="submit" class="btn btn-success">Đặt hàng</button>
                        </div>
                    </form>
                <?php endif; ?>
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