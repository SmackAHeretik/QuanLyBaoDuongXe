<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $MaSP => $qty) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['MaSP'] == $MaSP) {
                $item['qty'] = max(1, intval($qty));
            }
        }
    }
    unset($item);
}
header('Location: ../cart.php');
exit;
?>