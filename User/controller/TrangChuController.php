<?php
// File này KHÔNG dùng session, chỉ include view, KHÔNG cần session_name

class TrangChuController
{
  public function index()
  {
    include __DIR__ . '/../layouts/hero/hero.php';
    include __DIR__ . '/../layouts/about/about.php';
    include __DIR__ . '/../layouts/product-tabs/product-tabs.php';
    include __DIR__ . '/../layouts/services/services.php';
    include __DIR__ . '/../layouts/news/news.php';
    include __DIR__ . '/../layouts/contact/contact.php';
  }
}
?>