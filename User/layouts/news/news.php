<section class="news-section py-5 bg-light">
  <div class="container text-center">
    <h2 class="mb-4 fw-bold">TIN TỨC</h2>
    <div class="swiper news-swiper">
      <div class="swiper-wrapper">
        <?php
        $news = [
          ['title' => 'Ra mắt dòng xe mới 2024', 'image' => 'new1.png'],
          ['title' => 'Sự kiện lái thử cuối tuần', 'image' => 'new2.png'],
          ['title' => 'Ưu đãi tháng 6 - Giảm giá đặc biệt', 'image' => 'new3.png'],
          ['title' => 'Bảo dưỡng miễn phí toàn quốc', 'image' => 'new4.png'],
          ['title' => 'Khai trương đại lý mới', 'image' => 'new5.png'],
          ['title' => 'Giao lưu cộng đồng người dùng Yamaha', 'image' => 'new6.png'],
        ];
        foreach ($news as $n): ?>
          <div class="swiper-slide">
            <a href="#" class="text-decoration-none text-dark">
              <div class="news-item">
                <div class="img-container">
                  <img src="images/<?= $n['image'] ?>" alt="<?= $n['title'] ?>" class="img-fluid">
                </div>
                <h6 class="mt-2 fw-bold"><?= $n['title'] ?></h6>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- Navigation -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>
