<?php
	// Lấy chủ đề cần sửa "đổ" vào form
	$sql = "SELECT * FROM `danhsach` WHERE MaMonAn = " . $_GET['id'];
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
?>
<h3>Sửa Món Ăn</h3>
<form style=" margin-left: 120px; font-weight: bold; background-color: white; width: 500px;" enctype="multipart/form-data" action="index.php?do=dsmonan_sua_xuly" method="post">
	<table class="Form">
		<input type="hidden" name="MaMonAn" value="<?php echo $dong['MaMonAn']; ?>" />
		<tr>
			<td>Tên món ăn:</td>
			<td><input type="text" name="TenMonAn" value="<?php echo $dong['TenMonAn']; ?>" /></td>
		</tr>
		<tr>
			<td>Giá:</td>
			<td><input type="text" name="Gia" value="<?php echo $dong['Gia']; ?>" /></td>
		</tr>
		<tr>
			<td>Số Lượng còn lại:</td>
			<td><input type="text" name="SoLuong" value="<?php echo $dong['SoLuong']; ?>" /></td>
		</tr>
		<tr>
			<td>Hình ảnh</td>
			<td><input type="file" name="HinhAnh"></td>
		</tr>
	</table>
	
	<input style="margin-left: 250px;" type="submit" value="Cập nhật" />
</form>