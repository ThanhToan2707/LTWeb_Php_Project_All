<?php
// index.php — Trang chính điều phối toàn bộ ứng dụng

// 1. Khởi session nếu chưa có
if (session_id() === '') {
    session_start();
}

// 2. Kết nối cấu hình chung (DB, charset UTF-8)
include_once "cauhinh.php";

// 3. Thư viện hàm trợ giúp (ThongBao, ThongBaoLoi,…)
include_once "thuvien.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Bông Bán Hamburger</title>
    <!-- 4. CSS chung -->
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div id="TrangWeb">
        
        <!-- ===== Phần Đầu: Banner + Chào người dùng ===== -->
        <div id="PhanDau">    
            <?php
                if (isset($_SESSION['QuyenHan'], $_SESSION['HoTen'])) {
                    // 4a. Quản lý (QuyenHan = 0)
                    if ($_SESSION['QuyenHan'] == 0) {
                        echo str_repeat('<br>', 8);
                        echo "Quản Lý {$_SESSION['HoTen']} &nbsp;&nbsp;||&nbsp;&nbsp;";
                        echo '<a href="index.php?do=dangxuat">Đăng xuất</a>&nbsp;&nbsp;';
                    } else {
                        // 4b. Khách hàng
                        echo str_repeat('<br>', 8);
                        echo "Xin chào khách hàng {$_SESSION['HoTen']} &nbsp;&nbsp;||&nbsp;&nbsp;";
                        echo '<a href="index.php?do=dangxuat">Đăng xuất</a>&nbsp;&nbsp;';
                    }
                }
            ?>              
        </div>
        
        <!-- ===== Phần Giữa: Sidebar trái + Nội dung phải ===== -->
        <div id="PhanGiua">
            
            <!-- Sidebar bên trái -->
            <div id="BenTrai">
                <?php
                // 5) Menu chính
                if (!isset($_SESSION['QuyenHan'])) {
                    // 5a. Chưa login
                    echo '<h3>CLICK ME</h3>';
                    echo '<ul>';
                    echo '<li><a href="index.php?do=dangnhap">Đăng nhập</a></li>';
                    echo '</ul>';
                    echo '<ul>';
                    echo '<li><a href="index.php?do=dangky">Đăng ký</a></li>';
                    echo '</ul>';
                }
                elseif ($_SESSION['QuyenHan'] == 0) {
                    // 5b. Quản lý
    				echo '<h3>Quản lý</h3>';
    				echo '<ul>';
    				echo '<li><a href="index.php?do=monan_them">Đăng Món Ăn Mới</a></li>';
    				echo '<li><a href="index.php?do=dsmonan">Danh sách Món Hiện Tại</a></li>';
    				echo '<li><a href="index.php?do=nguoidung">Danh sách người dùng</a></li>';
    				echo '</ul>';

                    // Hỗ trợ (không khung đỏ, không ul/li)
    				echo '<h3>Đơn hàng</h3>';
					echo '<ul>';
    				echo '<a href="index.php?do=donhang_admin" style="color:#e93e00; font-weight:bold; text-decoration:none;">Quản lý Đơn hàng</a>';
					echo '</ul>';

    				// Hỗ trợ (không khung đỏ, không ul/li)
    				echo '<h3>Hỗ trợ</h3>';
					echo '<ul>';
    				echo '<a href="index.php?do=hotro_admin" style="color:#e93e00; font-weight:bold; text-decoration:none;">Yêu cầu hỗ trợ</a>';
					echo '</ul>';
                }
                else {
                    // 5c. Khách hàng
                    echo '<h3>Khách Hàng</h3>';
                    echo '<ul>';
                    echo '<li><a href="index.php?do=dsmonan_khachhang&id='. $_SESSION['MaND'] .'">Danh sách Món Ăn</a></li>';
                    echo '<li><a href="index.php?do=giohang_xem&id='. $_SESSION['MaND'] .'">Giỏ Hàng</a></li>';
                    //xem đơn hàng
                    echo '<li><a href="index.php?do=donhang_khachhang&id='.$_SESSION['MaND'].'">Đơn hàng của tôi</a></li>';
                    echo '</ul>';
                }

                // 6) Hồ sơ cá nhân (chung cho tất cả đã login)
                if (isset($_SESSION['HoTen'])) {
                    echo '<h3>Hồ sơ cá nhân</h3>';
                    echo '<ul>';
                    echo '<li><a href="index.php?do=hosocanhan">Hồ sơ cá nhân</a></li>';
                    echo '<li><a href="index.php?do=doimatkhau">Đổi mật khẩu</a></li>';
                    echo '</ul>';
                }

                // 7) Hỗ trợ khách hàng chỉ cho khách, không cho admin
    			if (isset($_SESSION['HoTen']) && isset($_SESSION['QuyenHan']) && $_SESSION['QuyenHan'] != 0) {
        			echo '<h3>Hỗ trợ</h3>';
        			echo '<ul>';
        			echo '<li><a href="index.php?do=hotro_khachhang&id='. $_SESSION['MaND'] .'">'
            		. 'Hỗ trợ khách hàng'
             		. '</a></li>';
        			echo '</ul>';
                }
                ?>
            </div>
            
            <!-- Cột nội dung bên phải -->
            <div id="BenPhai">
                <?php
                    // 8) Xác định trang cần include qua tham số 'do'
                    $do = isset($_GET['do']) ? $_GET['do'] : 'home';

                    // 9) Nếu là trang đăng nhập, include form riêng
                    if ($do === 'dangnhap') {
                        include 'dangnhap.php';
                    } else {
                        // 10) Nhúng file tương ứng (vd: dsmonan_khachhang → dsmonan_khachhang.php)
                        include $do . '.php';
                    }
                ?>
            </div>
        </div>
        
        <!-- ===== Phần Cuối: Footer liên hệ ===== -->
        <div id="PhanCuoi">
            <div class="lienhe">
                Liên hệ đặt giao: 099999999 - Quản Lý Bông
            </div>
        </div>
    </div>
</body>
</html>
