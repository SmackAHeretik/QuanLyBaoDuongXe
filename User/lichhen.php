<?php

session_start();

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'LichHen';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'datLichForm';

require_once 'controller/' . $controllerName . 'Controller.php';
$fullControllerName = $controllerName . 'Controller';
$controller = new $fullControllerName();

// Nếu là AJAX (action trả JSON), chỉ gọi action, KHÔNG include layout
if ($actionName === 'nhanvienRon') {
    $controller->$actionName();
    exit;
}

// Nếu là POST (submit đặt lịch), chỉ xử lý và exit, KHÔNG render HTML bên dưới
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->datLich();
    exit;
}

// Lấy biến lỗi nếu có để truyền vào contact.php
$error = isset($GLOBALS['error']) ? $GLOBALS['error'] : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>67 Performance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-tiya-golf-club.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
</head>
<body>
    <main>
        <?php include('./layouts/navbar/navbar.php') ?>
        <?php include('./layouts/hero/hero.php') ?>   
        <?php include('./layouts/contact/contact.php') ?>  
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
    <script>
        const newsSwiper = new Swiper('.news-swiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                576: { slidesPerView: 1.5 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 }
            }
        });
    </script>
    <script src="js/custom.js"></script>
</body>
</html>