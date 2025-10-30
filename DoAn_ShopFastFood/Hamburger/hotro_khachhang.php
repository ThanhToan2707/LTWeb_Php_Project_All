<?php
// hotro_khachhang.php — Form gửi yêu cầu hỗ trợ khách hàng

// 1. Bắt đầu session
if (session_id() === '') session_start();

// 2. Chỉ cho khách đã login được vào trang này
if (!isset($_SESSION['MaND'])) {
    header('Location: index.php?do=dangnhap');
    exit;
}

// 3. Kết nối DB
require 'cauhinh.php';

// 4. Lấy MaND
$maND = $_SESSION['MaND'];
?>
<!-- ==== BẮT ĐẦU GIAO DIỆN HỖ TRỢ KHÁCH HÀNG ==== -->
<div class="support-container">
  <div class="support-header">
    <h2>Hỗ trợ khách hàng</h2>
  </div>
  <div class="support-body">
    <form method="post" action="index.php?do=hotro_xuly">

      <!-- MaND ẩn -->
      <input type="hidden" name="MaND" value="<?php echo $maND; ?>">

      <!-- Tiêu đề -->
      <div class="form-group">
        <label for="TieuDe">Tiêu đề <span class="required">*</span></label>
        <input
          type="text"
          id="TieuDe"
          name="TieuDe"
          class="form-control"
          required
          placeholder="Nhập vấn đề bạn cần hỗ trợ..."
        >
      </div>

      <!-- Nội dung -->
      <div class="form-group">
        <label for="NoiDung">Nội dung <span class="required">*</span></label>
        <textarea
          id="NoiDung"
          name="NoiDung"
          class="form-control"
          rows="5"
          required
          placeholder="Mô tả chi tiết vấn đề của bạn..."
        ></textarea>
      </div>

      <!-- Nút gửi -->
      <div class="form-group text-center">
        <button type="submit" class="btn-submit">Gửi yêu cầu</button>
      </div>

    </form>
  </div>
</div>

<!-- ===== BỔ SUNG style riêng cho hotro_khachhang ===== -->
<style>
/* Container chung */
.support-container {
  width: 100%; 
  max-width: 700px;
  margin: 40px auto;
  background: #fff7f0;
  border: 1px solid #e93e00;
  border-radius: 8px;
  overflow: hidden;
}
/* Header */
.support-header {
  background: #e93e00;
  padding: 16px;
  text-align: center;
}
.support-header h2 {
  margin: 0;
  color: #fff;
  font-size: 1.6rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}
/* Body */
.support-body {
  padding: 24px;
}
.form-group {
  margin-bottom: 18px;
}
.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 6px;
  color: #333;
}
.form-control {
  width: 100%;
  padding: 10px 12px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color .2s, box-shadow .2s;
}
.form-control:focus {
  outline: none;
  border-color: #e93e00;
  box-shadow: 0 0 4px rgba(233,62,0,0.3);
}
.required {
  color: #e93e00;
  margin-left: 2px;
}
/* Button */
.btn-submit {
  background: #e93e00;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 12px 28px;
  font-size: 1.1rem;
  cursor: pointer;
  transition: background .2s, transform .1s;
}
.btn-submit:hover {
  background: #cf2e00;
  transform: translateY(-2px);
}
/* Text-center helper */
.text-center {
  text-align: center;
}
</style>
