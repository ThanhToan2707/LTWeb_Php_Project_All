<?php
// hotro_edit.php — Form cập nhật trạng thái hỗ trợ

// 1. Khởi tạo session nếu chưa có
if (session_id() === '') {
    session_start();
}

// 2. Kết nối cơ sở dữ liệu
require 'cauhinh.php';

// 3. Chỉ cho admin truy cập
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 0) {
    header('Location: index.php?do=dangnhap');
    exit;
}

// 4. Lấy MaHoTro từ GET và kiểm tra hợp lệ
$maHoTro = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($maHoTro <= 0) {
    ThongBaoLoi("Yêu cầu không hợp lệ.");
    exit;
}

// 5. Lấy chi tiết yêu cầu hỗ trợ từ database
$stmt = $connect->prepare("
  SELECT h.MaHoTro, u.TenNguoiDung, h.TieuDe, h.NoiDung, h.NgayGui, h.TrangThai
  FROM hotro h
  JOIN nguoidung u ON h.MaND = u.MaNguoiDung
  WHERE h.MaHoTro = ?
");
$stmt->bind_param("i", $maHoTro);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) {
    ThongBaoLoi("Không tìm thấy yêu cầu.");
    exit;
}
$row = $res->fetch_assoc();
$stmt->close();
?>

<!-- Phần CSS làm đẹp giao diện form cập nhật -->
<style>
.edit-support-container {
  max-width: 440px;
  margin: 40px auto 0 auto;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 32px 32px 24px 32px;
  display: flex;
  flex-direction: column;
  align-items: stretch;
}
.edit-support-title {
  text-align: center;
  color: #e93e00;
  font-size: 1.4rem;
  margin-bottom: 24px;
  font-weight: bold;
  letter-spacing: 1px;
  text-shadow: 0 2px 8px #ffe0d0;
}
.edit-support-label {
  font-weight: 600;
  color: #e93e00;
  margin-bottom: 4px;
  display: block;
}
.edit-support-info {
  margin-bottom: 14px;
  color: #333;
  font-size: 1rem;
  background: #fff5ee;
  border-radius: 7px;
  padding: 8px 12px;
}
.edit-support-row {
  margin-bottom: 14px;
}
.edit-support-select, .edit-support-btn {
  width: 100%;
  padding: 10px 12px;
  border-radius: 7px;
  border: 1px solid #e0e0e0;
  font-size: 1rem;
  margin-top: 4px;
  box-sizing: border-box;
}
.edit-support-select:focus {
  border-color: #e93e00;
  outline: none;
}
.edit-support-btn {
  background: linear-gradient(90deg, #ff7e3f 0%, #e93e00 100%);
  color: #fff;
  font-weight: 600;
  border: none;
  margin-top: 12px;
  cursor: pointer;
  transition: background .15s, box-shadow .15s;
  box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}
.edit-support-btn:hover {
  background: #e93e00;
  box-shadow: 0 2px 8px #ffc2b3;
}
@media (max-width: 600px) {
  .edit-support-container { max-width: 98vw; padding: 10px; }
  .edit-support-title { font-size: 1.1rem; }
}
</style>

<!-- Form cập nhật trạng thái yêu cầu hỗ trợ -->
<div class="edit-support-container">
  <!-- Tiêu đề form -->
  <div class="edit-support-title">Cập nhật Yêu cầu #<?php echo $maHoTro; ?></div>
  
  <!-- Thông tin khách hàng -->
  <div class="edit-support-row">
    <span class="edit-support-label">Khách:</span>
    <div class="edit-support-info"><?php echo htmlspecialchars($row['TenNguoiDung']); ?></div>
  </div>
  
  <!-- Tiêu đề yêu cầu -->
  <div class="edit-support-row">
    <span class="edit-support-label">Tiêu Đề:</span>
    <div class="edit-support-info"><?php echo htmlspecialchars($row['TieuDe']); ?></div>
  </div>
  
  <!-- Mô tả yêu cầu -->
  <div class="edit-support-row">
    <span class="edit-support-label">Mô tả:</span>
    <div class="edit-support-info"><?php echo nl2br(htmlspecialchars($row['NoiDung'])); ?></div>
  </div>
  
  <!-- Thời gian gửi -->
  <div class="edit-support-row">
    <span class="edit-support-label">Gửi lúc:</span>
    <div class="edit-support-info"><?php echo $row['NgayGui']; ?></div>
  </div>
  
  <!-- Form cập nhật trạng thái -->
  <form method="post" action="index.php?do=hotro_edit_xuly">
    <!-- Ẩn mã hỗ trợ để gửi đi -->
    <input type="hidden" name="MaHoTro" value="<?php echo $maHoTro; ?>">
    <div class="edit-support-row">
      <span class="edit-support-label">Trạng Thái:</span>
      <select name="TrangThai" class="edit-support-select" required>
        <?php 
          // Danh sách trạng thái
          $options = array('Chưa Xử Lý', 'Đang Xử Lý', 'Đã Hoàn Thành');
          foreach ($options as $opt):
        ?>
          <option value="<?php echo $opt; ?>" <?php if ($row['TrangThai']==$opt) echo 'selected'; ?>>
            <?php echo $opt; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <!-- Nút cập nhật -->
    <button type="submit" class="edit-support-btn">Cập nhật</button>
  </form>
</div>