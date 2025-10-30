<?php
// dangnhap_xuly.php: Xử lý logic đăng nhập

// 1. Khởi session nếu chưa có
if (session_id() === '') {
    session_start(); // Khởi tạo session để lưu thông tin người dùng
}

// 2. Kết nối DB
require 'cauhinh.php';  // Kết nối đến cơ sở dữ liệu, đã có $connect->set_charset("utf8")

// 3. Chỉ xử lý POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ThongBaoLoi("Phương thức không hợp lệ."); // Chỉ chấp nhận phương thức POST
    exit;
}

// 4. Lấy và trim dữ liệu form
$TenDangNhap = isset($_POST['TenDangNhap']) 
    ? trim($_POST['TenDangNhap']) // Lấy tên đăng nhập từ form và loại bỏ khoảng trắng thừa
    : '';
$MatKhauRaw  = isset($_POST['MatKhau']) 
    ? trim($_POST['MatKhau']) // Lấy mật khẩu từ form và loại bỏ khoảng trắng thừa
    : '';

// 5. Check bắt buộc
if ($TenDangNhap === '' || $MatKhauRaw === '') {
    ThongBaoLoi("Tên đăng nhập và mật khẩu không được bỏ trống!"); // Kiểm tra dữ liệu không được để trống
    exit;
}

// 6. Lấy bản ghi user theo TenDangNhap
$sql  = "SELECT MaNguoiDung, TenNguoiDung, QuyenHan, MatKhau
         FROM nguoidung
         WHERE TenDangNhap = ?"; // Truy vấn lấy thông tin người dùng theo tên đăng nhập
$stmt = $connect->prepare($sql); // Chuẩn bị truy vấn
if (!$stmt) {
    ThongBaoLoi("Lỗi chuẩn bị truy vấn: " . $connect->error); // Báo lỗi nếu truy vấn không hợp lệ
    exit;
}
$stmt->bind_param("s", $TenDangNhap); // Gán giá trị tên đăng nhập vào truy vấn
$stmt->execute(); // Thực thi truy vấn
$result = $stmt->get_result(); // Lấy kết quả truy vấn

// 7. Nếu tìm thấy duy nhất 1 user
if ($result && $result->num_rows === 1) {
    $row    = $result->fetch_assoc(); // Lấy dữ liệu của người dùng
    $dbPass = $row['MatKhau']; // Lấy mật khẩu đã lưu trong cơ sở dữ liệu

    // 8. So sánh: nếu DB là plaintext hoặc MD5 thì đều cho qua
    if ($MatKhauRaw === $dbPass // So sánh mật khẩu nhập vào với mật khẩu lưu trong DB (plaintext)
        || md5($MatKhauRaw) === $dbPass // So sánh mật khẩu nhập vào với mật khẩu lưu trong DB (MD5)
    ) {
        // 9. Đăng nhập thành công → lưu session
        $_SESSION['MaND']        = $row['MaNguoiDung']; // Lưu mã người dùng vào session
        $_SESSION['HoTen']       = $row['TenNguoiDung']; // Lưu họ tên người dùng vào session
        $_SESSION['TenDangNhap'] = $TenDangNhap; // Lưu tên đăng nhập vào session
        $_SESSION['QuyenHan']    = $row['QuyenHan']; // Lưu quyền hạn vào session

        // 10. Chuyển hướng theo quyền
        if ($row['QuyenHan'] == 0) { // Nếu quyền là admin
            header("Location: index.php?do=quanly"); // Chuyển hướng đến trang quản lý
        } else { // Nếu quyền là khách hàng
            header("Location: index.php?do=dsmonan_khachhang&id=" . $row['MaNguoiDung']); // Chuyển hướng đến trang khách hàng
        }
        exit; // Kết thúc xử lý
    }
}

// 11. Nếu không khớp hoặc không tìm thấy thì báo lỗi
ThongBaoLoi("Tên đăng nhập hoặc mật khẩu không chính xác!"); // Báo lỗi nếu thông tin không khớp
exit;
?>