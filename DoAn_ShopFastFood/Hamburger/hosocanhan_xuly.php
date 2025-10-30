<?php
if (session_id()=='') session_start();
require 'cauhinh.php';

if (!isset($_SESSION['MaND'])) {
    header('Location:index.php?do=dangnhap');
    exit;
}
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    header('Location:index.php?do=hosocanhan');
    exit;
}

// Lấy và trim dữ liệu
$ma     = intval($_SESSION['MaND']);
$ten    = trim($_POST['HoVaTen']);
$user   = trim($_POST['TenDangNhap']);
$pass   = trim($_POST['MatKhau']);
$pass2  = trim($_POST['MatKhau2']);
$diachi = trim($_POST['DiaChi']);

// Validation
if ($ten===''||$user===''||$diachi==='') {
    $_SESSION['error']='Họ tên, Tên đăng nhập và Địa chỉ không được để trống.';
    header('Location:index.php?do=hosocanhan'); exit;
}
if (($pass!==''||$pass2!=='') && $pass!==$pass2) {
    $_SESSION['error']='Mật khẩu và xác nhận mật khẩu không khớp.';
    header('Location:index.php?do=hosocanhan'); exit;
}

// Chuẩn bị UPDATE với MD5
if ($pass!=='') {
    $hash = md5($pass);
    $sql = "UPDATE nguoidung
            SET TenNguoiDung=?, TenDangNhap=?, MatKhau=?, DiaChi=?
            WHERE MaNguoiDung=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssi",$ten,$user,$hash,$diachi,$ma);
} else {
    $sql = "UPDATE nguoidung
            SET TenNguoiDung=?, TenDangNhap=?, DiaChi=?
            WHERE MaNguoiDung=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("sssi",$ten,$user,$diachi,$ma);
}

if ($stmt->execute()) {
    $_SESSION['HoTen']=$ten;
    $_SESSION['TenDangNhap']=$user;
    $_SESSION['success']='Cập nhật hồ sơ thành công.';
} else {
    $_SESSION['error']='Lỗi khi cập nhật: '.$stmt->error;
}
header('Location:index.php?do=hosocanhan');
exit;
?>
