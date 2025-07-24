<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4 shadow">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-primary mb-0">Danh sách lịch hẹn</h5>
            <a href="?controller=lichhen&action=add" class="btn btn-primary">
                <i class="fa fa-plus"></i> Thêm lịch hẹn
            </a>
        </div>
        <div id="popupMsg" style="display:none;position:fixed;top:30px;left:50%;transform:translateX(-50%);z-index:9999;" class="alert"></div>
        <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Mã LH</th>
                    <th>Khách hàng</th>
                    <th>Xe</th>
                    <th>Thợ</th> <!-- Đã đổi -->
                    <th>Ngày hẹn</th>
                    <th>Ca</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($ds as $lh): ?>
                <tr id="row_<?= $lh['MaLH'] ?>">
                    <td><?= $lh['MaLH'] ?></td>
                    <td><?= htmlspecialchars($lh['TenKH'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($lh['TenXe'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($lh['TenNV'] ?? ''); ?></td> <!-- Số liệu vẫn là tên nhân viên -->
                    <td><?= htmlspecialchars($lh['NgayHen']) ?></td>
                    <td><?= htmlspecialchars($lh['ThoiGianCa']) ?></td>
                    <td class="trangthai">
                        <?php
                        if($lh['TrangThai'] == 'cho duyet') echo '<span class="badge bg-warning text-dark">Chờ duyệt</span>';
                        elseif($lh['TrangThai'] == 'da duyet') echo '<span class="badge bg-success">Đã duyệt</span>';
                        elseif($lh['TrangThai'] == 'huy') echo '<span class="badge bg-danger">Đã hủy</span>';
                        else echo htmlspecialchars($lh['TrangThai']);
                        ?>
                    </td>
                    <td>
                        <?php if($lh['TrangThai'] == 'cho duyet'): ?>
                            <button class="btn btn-success btn-sm btn-duyet" data-id="<?= $lh['MaLH'] ?>" data-status="da duyet"><i class="fa fa-check"></i> Duyệt</button>
                            <button class="btn btn-danger btn-sm btn-duyet" data-id="<?= $lh['MaLH'] ?>" data-status="huy"><i class="fa fa-times"></i> Huỷ</button>
                        <?php endif; ?>
                        <a href="?controller=lichhen&action=edit&id=<?= $lh['MaLH'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Sửa</a>
                        <a href="?controller=lichhen&action=delete&id=<?= $lh['MaLH'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')"><i class="fa fa-trash"></i> Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $('.btn-duyet').click(function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        var $row = $('#row_'+id);
        $.post('?controller=lichhen&action=update_status', {id:id, status:status}, function(res){
            if(typeof res === 'string') res = JSON.parse(res);
            if(res.status=='success') {
                showPopup('Cập nhật trạng thái thành công!', 'success');
                var badge = '';
                if(status == 'da duyet') badge = '<span class="badge bg-success">Đã duyệt</span>';
                else if(status == 'huy') badge = '<span class="badge bg-danger">Đã hủy</span>';
                $row.find('.trangthai').html(badge);
                $row.find('.btn-duyet').remove();
            } else {
                showPopup('Cập nhật thất bại: '+(res.msg||''), 'danger');
            }
        });
    });
    function showPopup(msg, type){
        var $msg = $('#popupMsg');
        $msg.removeClass('alert-success alert-danger alert-warning').addClass('alert-' + (type=='success'?'success':'danger'));
        $msg.html(msg).fadeIn();
        setTimeout(function(){$msg.fadeOut();}, 2000);
    }
});
</script>