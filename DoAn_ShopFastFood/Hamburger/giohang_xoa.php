<?php
	$mamonan = $_GET['id'];
	$mand = $_GET['mand'];

	// Xóa thông tin món ăn trong giỏ hàng
	$sql_delete = "DELETE FROM giohang WHERE MaMonAn = '$mamonan' AND MaNguoiDung = '$mand'";
	$kiemtra_delete = $connect->query($sql_delete);
?>
