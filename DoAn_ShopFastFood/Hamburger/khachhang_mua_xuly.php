<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $soLuongMua = isset($_POST['SoLuongMua']) ? $_POST['SoLuongMua'] : 0;
    $maMonAn = isset($_POST['MaMonAn']) ? $_POST['MaMonAn'] : '';

    $sql = "SELECT * FROM `danhsach` WHERE `MaMonAn` = $maMonAn";
    $danhsach = $connect->query($sql);

    if (!$danhsach) {
        die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
    }

    $dong = $danhsach->fetch_array(MYSQLI_ASSOC);

    if ($soLuongMua > $dong['SoLuong']) {
        echo "<script>alert('Số lượng nhập vào lớn hơn số lượng tồn kho của món ăn.');</script>";
    } else {
        $sql_update = "UPDATE `danhsach` SET `SoLuong` = `SoLuong` - $soLuongMua WHERE `MaMonAn` = '$maMonAn'";
        $danhsach_update = $connect->query($sql_update);

        if (!$danhsach_update) {
            die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
        } else {
            header("Location: index.php?do=dsmonan_khachhang");
        }
    }
}
?>
