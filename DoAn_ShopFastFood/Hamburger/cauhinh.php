<?php
// Kết nối tới MySQL bằng MySQLi và thiết lập UTF-8 để đảm bảo hiển thị tiếng Việt chính xác

// 1. Khai báo thông tin kết nối
$servername = "localhost";       // Địa chỉ host của MySQL (ở máy local thường là localhost)
$username   = "root";            // Tên user đăng nhập MySQL
$password   = "vertrigo";        // Mật khẩu tương ứng với user (ở đây là vertrigo)
$dbname     = "hamburgerto";     // Tên database cần kết nối

// 2. Tạo đối tượng kết nối
$connect = new mysqli(
    $servername,                // host
    $username,                  // user
    $password,                  // password
    $dbname                     // database
);

// 3. Kiểm tra kết nối
if ($connect->connect_error) {  // Nếu có lỗi khi kết nối...
    die("Không kết nối: " .   // Hiển thị thông báo và dừng script
        $connect->connect_error
    );
    exit();                     // Đảm bảo kết thúc luôn cả script (dù die() thường đã exit)
}

// 4. FIX ENCODING: đặt charset UTF-8
//    Bắt buộc để mọi truy vấn và kết quả sử dụng mã hóa UTF-8, tránh lỗi hiển thị tiếng Việt
$connect->set_charset("utf8");

// Sau khi chạy đến đây, biến $connect sẵn sàng dùng cho các truy vấn SELECT, INSERT, v.v.
?>
