<?php
	$sql = "SELECT * FROM `danhsach` WHERE 1";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
?>
<h3>Danh sách món ăn</h3>
<table class="DanhSach">
	<tr>
		<th width="15%">Mã Món Ăn</th>
		<th width="15%">Tên Món Ăn</th>
		<th width="15%">Giá(VNĐ)</th>
		<th width="35%">Hình Ảnh</th>
		<th width="20%" colspan="2">Hành động</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {		
			echo "<tr style='text-align: center' bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td>" . $dong["MaMonAn"] . "</td>";
				echo "<td>" . $dong["TenMonAn"] . "</td>";
				echo "<td>" . $dong["Gia"] . "</td>";
				// Thêm cột hình ảnh
				echo "<td><img style='display:block; margin: 0 auto;' src='" . $dong["AnhMonAn"] . "'width='100' height='100'></td>";
				echo "<td align='center'><a href='index.php?do=dsmonan_sua&id=" . $dong["MaMonAn"] . "'><img src='images/edit.png' /></a></td>";
				echo "<td align='center'><a href='index.php?do=dsmonan_xoa&id=" . $dong["MaMonAn"] . "' onclick='return confirm(\"Bạn có muốn xóa món ăn " . $dong['TenMonAn'] . " không?\")'><img src='images/delete.png' /></a></td>";
			echo "</tr>";
		}
	?>
</table>
<button style=" float: right; margin-right: 15px; margin-top: 15px;" onclick="window.location.href='index.php?do=monan_them'">Thêm món ăn mới</button>
</form>