<?php
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'LichHen';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'datLichForm';

require_once 'controller/' . $controllerName . 'Controller.php';
$fullControllerName = $controllerName . 'Controller';
$controller = new $fullControllerName();

// Nếu là AJAX (action trả JSON), chỉ gọi action, KHÔNG include layout
if ($actionName === 'nhanvienRon') {
  $controller->$actionName();
  exit; // Dừng lại, KHÔNG render HTML bên dưới
}

// Các action khác (ví dụ datLichForm) thì mới include layout/giao diện
?>
<!-- HTML giao diện ở đây -->
<!doctype html>
<html lang="en">
<!-- ... -->