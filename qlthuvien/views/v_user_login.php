<h2>Đăng nhập</h2>
<form action="?mod=user&act=post-login" method="post">
    <div class="mb-3">
        <label for="phone" class="form-label">Số điện thoại</label>
        <input type="text" class="form-control" name="SoDienThoai" id="phone">
    </div>
    <div class="mb-3">
        <label for="pass" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" name="MatKhau" id="pass">
    </div>
    <button type="submit" class="btn btn-primary">Đăng nhập</button>

    <!-- Thong bao login that bai -->
    <?php if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $_SESSION['alert'] ?>
        </div>
        <?php unset($_SESSION['alert']); //hien thi 1 lan roi xoa di ?>
    <?php endif; ?>

    <!-- Thong bao dang ky thanh cong -->
    <?php if (isset($_SESSION['alert2'])): ?>
        <div class="alert alert-success mt-3" role="alert">
            <?= $_SESSION['alert2'] ?>
        </div>
        <?php unset($_SESSION['alert2']); //hien thi 1 lan roi xoa di ?>
    <?php endif; ?>
</form>