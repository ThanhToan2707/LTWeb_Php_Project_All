<?php
// mua_ngay.php — form mua ngay 1 món
if (session_id()==='') session_start();
require 'cauhinh.php';

// Bắt buộc login
if (!isset($_SESSION['MaND'])) {
    header('Location: index.php?do=dangnhap');
    exit;
}

$maMon = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($maMon <= 0) {
    header('Location: index.php?do=dsmonan_khachhang&id='.$_SESSION['MaND']);
    exit;
}

// Lấy dữ liệu món từ danhsach
$stmt = $connect->prepare("SELECT TenMonAn, Gia, SoLuong, AnhMonAn FROM danhsach WHERE MaMonAn = ?");
$stmt->bind_param("i", $maMon);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$item) {
    header('Location: index.php?do=dsmonan_khachhang&id='.$_SESSION['MaND']);
    exit;
}

$unitPrice = floatval($item['Gia']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Mua ngay: <?php echo htmlspecialchars($item['TenMonAn'],ENT_QUOTES); ?></title>
  <style>
    body{background:#ffeeda;font-family:Arial,sans-serif;}
    .buy-form{max-width:500px;margin:50px auto;padding:20px;background:#fff;border-radius:8px;box-shadow:0 3px 8px rgba(0,0,0,0.1);}
    .buy-form h3{color:#e93e00;text-align:center;margin-bottom:20px;}
    .row{display:flex;align-items:center;margin-bottom:12px;}
    .row label{flex:0 0 140px;font-weight:bold;}
    .row input{flex:1;padding:6px 8px;font-size:1rem;border:1px solid #ccc;border-radius:4px;}
    .row input[readonly]{background:#f9f9f9;}
    .submit-btn{display:block;margin:20px auto;padding:8px 20px;background:#e93e00;color:#fff;border:none;border-radius:5px;cursor:pointer;font-size:1rem;}
    .submit-btn:hover{background:#cf2e00;}
  </style>
</head>
<body>

<div class="buy-form">
  <h3>Mua ngay: <?php echo htmlspecialchars($item['TenMonAn'],ENT_QUOTES); ?></h3>
  <form action="index.php?do=mua_ngay_xuly" method="post">
    <input type="hidden" name="MaMonAn" value="<?php echo $maMon; ?>">

    <div class="row">
      <label>Đơn giá (₫):</label>
      <input type="text" id="DonGia" value="<?php echo number_format($unitPrice); ?>" readonly>
    </div>

    <div class="row">
      <label>Tồn kho:</label>
      <input type="text" id="TonKho" value="<?php echo intval($item['SoLuong']); ?>" readonly>
    </div>

    <div class="row">
      <label>Số lượng mua:</label>
      <input type="number" id="SoLuongMua" name="SoLuongMua"
             min="1" max="<?php echo intval($item['SoLuong']); ?>"
             value="1" required>
    </div>

    <div class="row">
      <label>Thành tiền:</label>
      <input type="text" id="ThanhTien" readonly>
    </div>

    <button type="submit" class="submit-btn">Mua hàng</button>
  </form>
</div>

<script>
  const price = <?php echo json_encode($unitPrice,JSON_NUMERIC_CHECK); ?>;
  const stock = <?php echo intval($item['SoLuong']); ?>;
  const qtyInput = document.getElementById('SoLuongMua');
  const totalEl  = document.getElementById('ThanhTien');

  function updateTotal(){
    let q = parseInt(qtyInput.value)||1;
    if(q<1) q=1;
    if(q>stock){
      alert('Chỉ còn '+stock+' sản phẩm trong kho.');
      q = stock;
    }
    qtyInput.value=q;
    totalEl.value = (price*q).toLocaleString('vi-VN')+' ₫';
  }
  qtyInput.addEventListener('input', updateTotal);
  window.addEventListener('DOMContentLoaded', updateTotal);
</script>

</body>
</html>
