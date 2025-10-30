<h3>Đăng Món Ăn Mới</h3>
<form enctype="multipart/form-data" action="index.php?do=monan_them_xuly" method="post" style=" margin-left: 200px; font-weight: bold">
	<table class="FormDangBaiViet">
		<!-- Tên Món Ăn -->
		<tr>
			<td>
				<span class="MyFormLabel">Tên Món:</span>
				<input type="text" name="TenMon" size = " 60" />
			</td>
		</tr>
		<!-- Giá Món Ăn -->
		<tr>
			<td>
				<span class="MyFormLabel" >Giá:</span>
				<input type="text" name="Gia" size = " 60" style=" margin-left: 42px;"/>
				<span class="MyFormLabel">VNĐ</span>
			</td>
		</tr>
		<tr>
			<td>
				<span class="MyFormLabel">SoLuong:</span>
				<input type="text" name="SoLuong" size = " 60" />
			</td>
		</tr>
		<tr>
			<td>Hình ảnh<input type="file" name="HinhAnh" style="margin-left: 8px;"></td>
		</tr>
	</table>
	
	<input type="submit" value="Đăng món" />
</form>