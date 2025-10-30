<?php
// hotro_xuly.php — Xử lý form hỗ trợ khách hàng

// 1. Khởi session
if (session_id() === '') {
    session_start();
}

// 2. Chỉ cho phép POST & phải login
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['MaND'])) {
    header('Location: index.php?do=dangnhap');
    exit;
}

// 3. Kết nối database
require 'cauhinh.php';

// 4. Lấy dữ liệu đã POST và sanitize
$maND   = intval($_POST['MaND']);
$tieuDe = isset($_POST['TieuDe']) ? trim($_POST['TieuDe']) : '';
$noiDung= isset($_POST['NoiDung'])? trim($_POST['NoiDung']): '';

// 5. Kiểm tra hợp lệ
if ($tieuDe === '' || $noiDung === '') {
    ThongBaoLoi("Tiêu đề và nội dung không được để trống!");
    exit;
}

// 6. Chuẩn bị INSERT; NgayGui dồn hàm NOW(), TrangThai mặc định 'Chưa Xử Lý'
$sql = "
  INSERT INTO hotro
    (MaND, TieuDe, NoiDung, NgayGui)
  VALUES
    (?, ?, ?, NOW())
";
$stmt = $connect->prepare($sql);
if (!$stmt) {
    ThongBaoLoi("Lỗi chuẩn bị: " . $connect->error);
    exit;
}

// 7. Bind param & execute
$stmt->bind_param("iss", $maND, $tieuDe, $noiDung);
if ($stmt->execute()) {
    ThongBao("Gửi yêu cầu thành công! Chúng tôi sẽ liên hệ sớm.");
} else {
    ThongBaoLoi("Lỗi lưu yêu cầu: " . $stmt->error);
}
$stmt->close();
exit;
