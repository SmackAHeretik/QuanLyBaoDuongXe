<div class="container mt-4">
    <h2>Danh sách xe máy</h2>
    <?php
        if (!empty($msg)) {
            if ($msg == 'add_success') {
                echo '<div class="alert alert-success">Thêm xe máy thành công!</div>';
            } elseif ($msg == 'edit_success') {
                echo '<div class="alert alert-success">Sửa xe máy thành công!</div>';
            } elseif ($msg == 'delete_success') {
                echo '<div class="alert alert-success">Xóa xe máy thành công!</div>';
            }
        }
        $defaultImg = "uploads/noimage.png";
        $baseImgPath = "/QuanLyBaoDuongXe/User/";   // Đường dẫn tuyệt đối đến thư mục uploads
    ?>
    <a href="table.php?controller=xemay&action=them" class="btn btn-primary mb-3">Thêm xe máy</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã xe</th>
                <th>Tên xe</th>
                <th>Loại xe</th>
                <th>Phân khúc</th>
                <th>Biển số</th>
                <th>Ảnh mặt trước</th>
                <th>Ảnh mặt sau</th>
                <th>Tên khách hàng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($xemays as $xe): ?>
            <tr>
                <td><?= $xe['MaXE'] ?></td>
                <td><?= htmlspecialchars($xe['TenXe']) ?></td>
                <td><?= htmlspecialchars($xe['LoaiXe']) ?></td>
                <td><?= htmlspecialchars($xe['PhanKhuc']) ?></td>
                <td><?= htmlspecialchars($xe['BienSoXe']) ?></td>
                <td>
                    <?php
                        $imgTruoc = $xe['HinhAnhMatTruocXe'];
                        $srcTruoc = (!empty($imgTruoc)) ? $baseImgPath . $imgTruoc : $baseImgPath . $defaultImg;
                        echo '<img src="' . htmlspecialchars($srcTruoc) . '" style="max-width:80px;">';
                    ?>
                </td>
                <td>
                    <?php
                        $imgSau = $xe['HinhAnhMatSauXe'];
                        $srcSau = (!empty($imgSau)) ? $baseImgPath . $imgSau : $baseImgPath . $defaultImg;
                        echo '<img src="' . htmlspecialchars($srcSau) . '" style="max-width:80px;">';
                    ?>
                </td>
                <td><?= htmlspecialchars($xe['TenKH']) ?></td>
                <td>
                    <a href="table.php?controller=xemay&action=sua&MaXE=<?= $xe['MaXE'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="table.php?controller=xemay&action=xoa&MaXE=<?= $xe['MaXE'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc muốn xóa xe này?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>