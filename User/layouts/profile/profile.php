<section class="membership-section section-padding" id="section_profile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mx-auto mb-lg-5 mb-4">
                <h2><span>Thông tin</span> tài khoản</h2>
            </div>

            <div class="col-lg-6 col-12 mx-auto">
                <form action="./controller/user_controller.php" method="POST" class="custom-form membership-form shadow-lg" role="form">
                    <input type="hidden" name="update" value="1">
                    <div class="form-floating mb-3">
                        <input type="text" name="TenKH" id="TenKH" class="form-control" placeholder="Tên Khách Hàng" required value="<?php echo htmlspecialchars($user['TenKH']); ?>">
                        <label for="TenKH">Tên Khách Hàng</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="SDT" id="SDT" class="form-control" placeholder="Số điện thoại" required value="<?php echo htmlspecialchars($user['SDT']); ?>">
                        <label for="SDT">Số điện thoại</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" name="Email" id="Email" class="form-control" placeholder="Email" required value="<?php echo htmlspecialchars($user['Email']); ?>">
                        <label for="Email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="DiaChi" id="DiaChi" class="form-control" placeholder="Địa chỉ" value="<?php echo htmlspecialchars($user['DiaChi']); ?>">
                        <label for="DiaChi">Địa chỉ</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="MatKhau" id="MatKhau" class="form-control" placeholder="Mật khẩu" value="">
                        <label for="MatKhau">Mật khẩu (để trống nếu không đổi)</label>
                    </div>

                    <button type="submit" name="update" class="form-control">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</section>