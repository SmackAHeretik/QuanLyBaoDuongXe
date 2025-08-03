<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Mpdf\Mpdf;
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/HoaDonModel.php';
require_once __DIR__ . '/models/ChiTietHoaDonModel.php';

// Lấy mã hóa đơn từ URL
$mahd = $_GET['mahd'] ?? null;
if (!$mahd || !is_numeric($mahd)) {
    die("Mã hóa đơn không hợp lệ!");
}

// Kết nối DB, khởi tạo model
$pdo = connectDB();
$hoaDonModel = new HoaDonModel($pdo);
$chiTietModel = new ChiTietHoaDonModel($pdo);

// Lấy thông tin hóa đơn
$hd = $hoaDonModel->getById($mahd);
if (!$hd) {
    die("Không tìm thấy hóa đơn!");
}

// Lấy chi tiết hóa đơn (có tên phụ tùng và dịch vụ)
$chiTietList = $chiTietModel->getAllByHoaDon($mahd);

// Đường dẫn logo (dạng URL)
$logoUrl = 'http://localhost/QuanLyBaoDuongXe/User/images/logo.png';

// Ngày tháng năm xuất hóa đơn
$ngay = date('d');
$thang = date('m');
$nam = date('Y');

// HTML xuất hóa đơn
$html = '
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 13px; }
    .header { text-align:center; font-weight:bold; }
    .sub-header { font-size: 14px; }
    .left { text-align:left; }
    .right { text-align:right; }
    .center { text-align:center; }
    .table-bordered {
        border-collapse: collapse;
        width: 100%;
        margin-top: 8px;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #000;
        padding: 4px 3px;
        font-size: 13px;
    }
    .table-bordered th {
        background: #f9f9f9;
        font-weight: bold;
    }
    .footer-sign { margin-top:30px; }
</style>
<div>
    <table width="100%">
        <tr>
            <td width="20%" style="vertical-align:top">
                <img src="'.$logoUrl.'" width="100">
            </td>
            <td width="80%" class="header" style="text-align:center;">
                <b>Cửa hàng bảo trì xe 67 Performance</b><br>
                Địa chỉ: 87 Đường 27 Phường Bình Trị Đông B<br>
                Quận Bình Tân<br>
                ĐT: 0909.360.727
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td class="left" width="60%">
                Tên khách hàng: <b>' . htmlspecialchars($hd['TenKH'] ?? '') . '</b>
            </td>
            <td class="left" width="40%">
                Ngày: <b>' . htmlspecialchars($hd['Ngay'] ?? '') . '</b>
            </td>
        </tr>
        <tr>
            <td class="left" colspan="2">
                Địa chỉ: ...............................................................
            </td>
        </tr>
    </table>
    <br>
    <table class="table-bordered">
        <tr>
            <th width="4%">STT</th>
            <th width="37%">TÊN HÀNG</th>
            <th width="10%">SỐ LƯỢNG</th>
            <th width="19%">ĐƠN GIÁ</th>
            <th width="20%">THÀNH TIỀN</th>
        </tr>';

// In tối đa 10 dòng chi tiết hóa đơn
$tongCong = 0;
for ($i = 0; $i < 10; $i++) {
    if (isset($chiTietList[$i])) {
        $item = $chiTietList[$i];
        // Lấy tên hàng: ưu tiên tên phụ tùng, nếu không có lấy tên dịch vụ
        $ten = htmlspecialchars($item['TenSP'] ?? $item['TenDV'] ?? '');
        $sl = (int)$item['SoLuong'];
        $dg = (float)$item['GiaTien'];
        $tt = $sl * $dg;
        $tongCong += $tt;
        $dgShow = number_format($dg, 0, ',', '.');
        $ttShow = number_format($tt, 0, ',', '.');
    } else {
        $ten = $sl = $dgShow = $ttShow = '';
    }
    $html .= "
    <tr>
        <td class='center'>".($i+1)."</td>
        <td>$ten</td>
        <td class='center'>$sl</td>
        <td class='right'>$dgShow</td>
        <td class='right'>$ttShow</td>
    </tr>";
}

$html .= '
    <tr>
        <td colspan="4" class="right"><b>CỘNG</b></td>
        <td class="right"><b>'.number_format($tongCong,0,',','.').'</b></td>
    </tr>
</table>
<br>
Thành tiền: <b>'.number_format($tongCong,0,',','.').' VNĐ</b>
<br><br>
<div class="right" style="margin-right:30px;">
    Ngày '.$ngay.' tháng '.$thang.' năm '.$nam.'
</div>
<br>
<div class="footer-sign">
    <table width="100%">
        <tr>
            <td class="center" width="50%">
                <b>KHÁCH HÀNG</b><br><br><br>
                (Ký tên)
            </td>
            <td class="center" width="50%">
                <b>NGƯỜI BÁN HÀNG</b><br><br><br>
                (Ký tên)
            </td>
        </tr>
    </table>
</div>
</div>
';

$mpdf = new Mpdf([
    'format' => 'A5-P',
    'default_font' => 'dejavusans'
]);
$mpdf->SetTitle('Hóa đơn ' . $hd['MaHD']);
$mpdf->WriteHTML($html);
$mpdf->Output('hoadon_' . $hd['MaHD'] . '.pdf', 'I');
exit;
?>