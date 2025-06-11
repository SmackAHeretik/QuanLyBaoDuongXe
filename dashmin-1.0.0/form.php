<?php
session_start();
require_once 'controllers/phutungxemayController.php';
$controller = new PhuTungXeMayController();

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
        $controller->list();
}
?>