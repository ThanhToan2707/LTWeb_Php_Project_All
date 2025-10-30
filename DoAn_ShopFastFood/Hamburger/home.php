<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Food</title>
</head>

<body>
    <table class="DanhSach" border="0" cellspacing="0" width="590" align="center" valign="top">
        <tr>
            <h3> Ưu đãi giảm 50%. Hãy nhấn nút mua ngay</h3>
        </tr>
        
        <?php
        $sql = "SELECT * FROM `danhsach` WHERE 1";
        $danhsach = $connect->query($sql);
        ?>
        <!-- hiển thị các món ăn có sẵn trong database -->
        <?php
        $count = 0;
        while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {
            if ($count % 2 == 0) {
                echo "<tr style='text-align: center' bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
            }
            echo "<td>";
            echo "<img style='display:block; margin: 0 auto;' src='" . $dong["AnhMonAn"] . "' width='100' height='100'><br>";
            echo $dong["TenMonAn"] . "<br>";
            echo "<p style='color: red; text-decoration: line-through; margin: 0;'>".( $dong['Gia'] * 2 ). "</p> Giá khuyến mãi: " . $dong["Gia"];
            echo "<br><a title='mua hàng' href='index.php?do=dangnhap' onclick='return confirm(\"vui lòng đăng nhập để mua món ăn " . $dong['TenMonAn'] . " này\")'><span style='color: red;'>Mua Ngay</span></a>";
            echo "</td>";

            if ($count % 2 == 1) {
                echo "</tr>";
            }
            $count++;
        }
        ?>
        <!--  -->
    </table>

</body>

</html>
