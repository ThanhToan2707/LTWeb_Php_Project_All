<?php
// mua_ngay_xuly.php — xử lý mua ngay, cập nhật stock, thông báo, reload dsmonan
if (session_id()==='') session_start();
require 'cauhinh.php';

// Chỉ POST
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    header('Location: index.php?do=dsmonan_khachhang&id='.$_SESSION['MaND']);
    exit;
}

$maMon  = isset($_POST['MaMonAn'])   ? intval($_POST['MaMonAn'])   : 0;
$qty    = isset($_POST['SoLuongMua'])? intval($_POST['SoLuongMua']) : 0;

// Lấy tồn kho
$stmt = $connect->prepare("SELECT SoLuong FROM danhsach WHERE MaMonAn=?");
$stmt->bind_param("i",$maMon);
$stmt->execute();
$stmt->bind_result($stock);
if (!$stmt->fetch()) {
    $stmt->close();
    header('Location: index.php?do=dsmonan_khachhang&id='.$_SESSION['MaND']);
    exit;
}
$stmt->close();

// Kiểm tra số lượng
if ($qty<1 || $qty>$stock) {
    echo "<script>alert('Số lượng mua không hợp lệ. Tồn kho: {$stock}');history.back();</script>";
    exit;
}

// Cập nhật lại stock
$stmt2 = $connect->prepare("UPDATE danhsach SET SoLuong = SoLuong - ? WHERE MaMonAn = ?");
$stmt2->bind_param("ii",$qty,$maMon);
$stmt2->execute();
$stmt2->close();

// Thông báo thành công và reload danh sách món
echo "<script>
        alert('Mua hàng thành công!');
        window.location='index.php?do=dsmonan_khachhang&id={$_SESSION['MaND']}';
      </script>";
exit;
?>
