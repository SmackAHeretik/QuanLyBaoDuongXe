// Set loại xe & phân khúc khi chọn xe
document.getElementById('xemay_MaXE').addEventListener('change', function () {
    var selected = this.options[this.selectedIndex];
    document.getElementById('loaixe').value = selected.getAttribute('data-loaixe') || '';
    document.getElementById('phankhuc').value = selected.getAttribute('data-phankhuc') || '';
    $('#ThoiGianCaBlocks').html('');
    $('#ThoiGianCa').val('');
    $('#nhanvien_MaNV').html('<option value="">Chọn thợ sửa xe</option>');
    $('#NgayHen').val('');
});

// Khi chọn ngày hẹn, load ca làm việc qua AJAX và hiển thị dạng block
$('#NgayHen').on('change', function () {
    var ngay = $(this).val();
    $('#ThoiGianCaBlocks').html("Đang tải ca...");
    $('#ThoiGianCa').val("");
    $('#nhanvien_MaNV').html('<option value="">Chọn thợ sửa xe</option>');
    $.get('api/get_ca.php', { ngay: ngay }, function (data) {
        var cas = typeof data === "string" ? JSON.parse(data) : data;
        var html = '';
        cas.forEach(function (ca) {
            let disabled = ca.disabled ? 'disabled' : '';
            html += `<button type="button" class="btn block-ca btn-outline-primary" data-ca="${ca.ThoiGianCa}" ${disabled}>
                        ${ca.ThoiGianCa}
                    </button>`;
        });
        $('#ThoiGianCaBlocks').html(html);
    });
});

// Khi chọn ca, lấy danh sách thợ còn trống và render dropdown
$(document).on('click', '.block-ca', function () {
    if ($(this).prop('disabled')) return;
    $('.block-ca').removeClass('active');
    $(this).addClass('active');
    $('#ThoiGianCa').val($(this).data('ca'));

    var ngay = $('#NgayHen').val();
    var ca = $(this).data('ca');
    $.get('api/list_nhanvien_trongca.php', { ngay: ngay, ca: ca }, function(data){
        var nhanviens = typeof data === 'string' ? JSON.parse(data) : data;
        var html = '<option value="">Chọn thợ sửa xe</option>';
        nhanviens.forEach(function(nv){
            html += `<option value="${nv.MaNV}">${nv.TenNV}</option>`;
        });
        $('#nhanvien_MaNV').html(html);

        // Nếu muốn tự động chọn random 1 thợ mặc định:
        if(nhanviens.length > 0){
            var idx = Math.floor(Math.random() * nhanviens.length);
            $('#nhanvien_MaNV').val(nhanviens[idx].MaNV);
        }
    });
});