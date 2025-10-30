<?php
	
	// Lấy thông tin từ FORM
	$MaMonAn = $_POST['MaMonAn'];
	$TenMonAn = $_POST['TenMonAn'];
	$Gia = $_POST['Gia'];
	$SoLuong = $_POST['SoLuong'];
	
	// Kiểm tra
	if(trim($TenMonAn) == "")
		ThongBaoLoi("Tên món ăn không được bỏ trống!");
	elseif (trim($Gia) == "") 
		ThongBaoLoi("Giá món ăn không được bỏ trống!");
	elseif (trim($SoLuong) == "") 
		ThongBaoLoi("Chưa cập nhật số lượng món ăn!");
	else
	{
		//Lưu tập tin upload vào thư mục hinhanh
		$target_path = "images/";
		$target_path = $target_path . basename($_FILES['HinhAnh']['name']);
		// di chuyển hình ảnh vào thư mục
		move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target_path);
		$sql = "UPDATE `danhsach` SET `TenMonAn` = '$TenMonAn', `Gia` = '$Gia', `SoLuong` = '$SoLuong', `AnhMonAn` = '$target_path' WHERE `MaMonAn` = '$MaMonAn'";
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
			exit();
		}
		else
		{
			header("Location: index.php?do=dsmonan");
		}
	}
?>