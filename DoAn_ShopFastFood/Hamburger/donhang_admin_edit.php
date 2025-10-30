<?php
// donhang_admin_edit.php — Form chuyển trạng thái đơn hàng cho Admin

// 1. Bắt buộc phải là admin
if (session_id() === '') session_start();
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 0) {
    header('Location:index.php?do=dangnhap');
    exit;
}

require 'cauhinh.php';

// 2. Lấy mã đơn từ query string và validate
$maDon = isset($_GET['madon']) ? intval($_GET['madon']) : 0;
if ($maDon <= 0) {
    header('Location:index.php?do=donhang_admin');
    exit;
}

// 3. Lấy thông tin đơn hàng và tên khách
$stmt = $connect->prepare("
  SELECT d.MaDonHang, u.TenNguoiDung, d.TrangThai
  FROM donhang d
  JOIN nguoidung u ON d.MaNguoiDung = u.MaNguoiDung
  WHERE d.MaDonHang = ?
");
$stmt->bind_param("i", $maDon);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Nếu không có đơn → quay về danh sách
if (!$order) {
    header('Location:index.php?do=donhang_admin');
    exit;
}

// 4. Danh sách trạng thái cho select
$states = array(
  'Chưa Xử Lý',
  'Đang Xử Lý',
  'Đã Hoàn Thành'
);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chuyển trạng thái Đơn #<?php echo $maDon; ?></title>
  <style>
    /* Toàn trang */
    body {
      background-color: #f7f7f7;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    /* Khung form chính */
    .edit-container {
      max-width: 480px;
      margin: 40px auto;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    /* Header */
    .edit-header {
      background: #e93e00;
      color: #fff;
      padding: 16px 24px;
      text-align: center;
    }
    .edit-header h2 {
      margin: 0;
      font-size: 1.5rem;
    }
    /* Form body */
    .edit-form {
      padding: 24px;
    }
    .edit-form label {
      display: block;
      margin-top: 16px;
      margin-bottom: 6px;
      font-weight: bold;
      color: #333;
    }
    .edit-form .static-field {
      padding: 8px 12px;
      background: #f0f0f0;
      border-radius: 4px;
      color: #555;
    }
    .edit-form select {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
      background: #fff;
      outline: none;
    }
    .edit-form select:focus {
      border-color: #e93e00;
      box-shadow: 0 0 4px rgba(233,62,0,0.3);
    }
    /* Footer nút */
    .edit-actions {
      margin-top: 24px;
      text-align: center;
    }
    .edit-actions button,
    .edit-actions a {
      display: inline-block;
      padding: 10px 20px;
      margin: 0 8px;
      border-radius: 4px;
      font-size: 1rem;
      text-decoration: none;
      transition: background 0.2s;
    }
    .edit-actions button {
      background: #e93e00;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    .edit-actions button:hover {
      background: #cf2e00;
    }
    .edit-actions a {
      background: #ddd;
      color: #333;
    }
    .edit-actions a:hover {
      background: #ccc;
    }
  </style>
</head>
<body>

  <div class="edit-container">
    <!-- ===== Header ===== -->
    <div class="edit-header">
      <h2>Chuyển trạng thái Đơn #<?php echo $maDon; ?></h2>
    </div>

    <!-- ===== Form body ===== -->
    <form class="edit-form" action="index.php?do=donhang_admin_update" method="post">
      <!-- Giữ mã đơn để xử lý sau -->
      <input type="hidden" name="MaDonHang" value="<?php echo $maDon; ?>">

      <!-- Hiển thị tên khách hàng -->
      <label>Khách hàng</label>
      <div class="static-field">
        <?php echo htmlspecialchars($order['TenNguoiDung'], ENT_QUOTES); ?>
      </div>

      <!-- Chọn trạng thái mới -->
      <label>Trạng thái hiện tại</label>
      <select name="TrangThai">
        <?php foreach ($states as $st): ?>
          <option value="<?php echo $st; ?>"
            <?php if ($st === $order['TrangThai']) echo 'selected'; ?>>
            <?php echo $st; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Nút hành động -->
      <div class="edit-actions">
        <button type="submit">Cập nhật</button>
        <a href="index.php?do=donhang_admin">Hủy</a>
      </div>
    </form>
  </div>

</body>
</html>
