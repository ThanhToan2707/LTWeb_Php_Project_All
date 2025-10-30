<?php
// donhang_khachhang.php — Hiển thị các đơn hàng của khách

if (session_id()==='') session_start();
require 'cauhinh.php';

// Kiểm tra login
$maND = isset($_GET['id']) 
      ? intval($_GET['id'])
      : (isset($_SESSION['MaND'])?$_SESSION['MaND']:0);
if ($maND<=0) {
    header('Location:index.php?do=dangnhap');
    exit;
}

// Truy vấn đơn hàng
$stmt = $connect->prepare(
  "SELECT MaDonHang, NgayDatHang, TrangThai, TongTien
   FROM donhang
   WHERE MaNguoiDung = ?
   ORDER BY NgayDatHang DESC"
);
$stmt->bind_param("i",$maND);
$stmt->execute();
$orders = $stmt->get_result();
?>
<style>
.order-list {max-width:800px; margin:40px auto; font-family:Arial;}
.order-list h2 {text-align:center;color:#e93e00;}
.order-list table{width:100%;border-collapse:collapse;margin-top:20px;}
.order-list th,td{padding:8px 6px;text-align:center;border:1px solid #ddd;}
.order-list th{background:#f5f5f5;}
.order-list tr:hover td{background:#fff0e5;}
.view-detail{color:#e93e00;text-decoration:none;font-weight:bold;}
</style>

<div class="order-list">
  <h2>Đơn hàng của tôi</h2>
  <?php if($orders->num_rows===0): ?>
    <p style="text-align:center;color:#c00;">Bạn chưa có đơn hàng nào.</p>
  <?php else: ?>
    <table>
      <tr>
        <th>Mã Đơn</th>
        <th>Ngày đặt</th>
        <th>Trạng thái</th>
        <th>Tổng tiền</th>
        <th>Chi tiết</th>
      </tr>
      <?php while($o=$orders->fetch_assoc()): ?>
      <tr>
        <td><?php echo $o['MaDonHang']; ?></td>
        <td><?php echo $o['NgayDatHang']; ?></td>
        <td><?php echo $o['TrangThai']; ?></td>
        <td><?php echo number_format($o['TongTien']); ?>₫</td>
        <td>
          <a href="index.php?do=donhang_chitiet&madon=<?php echo $o['MaDonHang']; ?>&id=<?php echo $maND; ?>"
             class="view-detail">Xem</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>
</div>
