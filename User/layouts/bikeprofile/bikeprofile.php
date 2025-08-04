<?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
    <div class="alert alert-success d-flex align-items-center justify-content-center shadow rounded-3 my-4" role="alert" style="max-width: 600px; margin: 0 auto; font-size: 1.15rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07.02l3.992-3.99a.75.75 0 1 0-1.06-1.06L7.5 9.439 6.03 7.97a.75.75 0 1 0-1.06 1.06l2 2z"/>
        </svg>
        <div>
            <strong>Thành công!</strong> Đã thêm xe máy mới vào hệ thống.
        </div>
    </div>
    <script>
    if (document.querySelector('.alert-success')) {
        document.querySelector('.alert-success').scrollIntoView({behavior: "smooth"});
    }
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'trung_so_khung_so_may'): ?>
    <div class="alert alert-danger d-flex align-items-center justify-content-center shadow rounded-3 my-4" role="alert" style="max-width: 600px; margin: 0 auto; font-size: 1.15rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.964 0L.165 13.233c-.457.778.091 1.767.982 1.767h13.707c.89 0 1.438-.99.982-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z"/>
        </svg>
        <div>
            <strong>Lỗi:</strong> Số khung hoặc số máy đã tồn tại trên hệ thống!
        </div>
    </div>
    <script>
    if (document.querySelector('.alert-danger')) {
        document.querySelector('.alert-danger').scrollIntoView({behavior: "smooth"});
    }
    </script>
<?php endif; ?>

<section class="membership-section section-padding" id="section_profile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mx-auto mb-lg-5 mb-4">
                <h2><span>Thông tin</span> xe máy</h2>
            </div>
            <div class="col-lg-6 col-12 mx-auto">
                <form action="./controller/bikeprofile_controller.php" method="POST" class="custom-form membership-form shadow-lg" role="form" enctype="multipart/form-data" id="addBikeForm">
                    <input type="hidden" name="add_bike" value="1">

                    <div class="form-floating mb-3">
                        <input type="text" name="TenXe" id="TenXe" class="form-control" placeholder="Tên Xe" required>
                        <label for="TenXe">Tên Xe</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="LoaiXe" id="LoaiXe" class="form-control" required>
                            <option value="">Chọn loại xe</option>
                            <option value="Xe tay ga">Xe tay ga</option>
                            <option value="Xe số">Xe số</option>
                            <option value="Xe côn tay">Xe côn tay</option>
                        </select>
                        <label for="LoaiXe">Loại Xe</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="PhanKhuc" id="PhanKhuc" class="form-control" required>
                            <option value="">Chọn phân khúc</option>
                            <option value="50cc">50cc</option>
                            <option value="110cc">110cc</option>
                            <option value="125cc">125cc</option>
                            <option value="150cc">150cc</option>
                            <option value="250cc">250cc</option>
                            <option value="500cc">500cc</option>
                            <option value="1000cc">1000cc</option>
                        </select>
                        <label for="PhanKhuc">Phân khúc</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="BienSoXe" id="BienSoXe" class="form-control" placeholder="Biển số xe" required>
                        <label for="BienSoXe">Biển số xe</label>
                    </div>

                    <!-- Thêm 2 trường mới ở đây -->
                    <div class="form-floating mb-3">
                        <input type="text" name="SoKhung" id="SoKhung" class="form-control" placeholder="Số khung">
                        <label for="SoKhung">Số khung (Không bắt buộc)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="SoMay" id="SoMay" class="form-control" placeholder="Số máy">
                        <label for="SoMay">Số máy (Không bắt buộc)</label>
                    </div>
                    <!-- Hết 2 trường mới -->

                    <div class="mb-3">
                        <label for="HinhAnhMatTruocXe" class="form-label text-white">Hình ảnh mặt trước xe</label>
                        <input type="file" name="HinhAnhMatTruocXe" id="HinhAnhMatTruocXe" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="HinhAnhMatSauXe" class="form-label text-white">Hình ảnh mặt sau xe</label>
                        <input type="file" name="HinhAnhMatSauXe" id="HinhAnhMatSauXe" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" name="add_bike" class="form-control">Thêm xe</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('addBikeForm').addEventListener('submit', function(event) {
    var sokhung = document.getElementById('SoKhung').value.trim();
    var somay = document.getElementById('SoMay').value.trim();
    if (sokhung.length > 0 || somay.length > 0) {
        var ok = confirm('Bạn có cam kết thông tin cung cấp về số khung/số máy là hợp lệ không?');
        if (!ok) {
            event.preventDefault();
            document.getElementById('SoKhung').focus();
        }
    }
});
</script>