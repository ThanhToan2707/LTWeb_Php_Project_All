<?php
// hotro_edit_xuly.php — Xử lý cập nhật trạng thái hỗ trợ

if (session_id() === '') session_start();

require 'cauhinh.php';

// 1. Chỉ admin, chỉ POST
if ($_SERVER['REQUEST_METHOD']!=='POST' || !isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan']!=0) {
    header('Location: index.php?do=dangnhap');
    exit;
}

// 2. Lấy và validate
$maHoTro = isset($_POST['MaHoTro']) ? intval($_POST['MaHoTro']) : 0;
$trangThai = isset($_POST['TrangThai']) ? trim($_POST['TrangThai']) : '';

// Sửa lại dòng này cho PHP cũ:
$valid = array('Chưa Xử Lý','Đang Xử Lý','Đã Hoàn Thành');
if ($maHoTro<=0 || !in_array($trangThai, $valid, true)) {
    ThongBaoLoi("Dữ liệu không hợp lệ.");
    exit;
}

// 3. Cập nhật
$stmt = $connect->prepare(
    "UPDATE hotro
     SET TrangThai = ?
     WHERE MaHoTro = ?"
);
$stmt->bind_param("si", $trangThai, $maHoTro);

if ($stmt->execute()) {
    ThongBao("Cập nhật trạng thái thành công!");
} else {
    ThongBaoLoi("Lỗi cập nhật: ".$stmt->error);
}
$stmt->close();
exit;