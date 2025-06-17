<section class="contact-section section-padding" id="section_5">
    <div class="container">
        <div class="row">
            <form action="datlich.php" method="post" class="custom-form contact-form" role="form">
                <h2 class="mb-4 pb-2">Đặt Lịch Hẹn</h2>
                <div class="row">
                    <!-- Lựa chọn tên xe -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <select class="form-select" name="tenxe" id="tenxe" required>
                                <option value="" selected disabled>Chọn xe của bạn</option>
                                <?php if (!empty($bikeList)): ?>
                                    <?php foreach ($bikeList as $bike): ?>
                                        <option 
                                            value="<?php echo htmlspecialchars($bike['MaXE']); ?>"
                                            data-loaixe="<?php echo htmlspecialchars($bike['LoaiXe']); ?>"
                                            data-phankhuc="<?php echo htmlspecialchars($bike['PhanKhuc']); ?>"
                                        >
                                            <?php echo htmlspecialchars($bike['TenXe'] . ' - ' . $bike['BienSoXe']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <label for="tenxe">Tên xe</label>
                        </div>
                    </div>
                    <!-- Loại xe (readonly) -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="loaixe" name="loaixe" readonly required placeholder="Loại xe">
                            <label for="loaixe">Loại xe</label>
                        </div>
                    </div>
                    <!-- Phân khúc (readonly) -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="phankhuc" name="phankhuc" readonly required placeholder="Phân khúc">
                            <label for="phankhuc">Phân khúc</label>
                        </div>
                    </div>
                    <!-- Thời gian hẹn -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="datetime-local" name="thoigianhen" id="thoigianhen" class="form-control"
                                min="<?php echo date('Y-m-d'); ?>T08:00"
                                max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>T20:00" required>
                            <label for="thoigianhen">Chọn ngày & giờ hẹn (Thứ 2 - Thứ 7, 08:00 - 20:00)</label>
                            <div id="thoigianhen-error" style="color:red;font-size:13px;display:none"></div>
                        </div>
                    </div>
                    <!-- Nhân viên -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <select class="form-select" name="manv" id="manv" required>
                                <option value="" selected disabled>Chọn nhân viên</option>
                            </select>
                            <label for="manv">Nhân viên</label>
                        </div>
                    </div>
                    <!-- Lý do hẹn -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="message" name="message" placeholder="Nhập lý do hẹn"
                                required=""></textarea>
                            <label for="message">Lý do hẹn</label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-12">
                        <button type="submit" class="form-control">Đặt lịch</button>
                    </div>
                </div>
            </form>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger mt-2"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
        <script>
            // Khi chọn xe, tự động fill loại xe và phân khúc
            document.getElementById('tenxe').addEventListener('change', function () {
                var selected = this.options[this.selectedIndex];
                document.getElementById('loaixe').value = selected.getAttribute('data-loaixe') || '';
                document.getElementById('phankhuc').value = selected.getAttribute('data-phankhuc') || '';
            });

            // Khóa chọn ngày quá khứ, chủ nhật, ngoài giờ, hiện lỗi nhỏ dưới input
            document.getElementById('thoigianhen').addEventListener('input', function () {
                var input = this.value;
                var errorDiv = document.getElementById('thoigianhen-error');
                errorDiv.style.display = 'none';
                if (!input) return;
                var dt = new Date(input);
                var now = new Date();
                if (dt.getTime() < now.getTime() - 60000) {
                    this.value = '';
                    errorDiv.textContent = 'Không được chọn ngày giờ trong quá khứ!';
                    errorDiv.style.display = 'block';
                    return;
                }
                if (dt.getDay() === 0) {
                    this.value = '';
                    errorDiv.textContent = 'Chỉ được chọn từ Thứ 2 đến Thứ 7!';
                    errorDiv.style.display = 'block';
                    return;
                }
                var hour = dt.getHours();
                var minute = dt.getMinutes();
                if (hour < 8 || (hour === 20 && minute > 0) || hour > 20) {
                    this.value = '';
                    errorDiv.textContent = 'Chỉ được chọn giờ từ 08:00 đến 20:00!';
                    errorDiv.style.display = 'block';
                    return;
                }
            });

            // Gọi AJAX khi thay đổi ngày giờ để lấy nhân viên rảnh
            document.getElementById('thoigianhen').addEventListener('change', function () {
                var datetime = this.value.replace('T', ' ');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'datlich.php?controller=LichHen&action=nhanvienRon', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var nhanviens = JSON.parse(xhr.responseText);
                        var select = document.getElementById('manv');
                        select.innerHTML = '<option value="" selected disabled>Chọn nhân viên</option>';
                        if (nhanviens.length === 0) {
                            var opt = document.createElement('option');
                            opt.value = "any";
                            opt.textContent = "Ai cũng được";
                            select.appendChild(opt);
                        } else {
                            nhanviens.forEach(function (nv) {
                                var opt = document.createElement('option');
                                opt.value = nv.MaNV;
                                opt.textContent = nv.TenNV;
                                select.appendChild(opt);
                            });
                        }
                    }
                };
                xhr.send('datetime=' + encodeURIComponent(datetime));
            });
        </script>
    </div>
</section>