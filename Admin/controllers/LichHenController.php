<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/LichHenModel.php';

class LichHenController
{
    private $model;

    public function __construct()
    {
        $pdo = connectDB();
        $this->model = new LichHenModel($pdo);
    }

    public function danhsachlichhen()
    {
        $lichhen = $this->model->getAllLichHen();
        $content = __DIR__ . '/../views/lichhen/danhsachlichhen.php';
        include __DIR__ . '/../views/lichhen/layout.php';
    }

    public function danhsachlichbaohanh()
    {
        $lichbaohanh = $this->model->getAllLichBaoHanh();
        $content = __DIR__ . '/../views/lichhen/danhsachlichbaohanh.php';
        include __DIR__ . '/../views/lichhen/layout.php';
    }
}
?>