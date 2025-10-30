<?php
// donhang_them_xuly.php — Xử lý khi khách “Thanh toán giỏ hàng”
// 1) Khởi session + connect DB
if (session_id()==='') session_start();
require 'cauhinh.php';

// 2) Lấy mã khách
if (!isset($_SESSION['MaND'])) {
    header('Location:index.php?do=dangnhap');
    exit;
}
$maND = intval($_SESSION['MaND']);

// 3) Lấy toàn bộ món trong giỏ
$stmt = $connect->prepare(
  "SELECT MaMonAn, TenMon, SoLuong, Gia, Anh
   FROM giohang
   WHERE MaNguoiDung = ?"
);
$stmt->bind_param("i",$maND);
$stmt->execute();
$cart = $stmt->get_result();
if ($cart->num_rows===0) {
    // giỏ rỗng → quay về danh sách
    header("Location:index.php?do=dsmonan_khachhang&id={$maND}");
    exit;
}

// 4) Tính tổng tiền
$tongTien = 0;
while($r = $cart->fetch_assoc()) {
    $tongTien += $r['Gia'] * $r['SoLuong'];
}
// reset con trỏ
$cart->data_seek(0);

// 5) Chèn vào donhang
//    NgayDatHang là TIMESTAMP DEFAULT CURRENT_TIMESTAMP
$ins = $connect->prepare(
  "INSERT INTO donhang (MaNguoiDung, TongTien)
   VALUES (?, ?)"
);
$ins->bind_param("id", $maND, $tongTien);
$ins->execute();

// 6) Lấy mã đơn mới
$maDon = $connect->insert_id;

// 7) Chèn chi tiết
$insCT = $connect->prepare(
  "INSERT INTO chitietdonhang
   (MaDonHang, MaMonAn, SoLuong, DonGia)
   VALUES (?,?,?,?)"
);
while($r = $cart->fetch_assoc()) {
    $insCT->bind_param(
      "iiid",
      $maDon,
      $r['MaMonAn'],
      $r['SoLuong'],
      $r['Gia']
    );
    $insCT->execute();
}
$insCT->close();

// 8) Xóa giỏ hàng
$del = $connect->prepare(
  "DELETE FROM giohang WHERE MaNguoiDung = ?"
);
$del->bind_param("i",$maND);
$del->execute();

// 9) Chuyển sang trang “đơn hàng của tôi”
header("Location:index.php?do=donhang_khachhang&id={$maND}");
exit;
?>
