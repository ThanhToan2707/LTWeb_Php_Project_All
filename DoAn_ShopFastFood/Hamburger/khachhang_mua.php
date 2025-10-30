<script>
    // PHP
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
    // PHP
    var gia = <?php echo $dong['Gia']; ?>;
    function TinhTien() {
        // Lấy giá trị số lượng từ ô nhập liệu
        var soLuong = document.getElementsByName("SoLuongMua")[0].value;

        // Kiểm tra xem giá trị số lượng có phải là số không
        if (!isNaN(soLuong)) {
            // Tính thành tiền và gán giá trị cho ô Thành Tiền
            var thanhTien = soLuong * gia;
            document.getElementById("ThanhTien").value = thanhTien;
        } else {
            alert("Vui lòng nhập số lượng là một số hợp lệ.");
        }
    }
</script>

<h3>Mua hàng</h3>
<form style="font-weight: bold; margin-left: 120px;" action="index.php?do=khachhang_mua_xuly" method="post">
    <table class="Form">
        <input type="hidden" name="MaMonAn" value="<?php echo $dong['MaMonAn']; ?>" />
		<tr>
			<td>Tên Món ăn:</td>
			<td><input type="text" value="<?php echo $dong['TenMonAn'] ?>" name="TenMonAn" disabled="true"/></td>
		</tr>
		<tr>
			<td><label for="SoLuongMua">Số lượng:</label></td>
			<td><input type="number" name="SoLuongMua" min="1"></td>
		</tr>
        
        <tr>
			<td><label for="ThanhTien">Thành Tiền(VNĐ):</label></td>
			<td>
                <input type="number" id="ThanhTien" name="ThanhTien" disabled='true'>
                <button type="button" onclick="TinhTien()">Tính Tiền</button>
            </td>
		</tr>
	</table>
	
	<input type="submit" value="Xác Nhận thanh toán" />
</form>

