<section class="membership-section section-padding" id="section_profile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mx-auto mb-lg-5 mb-4">
                <h2><span>Thông tin</span> xe máy</h2>
            </div>
            <div class="col-lg-6 col-12 mx-auto">
                <form action="./controller/bikeprofile_controller.php" method="POST" class="custom-form membership-form shadow-lg" role="form" enctype="multipart/form-data">
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