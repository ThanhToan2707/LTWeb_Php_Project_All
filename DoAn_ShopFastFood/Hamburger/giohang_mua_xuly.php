<?php
// 1. Khởi session & kết nối DB
if (session_id() === '') session_start();
require 'cauhinh.php';

// 2. Chỉ xử lý POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?do=giohang_xem&id=' . intval($_POST['MaND']));
    exit;
}

// 3. Lấy dữ liệu
$maGio      = isset($_POST['MaGio'])      ? intval($_POST['MaGio'])      : 0;
$maND       = isset($_POST['MaND'])       ? intval($_POST['MaND'])       : 0;
$soLuongMua = isset($_POST['SoLuongMua']) ? intval($_POST['SoLuongMua']) : 0;

// 4. Kiểm tra hợp lệ
if ($maGio <= 0 || $maND <= 0 || $soLuongMua <= 0) {
    header('Location: index.php?do=giohang_xem&id=' . $maND);
    exit;
}

// 5. Lấy lại số lượng trong giỏ còn bao nhiêu
$stmt = $connect->prepare(
    "SELECT SoLuong FROM giohang WHERE MaGio = ? AND MaNguoiDung = ?"
);
$stmt->bind_param("ii", $maGio, $maND);
$stmt->execute();
$stmt->bind_result($soLuongTrongGio);
if (!$stmt->fetch()) {
    // Không tìm thấy món này
    $stmt->close();
    header('Location: index.php?do=giohang_xem&id=' . $maND);
    exit;
}
$stmt->close();

// 6. Nếu người dùng chọn mua quá số lượng trong giỏ
if ($soLuongMua > $soLuongTrongGio) {
    echo "<script>alert('Số lượng mua không được vượt quá {$soLuongTrongGio}!');</script>";
    header('Refresh:0; url=index.php?do=giohang_mua&MaGio='.$maGio.'&MaND='.$maND);
    exit;
}

// 7. Tính số lượng còn lại
$soLuongCon = $soLuongTrongGio - $soLuongMua;

// 8. Cập nhật giỏ: nếu còn >0 thì UPDATE, ngược lại DELETE
if ($soLuongCon > 0) {
    $upd = $connect->prepare(
        "UPDATE giohang SET SoLuong = ? WHERE MaGio = ? AND MaNguoiDung = ?"
    );
    $upd->bind_param("iii", $soLuongCon, $maGio, $maND);
    $upd->execute();
    $upd->close();
} else {
    $del = $connect->prepare(
        "DELETE FROM giohang WHERE MaGio = ? AND MaNguoiDung = ?"
    );
    $del->bind_param("ii", $maGio, $maND);
    $del->execute();
    $del->close();
}

// 9. Thông báo mua hàng thành công
echo "<script>alert('Mua hàng thành công!');</script>";

// 10. Kiểm tra còn món trong giỏ hay không
$stmt2 = $connect->prepare(
    "SELECT COUNT(*) FROM giohang WHERE MaNguoiDung = ?"
);
$stmt2->bind_param("i", $maND);
$stmt2->execute();
$stmt2->bind_result($cnt);
$stmt2->fetch();
$stmt2->close();

// 11. Redirect phù hợp
if ($cnt > 0) {
    // Vẫn còn món → trở lại giỏ
    header("Refresh:0; url=index.php?do=giohang_xem&id={$maND}");
} else {
    // Hết rồi → về trang danh sách món cho khách
    header("Refresh:0; url=index.php?do=dsmonan_khachhang&id={$maND}");
}
exit;
?>
