<!-- layouts/product-tabs/product-tabs.php -->
<section class="product-tabs py-5">
    <div class="container">
        <h2 class="text-center mb-4 text-white">Bảo Dưỡng Xe Tay Ga</h2>
        <div class="tab-nav d-flex justify-content-center flex-wrap gap-3 pb-3 border-bottom">
            <?php
            $products = [
                ['name' => 'JANUS 2024', 'price' => 'Giá từ 38.000.000 VNĐ', 'image' => 'janus2024.png'],
                ['name' => 'JANUS', 'price' => 'Giá từ 36.000.000 VNĐ', 'image' => 'janus.png'],
                ['name' => 'LEXI', 'price' => 'Giá từ 48.500.000 VNĐ', 'image' => 'lexi.png'],
                ['name' => 'GRANDE', 'price' => 'Giá từ 43.000.000 VNĐ', 'image' => 'grande.png'],
                ['name' => 'FREEGO', 'price' => 'Giá từ 41.000.000 VNĐ', 'image' => 'freego.png'],
                ['name' => 'LATTE', 'price' => 'Giá từ 39.000.000 VNĐ', 'image' => 'latte.png'],
                ['name' => 'NVX', 'price' => 'Giá từ 55.000.000 VNĐ', 'image' => 'nvx.png'],
            ];
            foreach ($products as $index => $p): ?>
                <button class="btn tab-btn <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                    <img src="images/<?= $p['image'] ?>" width="60" alt="<?= $p['name'] ?>"><br>
                    <?= $p['name'] ?>
                    <?php if (!empty($p['new'])): ?><span class="text-danger small text-white">NEW</span><?php endif; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="tab-content mt-4">
            <?php foreach ($products as $index => $p): ?>
                <div class="tab-pane <?= $index === 0 ? 'd-block' : 'd-none' ?>" data-index="<?= $index ?>">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <img src="images/<?= $p['image'] ?>" class="img-fluid mb-3" alt="<?= $p['name'] ?>">
                        </div>
                        <div class="col-md-7 text-end tab-content-box">
                            <h3><?= $p['name'] ?></h3>
                            <p class="text-white"><?= $p['price'] ?></p>
                            <a href="#" class="btn btn-light">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const index = this.dataset.index;
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('d-none'));

                this.classList.add('active');
                document.querySelector('.tab-pane[data-index="' + index + '"]').classList.remove('d-none');
                document.querySelector('.tab-pane[data-index="' + index + '"]').classList.add('d-block');
            });
        });
    </script>
</section>
