<?php
// Nếu chưa có session, khởi tạo session để lưu thông tin người dùng
if (session_id() === '') {
    session_start();
}
?>
<!-- Liên kết file CSS để định dạng giao diện -->
<link rel="stylesheet" href="css/style_dangnhap.css">

<!-- Form đăng ký tài khoản -->
<form 
  style="background-color: #e93e00; padding:20px; border-radius:8px; width:360px; margin:50px auto;" 
  action="index.php?do=dangky_xuly" method="post" 
>
  <!-- Tiêu đề của form -->
  <h3 style="text-align: center; color: white;">Đăng Ký Tài Khoản</h3>

  <!-- Trường nhập Họ và Tên -->
  <input 
    type="text" name="HoVaTen" placeholder="Họ và Tên" required
    value="<?php echo isset($_POST['HoVaTen']) ? htmlspecialchars($_POST['HoVaTen'], ENT_QUOTES) : ''; ?>"
  />
  <br>

  <!-- Trường nhập Tên Đăng Nhập -->
  <input 
    type="text" name="TenDangNhap" placeholder="Tên Đăng Nhập" required
    value="<?php echo isset($_POST['TenDangNhap']) ? htmlspecialchars($_POST['TenDangNhap'], ENT_QUOTES) : ''; ?>"
  />
  <br>

  <!-- Trường nhập Mật Khẩu -->
  <input 
    type="password" name="MatKhau" placeholder="Mật Khẩu" required
  />
  <br>

  <!-- Trường nhập Xác Nhận Mật Khẩu -->
  <input 
    type="password" name="MatKhau2" placeholder="Xác Nhận Mật Khẩu" required
  />
  <br>

  <!-- Trường nhập Địa Chỉ Giao Hàng -->
  <input 
    type="text" name="DiaChi" placeholder="Địa Chỉ Giao Hàng" required
    value="<?php echo isset($_POST['DiaChi']) ? htmlspecialchars($_POST['DiaChi'], ENT_QUOTES) : ''; ?>"
  />
  <br>

  <!-- Nút submit để gửi form -->
  <input type="submit" value="Đăng Ký" />
</form>