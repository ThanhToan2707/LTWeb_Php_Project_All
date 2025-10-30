<?php
	// Lấy thông tin từ FORM
	$TenMon = $_POST['TenMon'];
	$Gia = $_POST['Gia'];
	$SoLuong = $_POST['SoLuong'];
	
	// Kiểm tra
	if(trim($TenMon) == "")
		ThongBaoLoi("Tên Món không được bỏ trống!");
	elseif(trim($Gia) == "")
		ThongBaoLoi("Chưa Nêm Yết Giá!");
	elseif(trim($SoLuong) == "")
		ThongBaoLoi("Chưa cho biết số lượng thêm");
	else
	{
		//Lưu tập tin upload vào thư mục hinhanh
		$target_path = "images/";
		$target_path = $target_path . basename($_FILES['HinhAnh']['name']);
		if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target_path))
			echo "Tập tin " . basename($_FILES['HinhAnh']['name']) . " đã được upload.<br/>";
		else
			echo "Tập tin upload không thành công.<br/>";
		$sql = "INSERT INTO `danhsach`(`TenMonAn`, `Gia`, `SoLuong`, `AnhMonAn`)
				VALUES ('$TenMon', '$Gia', '$SoLuong', '$target_path')";
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . mysqli_connect_error());
			exit();
		}
		else
		{
			ThongBao("Đã thêm món ăn mới!");
		}
	}
?>