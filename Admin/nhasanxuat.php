<?php
session_start();
require_once 'controllers/NhaSanXuatController.php';

$controller = new NhaSanXuatController();
$action = $_GET['action'] ?? 'list';

switch ($action) {
  case 'add':
    $controller->add();
    break;
  case 'edit':
    $controller->edit();
    break;
  case 'delete':
    $controller->delete();
    break;
  default:
    $controller->list(); // mặc định là hiển thị danh sách
}
