<?php
// donhang_admin_update.php — Xử lý cập nhật trạng thái đơn hàng (Admin)

// 1. Bắt buộc phải là admin
if (session_id() === '') {
    session_start();
}
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 0) {
    header('Location:index.php?do=dangnhap');
    exit;
}

// 2. Kết nối database
require 'cauhinh.php';

// 3. Chỉ xử lý POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:index.php?do=donhang_admin');
    exit;
}

// 4. Lấy dữ liệu
$maDon = isset($_POST['MaDonHang']) ? intval($_POST['MaDonHang']) : 0;
$trangthai = isset($_POST['TrangThai']) ? trim($_POST['TrangThai']) : '';

// 5. Các trạng thái hợp lệ
$allowed = array('Chưa Xử Lý', 'Đang Xử Lý', 'Đã Hoàn Thành');

// 6. Kiểm tra đầu vào
if ($maDon <= 0) {
    $msg = "Mã đơn hàng không hợp lệ.";
    $success = false;
} elseif (array_search($trangthai, $allowed) === false) {
    $msg = "Trạng thái không hợp lệ.";
    $success = false;
} else {
    // 7. Cập nhật vào bảng donhang
    $stmt = $connect->prepare(
        "UPDATE donhang 
         SET TrangThai = ? 
         WHERE MaDonHang = ?"
    );
    if (!$stmt) {
        $msg = 'Lỗi truy vấn: ' . $connect->error;
        $success = false;
    } else {
        $stmt->bind_param("si", $trangthai, $maDon);
        if ($stmt->execute()) {
            $msg = "Cập nhật trạng thái đơn hàng thành công!";
            $success = true;
        } else {
            $msg = "Cập nhật thất bại: " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật trạng thái đơn hàng</title>
    <meta http-equiv="refresh" content="2;url=index.php?do=donhang_admin">
    <style>
        body { background: #f8f8f8; font-family: Arial,sans-serif; }
        .noti-box {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 32px 24px;
            text-align: center;
        }
        .noti-success { color: #28a745; font-size: 1.2rem; font-weight: bold; }
        .noti-error { color: #e93e00; font-size: 1.1rem; font-weight: bold; }
        .noti-box small { display: block; margin-top: 18px; color: #888; }
    </style>
</head>
<body>
    <div class="noti-box">
        <?php if ($success): ?>
            <div class="noti-success"><?php echo $msg; ?></div>
        <?php else: ?>
            <div class="noti-error"><?php echo $msg; ?></div>
        <?php endif; ?>
        <small>Bạn sẽ được chuyển về trang quản lý đơn hàng sau 2 giây...</small>
        <small>Nếu không chuyển, <a href="index.php?do=donhang_admin">bấm vào đây</a>.</small>
    </div>
</body>
</html>