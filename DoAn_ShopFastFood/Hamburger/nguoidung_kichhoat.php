<?php
	if(isset($_GET['quyen']))
	{
		if ($_GET['quyen'] == 2) {
			$sql = "UPDATE `nguoidung` SET `QuyenHan` = 1 WHERE `MaNguoiDung` = " . $_GET['id'];
		} else {
			$sql = "UPDATE `nguoidung` SET `QuyenHan` = 0 WHERE `MaNguoiDung` = " . $_GET['id'];
		}
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
			exit();
		}
		
		if($danhsach)
			header("Location: index.php?do=nguoidung");
		else
			ThongBaoLoi(mysql_error());
	}
	else
	{
		header("Location: index.php?do=nguoidung");
	}
?>