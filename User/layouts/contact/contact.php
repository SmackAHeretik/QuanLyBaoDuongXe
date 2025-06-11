<section class="contact-section section-padding" id="section_5">
    <div class="container">
        <div class="row">
            <form action="index.php?controller=LichHen&action=luuLichHen" method="post" class="custom-form contact-form"
                role="form" onsubmit="return validateTime()">
                <h2 class="mb-4 pb-2">Đặt Lịch Hẹn</h2>
                <div class="row">
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="datetime-local" name="ngayhen" id="ngayhen" class="form-control" required
                                min="<?= date('Y-m-d\TH:i') ?>">
                            <label for="ngayhen">Chọn ngày và giờ hẹn</label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <select class="form-select" name="manv" id="manv" required="">
                                <option value="" selected disabled>Chọn nhân viên</option>
                            </select>
                            <label for="manv">Nhân viên</label>
                        </div>
                    </div>
                    <!-- Loại xe nằm trên Lý do hẹn -->
                    <div class="col-lg-12 col-12 mb-3">
                        <div class="form-floating">
                            <input type="text" name="loaixe" id="loaixe" class="form-control" placeholder="Nhập loại xe"
                                required>
                            <label for="loaixe">Loại xe</label>
                        </div>
                    </div>
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
        </div>
        <script>
            function validateTime() {
                const input = document.getElementById('ngayhen');
                if (!input.value) return false;
                const d = new Date(input.value);
                const hour = d.getHours();
                if (hour < 6 || hour >= 20) {
                    alert('Chỉ được đặt lịch từ 6h sáng đến 8h tối!');
                    return false;
                }
                return true;
            }

            document.getElementById('ngayhen').addEventListener('change', function () {
                var datetime = this.value;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php?controller=LichHen&action=nhanvienRon', true);
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