<!-- Liên kết file CSS để định dạng giao diện -->
<link rel="stylesheet" href="css/style_dangnhap.css">

<!-- Script JavaScript để hiển thị/ẩn mật khẩu -->
<script>
    function hienThiMatKhau() {
        // Lấy phần tử input mật khẩu bằng tên
        var matKhau = document.getElementsByName('MatKhau')[0];

        // Kiểm tra kiểu của input và thay đổi giữa 'password' và 'text'
        if (matKhau.type === 'password') {
            matKhau.type = 'text'; // Hiển thị mật khẩu
        } else {
            matKhau.type = 'password'; // Ẩn mật khẩu
        }
    }
</script>

<!-- Form đăng nhập -->
<form  
    style="margin-top: 170px; margin-left: 345px; margin-bottom: -100px; background-color: #e93e00;" 
    class="form-container" 
    action="index.php?do=dangnhap_xuly" 
    method="post"
>
    <!-- Tiêu đề của form -->
    <h3 style="text-align: center; color: white;">Đăng nhập</h3>

    <!-- Trường nhập Tên Đăng Nhập -->
    <input 
        type="text" id="TenDangNhap" name="TenDangNhap" placeholder="Tên Đăng Nhập" required
    >
    <br>

    <!-- Trường nhập Mật Khẩu -->
    <input 
        type="password" id="MatKhau" name="MatKhau" placeholder="Mật khẩu" required
    >
    <br>

    <!-- Nút hiển thị mật khẩu và nút đăng nhập -->
    <div style="margin-left: 120px">
        <!-- Nút hiển thị mật khẩu -->
        <input 
            style="margin-top: 15px;" 
            type="button" 
            value="Hiển thị mật khẩu" 
            onclick="hienThiMatKhau()" 
        />
        <!-- Nút submit để gửi form -->
        <input 
            type="submit" 
            value="Đăng nhập"
        >
    </div>
</form>