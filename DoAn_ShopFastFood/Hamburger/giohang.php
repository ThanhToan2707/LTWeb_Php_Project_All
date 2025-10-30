<?php
    $mamonan = $_GET['id'];
    $mand = $_SESSION['MaND'];
    $tenmon = $_GET['ten'];
    $gia = $_GET['gia'];
    $soluong = $_GET['sl'];
    $anh = $_GET['anh'];

    // Kiểm tra xem món ăn đã tồn tại trong giỏ hàng của người dùng chưa
    $sql_check = "SELECT * FROM `giohang` WHERE MaNguoiDung = '$mand' AND MaMonAn = '$mamonan'";
    $result_check = $connect->query($sql_check);
    
    if ($result_check && $result_check->num_rows > 0) {
        // Nếu món đã tồn tại, cập nhật số lượng
        $row = $result_check->fetch_assoc();
        $new_quantity = $row['SoLuong'] + $soluong;

        $sql_update = "UPDATE giohang SET SoLuong = '$new_quantity' WHERE MaNguoiDung = '$mand' AND MaMonAn = '$mamonan'";
        $connect->query($sql_update);
    } else {
        // Nếu món chưa tồn tại, thêm mới vào giỏ hàng
        $sql_addgiohang = "INSERT INTO `giohang`(`MaNguoiDung`, `MaMonAn`, `TenMon`, `SoLuong`, `Gia`, `Anh`) VALUES
                        ('$mand', '$mamonan', '$tenmon', '$soluong', '$gia', '$anh')";
        $connect->query($sql_addgiohang);
    }
?>

