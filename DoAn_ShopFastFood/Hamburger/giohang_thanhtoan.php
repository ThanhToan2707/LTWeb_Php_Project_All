<?php
// giohang_thanhtoan.php
// Xử lý “Thanh toán” 1 món trong giỏ: xóa record, alert, rồi redirect tùy còn món hay không.

// 1. Khởi session nếu chưa
if (session_id() === '') {
    session_start();
}

// 2. Kết nối database
require 'cauhinh.php';  // đã có $connect->set_charset("utf8")

// 3. Lấy input và kiểm tra
if (!isset($_GET['MaGio'], $_GET['MaND'])) {
    header('Location: index.php?do=giohang_xem&id=' . (isset($_GET['MaND'])?intval($_GET['MaND']):0));
    exit;
}
$maGio = intval($_GET['MaGio']);
$maND  = intval($_GET['MaND']);
if ($maGio <= 0 || $maND <= 0) {
    header('Location: index.php?do=giohang_xem&id='.$maND);
    exit;
}

// 4. Xóa món đã thanh toán (dùng MaGio – khóa chính trong giohang)
$stmt = $connect->prepare(
    "DELETE FROM giohang WHERE MaGio = ? AND MaNguoiDung = ?"
);
$stmt->bind_param("ii", $maGio, $maND);
$stmt->execute();
$stmt->close();

// 5. Thông báo thành công bằng JavaScript alert
echo "<script>alert('Thanh toán thành công!');</script>";

// 6. Đếm số món còn lại trong giỏ
$stmt2 = $connect->prepare(
    "SELECT COUNT(*) FROM giohang WHERE MaNguoiDung = ?"
);
$stmt2->bind_param("i", $maND);
$stmt2->execute();

// Thay vì dùng fetch_assoc()['cnt'], ta bind_result để lấy COUNT(*)
$stmt2->bind_result($cnt);
$stmt2->fetch();
$stmt2->close();

// 7. Redirect: nếu còn món → về lại giỏ; nếu hết → về danh sách món
if ($cnt > 0) {
    // Giỏ vẫn còn món
    header("Refresh:0; url=index.php?do=giohang_xem&id={$maND}");
} else {
    // Giỏ đã hết → chuyển sang trang danh sách món ăn
    header("Refresh:0; url=index.php?do=dsmonan_khachhang&id={$maND}");
}
exit;
?>
