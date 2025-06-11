<?php
class TrangChuController
{
  public function index()
  {
    // Gọi giao diện trang chủ (có thể là layouts/hero/hero.php hoặc gì đó)

    include __DIR__ . '/../layouts/hero/hero.php';
    include __DIR__ . '/../layouts/about/about.php';
    include __DIR__ . '/../layouts/product-tabs/product-tabs.php';
    include __DIR__ . '/../layouts/services/services.php';
    include __DIR__ . '/../layouts/news/news.php';
    include __DIR__ . '/../layouts/contact/contact.php';
  }
}
?>