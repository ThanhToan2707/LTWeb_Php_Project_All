<?php
// Kiểm tra xem biểu mẫu đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
	$maNguoiDung = $_POST['MaNguoiDung'];
	$MatKhauCu = $_POST['MatKhauCu'];
    $newMatKhau = $_POST['MatKhauMoi'];
	$xnmk = $_POST['XacNhanMatKhauMoi'];
	if ($newMatKhau != $xnmk) {
		ThongBaoLoi("Xác nhận mật khẩu không đúng!");
		exit();
	}

    // Cập nhật dữ liệu trong cơ sở dữ liệu
    $updateSql = "UPDATE `nguoidung` SET MatKhau = '$newMatKhau' WHERE MaNguoiDung = '$maNguoiDung'";

    if ($connect->query($updateSql) === TRUE) {
        echo "<h3>Cập nhật Mật Khẩu thành công.</h3>";
    } else {
        echo "<h3>Lỗi khi cập nhật Mật Khẩu: " . $connect->error . "</h3>";
    }
}
?>
