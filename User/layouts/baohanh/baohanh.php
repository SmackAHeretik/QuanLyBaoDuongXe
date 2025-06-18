
<section class="contact-section section-padding" id="section_5">
    <div class="container">
        <div class="row">
            <form action="datlichbaohanh.php" method="post" class="custom-form contact-form" role="form">
                <h2 class="mb-4 pb-2">Đặt Lịch Bảo Dưỡng/Bảo Hành</h2>
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
                    <!-- Ngày bảo dưỡng/bảo hành -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="Ngay" id="Ngay" required min="<?php echo date('Y-m-d'); ?>">
                            <label for="Ngay">Ngày bảo dưỡng/bảo hành</label>
                        </div>
                    </div>
                    <!-- Loại bảo hành -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <select class="form-select" name="LoaiBaoHanh" id="LoaiBaoHanh" required>
                                <option value="" selected disabled>Chọn loại bảo hành</option>
                                <option value="bảo hành phụ tùng">Bảo hành phụ tùng</option>
                                <option value="bảo dưỡng xe">Bảo dưỡng xe</option>
                                <option value="bảo trì động cơ">Bảo trì động cơ</option>
                            </select>
                            <label for="LoaiBaoHanh">Loại bảo hành</label>
                        </div>
                    </div>
                    <!-- Tên bảo hành/đăng ký -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="TenBHDK" id="TenBHDK" required placeholder="Tên bảo hành/đăng ký">
                            <label for="TenBHDK">Tên bảo hành/đăng ký</label>
                        </div>
                    </div>
                    <!-- Lý do bảo hành (ghi chú) -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" id="message" name="ThongTinTruocBaoHanh" placeholder="Nhập lý do bảo dưỡng/bảo hành"></textarea>
                            <label for="message">Lý do bảo dưỡng/bảo hành (tuỳ chọn)</label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-12">
                        <button type="submit" class="form-control">Đặt lịch bảo dưỡng</button>
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
        </script>