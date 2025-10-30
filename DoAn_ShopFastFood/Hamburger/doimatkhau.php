<!-- Liên kết file CSS để định dạng giao diện -->
<link rel="stylesheet" href="css/style_dangnhap.css">

<!-- Script JavaScript để hiển thị/ẩn mật khẩu -->
<script>
    function hienThiMatKhau() {
        // Lấy các phần tử input mật khẩu bằng tên
        var matKhauCu = document.getElementsByName('MatKhauCu')[0]; // Trường mật khẩu cũ
        var matKhauMoi = document.getElementsByName('MatKhauMoi')[0]; // Trường mật khẩu mới
        var xacNhanMatKhauMoi = document.getElementsByName('XacNhanMatKhauMoi')[0]; // Trường xác nhận mật khẩu mới

        // Kiểm tra kiểu của input và thay đổi giữa 'password' và 'text'
        if (matKhauCu.type === 'password') {
            matKhauCu.type = 'text'; // Hiển thị mật khẩu cũ
            matKhauMoi.type = 'text'; // Hiển thị mật khẩu mới
            xacNhanMatKhauMoi.type = 'text'; // Hiển thị xác nhận mật khẩu mới
        } else {
            matKhauCu.type = 'password'; // Ẩn mật khẩu cũ
            matKhauMoi.type = 'password'; // Ẩn mật khẩu mới
            xacNhanMatKhauMoi.type = 'password'; // Ẩn xác nhận mật khẩu mới
        }
    }
</script>

<!-- Form đổi mật khẩu -->
<form  
    style="margin-top: 180px; margin-left: 345px; margin-bottom: -100px;" 
    class="form-container" 
    action="index.php?do=doimatkhau_xuly" 
    method="post"
>
    <!-- Tiêu đề của form -->
    <h3 style="text-align: center;">Đổi Mật Khẩu</h3>

    <!-- Trường ẩn để lưu mã người dùng -->
    <input 
        type="hidden" 
        value="<?php echo $_SESSION['MaND']; ?>" 
        name="MaNguoiDung" 
    />

    <!-- Trường nhập mật khẩu cũ -->
    <input 
        type="password" 
        name="MatKhauCu" 
        placeholder="Mật Khẩu Cũ" 
    />
    <br>

    <!-- Trường nhập mật khẩu mới -->
    <input 
        type="password" 
        name="MatKhauMoi" 
        placeholder="Mật Khẩu Mới" 
    />
    <br>

    <!-- Trường nhập xác nhận mật khẩu mới -->
    <input 
        type="password" 
        name="XacNhanMatKhauMoi" 
        placeholder="Xác Nhận Mật Khẩu" 
    />

    <!-- Nút hiển thị mật khẩu và nút cập nhật -->
    <div style="display: inline-block;">
        <!-- Nút cập nhật mật khẩu -->
        <input 
            style="float: right;" 
            type="submit" 
            value="Cập nhật mật khẩu" 
        />
        <!-- Nút hiển thị mật khẩu -->
        <input 
            style="float: right; margin: 15px 10px 0 0;" 
            type="button" 
            value="Hiển thị mật khẩu" 
            onclick="hienThiMatKhau()" 
        />
    </div>
</form>