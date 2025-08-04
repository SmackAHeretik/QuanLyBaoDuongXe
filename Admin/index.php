<?php include __DIR__ . '/auth_check.php'; ?>
<?php
require_once __DIR__ . '/db.php';
$pdo = connectDB();

// Khởi tạo biến an toàn
$doanhThu = 0;
$soDon = 0;
$label = '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'this_week';
$custom_from = isset($_GET['from']) ? $_GET['from'] : '';
$custom_to = isset($_GET['to']) ? $_GET['to'] : '';
$totalHoaDon = 0;
$hoaDonTrangThaiLabel = [];
$hoaDonTrangThai = [];
$hoaDonTrangThaiColors = [];
$barLabels = [];
$barData = [];
$lichHenPhanLoai = [0 => 0, 1 => 0];

switch ($filter) {
    case 'today': $dateWhere = "DATE(Ngay) = CURDATE()"; $label = 'Hôm nay'; break;
    case 'yesterday': $dateWhere = "DATE(Ngay) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)"; $label = 'Hôm qua'; break;
    case 'this_week': $dateWhere = "YEARWEEK(Ngay, 1) = YEARWEEK(CURDATE(), 1)"; $label = 'Tuần này'; break;
    case 'this_month': $dateWhere = "MONTH(Ngay) = MONTH(CURDATE()) AND YEAR(Ngay) = YEAR(CURDATE())"; $label = 'Tháng này'; break;
    case 'last_month': $dateWhere = "MONTH(Ngay) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(Ngay) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))"; $label = 'Tháng trước'; break;
    case 'this_year': $dateWhere = "YEAR(Ngay) = YEAR(CURDATE())"; $label = 'Năm nay'; break;
    case 'last_year': $dateWhere = "YEAR(Ngay) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))"; $label = 'Năm trước'; break;
    case 'custom':
        if ($custom_from && $custom_to) {
            $dateWhere = "DATE(Ngay) BETWEEN :from AND :to";
            $label = "Tùy chọn ($custom_from đến $custom_to)";
        } else { $dateWhere = "1=1"; $label = "Tùy chọn"; }
        break;
    default: $dateWhere = "YEARWEEK(Ngay, 1) = YEARWEEK(CURDATE(), 1)"; $label = 'Tuần này';
}

// Tổng doanh thu và số đơn
if ($filter === 'custom' && $custom_from && $custom_to) {
    $params = [':from'=>$custom_from, ':to'=>$custom_to];
    $stmt = $pdo->prepare("SELECT SUM(TongTien) as total FROM hoadon WHERE $dateWhere AND TrangThai = 'da_thanh_toan'");
    $stmt->execute($params);
    $doanhThu = $stmt->fetchColumn();
    if ($doanhThu === false || $doanhThu === null) $doanhThu = 0;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM hoadon WHERE $dateWhere AND TrangThai = 'da_thanh_toan'");
    $stmt->execute($params);
    $soDon = $stmt->fetchColumn();
    if ($soDon === false || $soDon === null) $soDon = 0;
} else {
    $stmt = $pdo->query("SELECT SUM(TongTien) as total FROM hoadon WHERE $dateWhere AND TrangThai = 'da_thanh_toan'");
    $doanhThu = $stmt->fetchColumn();
    if ($doanhThu === false || $doanhThu === null) $doanhThu = 0;
    $stmt = $pdo->query("SELECT COUNT(*) FROM hoadon WHERE $dateWhere AND TrangThai = 'da_thanh_toan'");
    $soDon = $stmt->fetchColumn();
    if ($soDon === false || $soDon === null) $soDon = 0;
}

// Chart 1: Doughnut hóa đơn theo trạng thái
if ($filter === 'custom' && $custom_from && $custom_to) {
    $stmt = $pdo->prepare("SELECT TrangThai, COUNT(*) as SoLuong FROM hoadon WHERE $dateWhere GROUP BY TrangThai");
    $stmt->execute([':from'=>$custom_from, ':to'=>$custom_to]);
} else {
    $stmt = $pdo->query("SELECT TrangThai, COUNT(*) as SoLuong FROM hoadon WHERE $dateWhere GROUP BY TrangThai");
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['TrangThai']=='da_thanh_toan') {
        $labelTT = 'Đã thanh toán'; $color = '#28a745';
    } else if ($row['TrangThai']=='cho_thanh_toan') {
        $labelTT = 'Chờ thanh toán'; $color = '#ffc107';
    } else {
        $labelTT = 'Hủy'; $color = '#dc3545';
    }
    $hoaDonTrangThaiLabel[] = $labelTT;
    $hoaDonTrangThaiColors[] = $color;
    $hoaDonTrangThai[] = (int)$row['SoLuong'];
    $totalHoaDon += (int)$row['SoLuong'];
}

// Chart 2: Bar doanh số từng ngày (theo filter)
if ($filter === 'custom' && $custom_from && $custom_to) {
    $stmt = $pdo->prepare("SELECT DATE(Ngay) as Ngay, SUM(TongTien) as DoanhSo FROM hoadon WHERE $dateWhere AND TrangThai='da_thanh_toan' GROUP BY DATE(Ngay) ORDER BY Ngay");
    $stmt->execute([':from'=>$custom_from, ':to'=>$custom_to]);
} else {
    $stmt = $pdo->query("SELECT DATE(Ngay) as Ngay, SUM(TongTien) as DoanhSo FROM hoadon WHERE $dateWhere AND TrangThai='da_thanh_toan' GROUP BY DATE(Ngay) ORDER BY Ngay");
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $barLabels[] = date('d/m/Y', strtotime($row['Ngay']));
    $barData[] = (float)$row['DoanhSo'];
}

// Chart 3: Doughnut lịch hẹn trong tháng này (PhanLoai)
$monthForLichHen = date('m');
$yearForLichHen = date('Y');
if ($filter === 'custom' && $custom_from && $custom_to) {
    $stmt = $pdo->prepare("SELECT PhanLoai, COUNT(*) AS SoLuong FROM lichhen WHERE DATE(NgayHen) BETWEEN :from AND :to GROUP BY PhanLoai");
    $stmt->execute([':from'=>$custom_from, ':to'=>$custom_to]);
} else {
    $stmt = $pdo->prepare("SELECT PhanLoai, COUNT(*) AS SoLuong FROM lichhen WHERE MONTH(NgayHen) = ? AND YEAR(NgayHen) = ?");
    $stmt->execute([$monthForLichHen, $yearForLichHen]);
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $lichHenPhanLoai[(int)$row['PhanLoai']] = (int)$row['SoLuong'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>DASHMIN - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
    .dashboard-stat-green {
        background: linear-gradient(135deg, #10b981 80%, #16e4b2 100%);
        border-radius: 14px;
        color: #fff;
        padding: 24px 20px 18px 24px;
        margin-bottom: 18px;
        font-weight: 500;
        min-height: 98px;
        box-shadow: 0 2px 8px rgba(44,62,80,0.04);
        border: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .dashboard-stat-green .label {
        font-size: 1.08rem;
        margin-bottom: 6px;
        color: #fff;
        font-weight: 500;
        opacity: 0.95;
    }
    .dashboard-stat-green .value {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 1px;
    }
    .dashboard-stat-light {
        background: #e6faf0;
        border-radius: 14px;
        color: #10b981;
        padding: 24px 20px 18px 24px;
        margin-bottom: 18px;
        font-weight: 500;
        min-height: 98px;
        box-shadow: 0 2px 8px rgba(44,62,80,0.04);
        border: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .dashboard-stat-light .label {
        font-size: 1.08rem;
        margin-bottom: 6px;
        color: #10b981;
        font-weight: 500;
        opacity: 0.95;
    }
    .dashboard-stat-light .value {
        font-size: 2rem;
        font-weight: 700;
        color: #10b981;
        letter-spacing: 1px;
    }
    .dashboard-chart-row {
        align-items: stretch;
        max-height: 520px;
        margin-bottom: 18px;
    }
    .dashboard-chart-bg {
        background: #181b20;
        border-radius: 18px;
        color: #fff;
        padding: 18px 5px 12px 5px;
        min-height: 380px;
        max-height: 500px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(44,62,80,0.04);
        margin-bottom: 0;
        height: 100%;
    }
    .dashboard-chart-bg h6 { color: #fff; font-weight: bold; margin-bottom: 12px; }
    .chart-legend-custom { margin-top: 8px; }
    .chart-legend-custom span { margin-right: 10px; padding: 2px 12px; border-radius: 8px; font-size:1em; }
    .chart-legend-custom .legend-dathanh { background:#28a745; color:#fff; }
    .chart-legend-custom .legend-chothanh { background:#ffc107; color:#222; }
    .chart-legend-custom .legend-huy { background:#dc3545; color:#fff; }
    .chart-legend-custom .legend-hen { background:#00bfff; color:#fff; }
    .chart-legend-custom .legend-bh { background:#ffc107; color:#222; }
    .dashboard-chart-bg .chart-summary { margin-top: 8px; color:#fff;}
    .dashboard-chart-bg .chart-summary .badge { font-size:1em; }
    .dashboard-chart-bg canvas {
        width: 100% !important;
        height: auto !important;
        max-width: 320px;
        max-height: 330px;
        margin: 0 auto;
        display: block;
    }
    .dashboard-chart-bg.chart-bar-full {
        max-width: 100%;
        min-height: 340px; /* tăng thêm 30px */
        max-height: 400px; /* tăng thêm 30px */
        padding-left: 8px;
        padding-right: 8px;
        margin-bottom: 50px; /* tăng thêm 10px */
        margin-top: 10px;    /* giữ khoảng cách phía trên */
    }
    .dashboard-chart-bg.chart-bar-full canvas {
        max-width: 820px;
        max-height: 300px;   /* tăng thêm 30px */
        width: 100% !important;
        height: 300px !important; /* tăng thêm 30px */
        margin: 0 auto;
        display: block;
    }
    @media (max-width: 1200px) {
        .dashboard-chart-bg, .dashboard-chart-bg.chart-bar-full { min-height: 180px; max-height: 270px; }
        .dashboard-chart-bg canvas,
        .dashboard-chart-bg.chart-bar-full canvas { max-width: 96vw; max-height: 140px; }
        .dashboard-chart-row { max-height: 280px; }
    }
    </style>
</head>
<body>
    <div class="container-xxl bg-transparent p-0">
        <?php include('./layouts/sidebar.php') ?>
        <div class="content" style="min-height:100vh;">
            <?php include('./layouts/navbar.php'); ?>

            <!-- FILTER & STATS -->
            <div class="container-fluid pt-4 px-4">
                <div class="dashboard-filter d-flex flex-wrap gap-2 align-items-center justify-content-center mb-2">
                    <?php
                    $filters = [
                        'today' => 'Hôm nay', 'yesterday' => 'Hôm qua',
                        'this_week' => 'Tuần này', 'this_month' => 'Tháng này',
                        'last_month' => 'Tháng trước', 'this_year' => 'Năm nay', 'last_year' => 'Năm trước'
                    ];
                    foreach ($filters as $key=>$text) {
                        $active = ($filter === $key) ? 'btn-success' : 'btn-outline-dark';
                        echo "<a href='?filter=$key' class='btn $active'>$text</a>";
                    }
                    ?>
                    <button class="btn <?=($filter==='custom'?'btn-warning':'btn-outline-warning')?>" id="customRangeBtn">Tùy chọn</button>
                    <form id="customRangeForm" class="d-inline-flex align-items-center gap-2 ms-2" style="display:<?=($filter==='custom'?'inline-flex':'none')?>;" method="get">
                        <input type="hidden" name="filter" value="custom">
                        <input type="date" name="from" value="<?=htmlspecialchars($custom_from)?>" class="form-control form-control-sm" required>
                        <span>-</span>
                        <input type="date" name="to" value="<?=htmlspecialchars($custom_to)?>" class="form-control form-control-sm" required>
                        <button class="btn btn-success btn-sm">Lọc</button>
                    </form>
                </div>
                <div class="row g-4 mb-2 justify-content-center">
                    <div class="col-md-6 col-xl-4">
                        <div class="dashboard-stat-green">
                            <div class="label">Tổng doanh thu Đã thanh toán <?=$label?></div>
                            <div class="value"><?=number_format($doanhThu,0,',','.')?> VND</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="dashboard-stat-light">
                            <div class="label">Tổng đơn hàng Đã thanh toán <?=$label?></div>
                            <div class="value"><?=$soDon?> <span style="font-size:1.15rem;font-weight:600;">đơn hàng</span></div>
                        </div>
                    </div>
                </div>
                <!-- CHARTS -->
                <div class="row g-4 dashboard-chart-row">
                    <div class="col-md-6 d-flex">
                        <div class="dashboard-chart-bg flex-grow-1 d-flex flex-column justify-content-center">
                            <h6 class="text-center">Trạng thái hóa đơn</h6>
                            <canvas id="chartHoaDonTrangThai"></canvas>
                            <div class="chart-legend-custom text-center mt-3">
                                <span class="legend-dathanh">Đã thanh toán</span>
                                <span class="legend-chothanh">Chờ thanh toán</span>
                                <span class="legend-huy">Hủy</span>
                            </div>
                            <div class="chart-summary text-center">
                                Đã thanh toán Chờ thanh toán Hủy<br>
                                Tổng đơn hàng: <b><?=$totalHoaDon?></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="dashboard-chart-bg flex-grow-1 d-flex flex-column justify-content-center">
                            <h6 class="text-center">Lịch hẹn trong tháng<br>(phân loại)</h6>
                            <canvas id="chartLichHenPhanLoai"></canvas>
                            <div class="chart-legend-custom text-center mt-3">
                                <span class="legend-hen">Lịch hẹn</span>
                                <span class="legend-bh">Lịch bảo hành</span>
                            </div>
                            <div class="chart-summary" style="font-size:13px;font-style:italic;">
                                Lịch hẹn Lịch bảo hành<br>
                                <span class="badge bg-info">Lịch hẹn: <?=isset($lichHenPhanLoai[0])?$lichHenPhanLoai[0]:0?></span>
                                <span class="badge bg-warning text-dark">Bảo hành: <?=isset($lichHenPhanLoai[1])?$lichHenPhanLoai[1]:0?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="dashboard-chart-bg chart-bar-full">
                            <h6 class="text-center">Doanh số bán hàng</h6>
                            <canvas id="chartDoanhSoThang"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CHARTS & STATS -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <?php include('layouts/form_layout.php'); ?>
                </div>
            </div>
        </div>
        <!-- Content End -->
    </div>

    <!-- Chart.js + datalabels -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $('#customRangeBtn').click(function(){ $('#customRangeForm').toggle(); });

    // Chart 1: Doughnut hóa đơn theo trạng thái
    new Chart(document.getElementById('chartHoaDonTrangThai').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($hoaDonTrangThaiLabel) ?>,
            datasets: [{
                data: <?= json_encode($hoaDonTrangThai) ?>,
                backgroundColor: <?= json_encode($hoaDonTrangThaiColors) ?>,
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    color: '#fff',
                    font: {weight: 'bold', size: 18},
                    formatter: (value, ctx) => {
                        let total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let percent = total ? (value/total*100).toFixed(1)+'%' : '';
                        return value + ' ('+percent+')';
                    }
                },
                legend: { position: 'bottom', labels: { color: '#fff' } }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Chart 2: Doughnut lịch hẹn phân loại (font nhỏ nghiêng ở chart-summary)
    new Chart(document.getElementById('chartLichHenPhanLoai').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Lịch hẹn','Lịch bảo hành'],
            datasets: [{
                data: <?= json_encode(array_values($lichHenPhanLoai)) ?>,
                backgroundColor: ['#00bfff','#ffc107']
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    color: '#222',
                    font: {weight: 'bold', size: 18},
                    formatter: (value, ctx) => {
                        let total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let percent = total ? (value/total*100).toFixed(1)+'%' : '';
                        return value + ' ('+percent+')';
                    }
                },
                legend: { position:'bottom', labels: { color: '#fff' } }
            }
        },
        plugins: [ChartDataLabels]
    });

    // Chart 3: Bar doanh số bán hàng từng ngày
    new Chart(document.getElementById('chartDoanhSoThang').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($barLabels) ?>,
            datasets: [{
                label: 'Doanh số (VND)',
                data: <?= json_encode($barData) ?>,
                backgroundColor: '#00ccff'
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                datalabels: {
                    color: '#fff',
                    anchor: 'end',
                    align: 'top',
                    font: {weight: 'bold', size: 14},
                    formatter: (value) => value > 0 ? value.toLocaleString() : ''
                },
                legend: { display:false }
            },
            scales: { 
                x: { 
                    ticks: { 
                        color: '#fff', 
                        font: {size: 12, style: 'italic'},
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: { 
                    ticks: { color: '#fff' }, 
                    beginAtZero: true 
                }
            }
        },
        plugins: [ChartDataLabels]
    });
    </script>
</body>
</html>