<?php
// giohang_mua.php — Trang chọn số lượng mua và tự động tính thành tiền
if (session_id() === '') session_start();
require 'cauhinh.php';

// 1. Lấy MaGio và MaND từ GET, nếu không hợp lệ thì redirect về giỏ
$maGio = isset($_GET['MaGio']) ? intval($_GET['MaGio']) : 0;
$maND  = isset($_GET['MaND'])  ? intval($_GET['MaND'])  : 0;
if ($maGio <= 0 || $maND <= 0) {
    header('Location: index.php?do=giohang_xem&id='.$maND);
    exit;
}

// 2. Lấy chi tiết bản ghi trong bảng giohang
$stmt = $connect->prepare("SELECT TenMon, Gia, SoLuong FROM giohang WHERE MaGio = ? AND MaNguoiDung = ?");
$stmt->bind_param("ii", $maGio, $maND);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Nếu không tìm thấy thì quay về giỏ
if (!$item) {
    header('Location: index.php?do=giohang_xem&id='.$maND);
    exit;
}

// Lấy sẵn giá (số) để JS tính
$unitPrice = floatval($item['Gia']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Mua hàng: <?php echo htmlspecialchars($item['TenMon'], ENT_QUOTES, 'UTF-8'); ?></title>
  <style>
    body { background: #ffeeda; font-family: Arial, sans-serif; }
    .buy-form {
      max-width: 600px; margin: 40px auto; padding: 30px;
      background: #fff; border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .buy-form h3 {
      text-align: center; color: #e93e00;
      font-size: 2rem; margin-bottom: 20px;
    }
    .form-row {
      display: flex; align-items: center; margin-bottom: 15px;
    }
    .form-row label {
      flex: 0 0 200px; font-size: 1.1rem; color: #333;
    }
    .form-row input {
      flex: 1; padding: 8px 10px; font-size: 1.05rem;
      border: 1px solid #ccc; border-radius: 4px;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    }
    .form-row input[readonly] {
      background: #f9f9f9;
    }
    .submit-btn {
      display: block; width:180px; margin: 20px auto 0;
      padding:10px 0; font-size:1.1rem;
      background:#e93e00; color:#fff; border:none; border-radius:5px;
      cursor:pointer; transition: background .2s;
    }
    .submit-btn:hover { background:#cf2e00; }
  </style>
</head>
<body>

  <div class="buy-form">
    <h3>Mua hàng: <?php echo htmlspecialchars($item['TenMon'], ENT_QUOTES, 'UTF-8'); ?></h3>

    <form action="index.php?do=giohang_mua_xuly" method="post">
      <input type="hidden" name="MaGio" value="<?php echo $maGio; ?>">
      <input type="hidden" name="MaND"  value="<?php echo $maND; ?>">

      <div class="form-row">
        <label>Giá đơn vị (₫):</label>
        <input
          type="text"
          id="DonGia"
          value="<?php echo number_format($unitPrice); ?>"
          readonly
        >
      </div>

      <div class="form-row">
        <label>Số có trong giỏ:</label>
        <input
          type="text"
          value="<?php echo intval($item['SoLuong']); ?>"
          readonly
        >
      </div>

      <div class="form-row">
        <label>Số muốn mua:</label>
        <input
          type="number"
          id="SoLuongMua"
          name="SoLuongMua"
          min="1"
          max="<?php echo intval($item['SoLuong']); ?>"
          value="1"
          required
        >
      </div>

      <div class="form-row">
        <label>Thành tiền (₫):</label>
        <input
          type="text"
          id="ThanhTien"
          readonly
        >
      </div>

      <button type="submit" class="submit-btn">Xác nhận thanh toán</button>
    </form>
  </div>

  <script>
    // Lấy giá đơn vị và input số lượng
    const unitPrice = <?php echo json_encode($unitPrice, JSON_NUMERIC_CHECK); ?>;
    const qtyInput  = document.getElementById('SoLuongMua');
    const totalEl   = document.getElementById('ThanhTien');

    function updateTotal() {
      const qty = parseInt(qtyInput.value) || 0;
      const total = unitPrice * qty;
      // Format theo chuẩn VN với phân ngàn và ký tự ₫
      totalEl.value = total.toLocaleString('vi-VN') + ' ₫';
    }

    // Cập nhật ngay khi load và khi thay đổi số lượng
    qtyInput.addEventListener('input', updateTotal);
    window.addEventListener('DOMContentLoaded', updateTotal);
  </script>

</body>
</html>
