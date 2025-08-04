<?php
require_once __DIR__ . '/../model/LichSuBaoHanhModel.php';

class LichSuBaoHanhController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new LichSuBaoHanhModel($db);
    }

   public function userHistory($maKH)
{
    $list = $this->model->getByUser($maKH);
    ob_start();
    require __DIR__ . '/../layouts/user/lichsu_baohanh.php';
    return ob_get_clean();
}
}
?>