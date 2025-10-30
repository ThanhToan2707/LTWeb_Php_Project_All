<h2>Đăng ký tài khoản</h2>
<form action="?mod=user&act=post-register" method="post">
    <div class="mb-3">
        <label for="fullname" class="form-label">Họ tên</label>
        <input type="text" class="form-control" name="HoTen" id="fullname">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" name="SoDienThoai" id="phone" maxlength="10" minlength="10">
    </div>
    <div class="mb-3">
        <label for="pass" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" name="MatKhau" id="pass">
    </div>
    <button type="submit" class="btn btn-primary">Đăng ký</button>

    <!-- Thong bao dang ky that bai -->
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $_SESSION['alert'] ?>
        </div>
        <?php unset($_SESSION['alert']); //hien thi 1 lan roi xoa di ?>
    <?php endif; ?>
</form>