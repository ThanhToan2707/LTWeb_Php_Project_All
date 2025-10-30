<?php
session_start();
require 'cauhinh.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?do=dsmonan_khachhang&id='.$_SESSION['MaND']);
    exit;
}

$maND   = intval($_SESSION['MaND']);
$maMon  = intval($_POST['MaMonAn']);
$soMua  = intval($_POST['SoLuongMua']);

// Lấy thông tin món để check tồn kho và lấy ảnh, tên, giá
$stmt = $connect->prepare("SELECT TenMonAn, Gia, AnhMonAn, SoLuong FROM danhsach WHERE MaMonAn = ?");
$stmt->bind_param("i", $maMon);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row || $soMua < 1 || $soMua > $row['SoLuong']) {
    echo "<script>alert('Số lượng không hợp lệ.');history.back();</script>";
    exit;
}

// Kiểm tra món đã có trong giỏ chưa
$stmt2 = $connect->prepare("SELECT SoLuong FROM giohang WHERE MaNguoiDung=? AND MaMonAn=?");
$stmt2->bind_param("ii", $maND, $maMon);
$stmt2->execute();
$stmt2->store_result();

if ($stmt2->num_rows > 0) {
    // cập nhật số lượng
    $stmt2->bind_result($oldQty);
    $stmt2->fetch();
    $newQty = $oldQty + $soMua;
    $stmt2->close();

    $upd = $connect->prepare(
      "UPDATE giohang SET SoLuong = ? WHERE MaNguoiDung=? AND MaMonAn=?"
    );
    $upd->bind_param("iii", $newQty, $maND, $maMon);
    $upd->execute();
    $upd->close();
} else {
    $stmt2->close();
    // thêm mới
    $ins = $connect->prepare(
      "INSERT INTO giohang
       (MaNguoiDung, MaMonAn, TenMon, SoLuong, Gia, Anh)
       VALUES (?, ?, ?, ?, ?, ?)"
    );
    $ten   = $row['TenMonAn'];
    $gia   = $row['Gia'];
    $anh   = $row['AnhMonAn'];
    $ins->bind_param("iisiss", $maND, $maMon, $ten, $soMua, $gia, $anh);
    $ins->execute();
    $ins->close();
}

// Thông báo và reload trang danh sách
echo "<script>
        alert('Thêm vào giỏ hàng thành công!');
        window.location = 'index.php?do=dsmonan_khachhang&id={$maND}';
      </script>";
exit;
?>
