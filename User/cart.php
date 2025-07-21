<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>67 Performance - Giỏ hàng</title>
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
                <h2 class="mb-4">Giỏ hàng</h2>
                <form action="update_cart.php" method="post" class="bg-white p-4 rounded shadow-sm">
                    <?php if (empty($cart)): ?>
                        <div class="alert alert-info">Giỏ hàng trống.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Xe của bạn</th>
                                        <th>Đơn giá</th>
                                        <th width="120">Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $item): 
                                        $thanhtien = $item['DonGia'] * $item['qty'];
                                        $total += $thanhtien;
                                        // Đảm bảo hình đúng đường dẫn tuyệt đối
                                        if (!empty($item['HinhAnh']) && $item['HinhAnh'] !== 'no-image.png') {
                                            $imgSrc = '/QuanLyBaoDuongXe/Admin/' . $item['HinhAnh'];
                                        } else {
                                            $imgSrc = 'images/no-image.png';
                                        }
                                    ?>
                                    <tr>
                                        <td class="d-flex align-items-center gap-3">
                                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" width="60" class="rounded" alt="Ảnh sản phẩm">
                                            <div>
                                                <strong><?php echo htmlspecialchars($item['TenSP']); ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <?php 
                                                echo isset($item['TenXE']) && $item['TenXE']
                                                    ? htmlspecialchars($item['TenXE'])
                                                    : '-';
                                            ?>
                                        </td>
                                        <td class="don-gia" data-price="<?php echo $item['DonGia']; ?>">
                                            <?php echo number_format($item['DonGia'], 0, ',', '.'); ?> VNĐ
                                        </td>
                                        <td>
                                            <input type="number" class="form-control so-luong" name="qty[<?php echo $item['MaSP']; ?>]" value="<?php echo $item['qty']; ?>" min="1" style="width:70px;text-align:center;">
                                        </td>
                                        <td class="thanh-tien">
                                            <?php echo number_format($thanhtien, 0, ',', '.'); ?> VNĐ
                                        </td>
                                        <td>
                                            <a href="controller/remove_from_cart.php?MaSP=<?php echo $item['MaSP']; ?>" class="btn btn-danger btn-sm">Xóa</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="4" class="text-end"><b>Tổng cộng:</b></td>
                                        <td colspan="2"><b id="tong-cong"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
                            <a href="checkout.php" class="btn btn-success">Thanh toán</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </section>
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
    <script>
    // Xử lý số lượng và thành tiền động
    document.querySelectorAll('.so-luong').forEach(function(input) {
        input.addEventListener('input', function() {
            let value = parseInt(input.value, 10);
            if (isNaN(value) || value < 1) {
                input.value = 1;
                value = 1;
            }
            let row = input.closest('tr');
            let price = parseInt(row.querySelector('.don-gia').getAttribute('data-price'), 10);
            let thanhTienCell = row.querySelector('.thanh-tien');
            thanhTienCell.textContent = (price * value).toLocaleString('vi-VN') + ' VNĐ';

            // Cập nhật tổng cộng
            updateTongCong();
        });
        // Ngăn nhập số nhỏ hơn 1 bằng nút mũi tên
        input.addEventListener('change', function() {
            if (input.value < 1) input.value = 1;
            input.dispatchEvent(new Event('input'));
        });
    });

    function updateTongCong() {
        let tong = 0;
        document.querySelectorAll('tbody tr').forEach(function(row) {
            let priceCell = row.querySelector('.don-gia');
            let qtyInput = row.querySelector('.so-luong');
            if (priceCell && qtyInput) {
                let price = parseInt(priceCell.getAttribute('data-price'), 10);
                let qty = parseInt(qtyInput.value, 10);
                tong += price * qty;
            }
        });
        document.getElementById('tong-cong').textContent = tong.toLocaleString('vi-VN') + ' VNĐ';
    }
    </script>
</body>
</html>