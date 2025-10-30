<?php
// dangky_xuly.php: xử lý form đăng ký

// 1. Khởi session nếu chưa có
if (session_id() === '') {
    session_start(); // Khởi tạo session để lưu thông tin người dùng nếu cần
}

// 2. Kết nối database
require 'cauhinh.php';   // Kết nối đến file cấu hình cơ sở dữ liệu ($connect)

// 3. Chỉ chấp nhận phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ThongBaoLoi("Phương thức không hợp lệ."); // Báo lỗi nếu không phải POST
    exit;
}

// 4. Lấy & trim dữ liệu từ form
$quyen          = 1;  // Mặc định quyền là khách hàng
$hoVaTen        = isset($_POST['HoVaTen'])     ? trim($_POST['HoVaTen'])     : ''; // Lấy họ và tên
$tenDangNhap    = isset($_POST['TenDangNhap']) ? trim($_POST['TenDangNhap']) : ''; // Lấy tên đăng nhập
$matKhau        = isset($_POST['MatKhau'])     ? trim($_POST['MatKhau'])     : ''; // Lấy mật khẩu
$matKhau2       = isset($_POST['MatKhau2'])    ? trim($_POST['MatKhau2'])    : ''; // Lấy xác nhận mật khẩu
$diaChi         = isset($_POST['DiaChi'])      ? trim($_POST['DiaChi'])      : ''; // Lấy địa chỉ giao hàng

// 5. Validation cơ bản
if ($hoVaTen === '') {
    ThongBaoLoi("Họ và tên không được bỏ trống!"); // Kiểm tra họ và tên
    exit;
}
if ($tenDangNhap === '') {
    ThongBaoLoi("Tên đăng nhập không được bỏ trống!"); // Kiểm tra tên đăng nhập
    exit;
}
if ($matKhau === '') {
    ThongBaoLoi("Mật khẩu không được bỏ trống!"); // Kiểm tra mật khẩu
    exit;
}
if ($matKhau2 === '') {
    ThongBaoLoi("Xác nhận mật khẩu không được bỏ trống!"); // Kiểm tra xác nhận mật khẩu
    exit;
}
if ($matKhau !== $matKhau2) {
    ThongBaoLoi("Mật khẩu và xác nhận mật khẩu không khớp!"); // Kiểm tra mật khẩu khớp nhau
    exit;
}
if ($diaChi === '') {
    ThongBaoLoi("Địa chỉ giao hàng không được bỏ trống!"); // Kiểm tra địa chỉ giao hàng
    exit;
}

// 6. Kiểm tra trùng tên đăng nhập
$stmt = $connect->prepare(
    "SELECT 1 FROM nguoidung WHERE TenDangNhap = ?" // Truy vấn kiểm tra tên đăng nhập
);
$stmt->bind_param("s", $tenDangNhap); // Gán giá trị tên đăng nhập vào truy vấn
$stmt->execute(); // Thực thi truy vấn
$stmt->store_result(); // Lưu kết quả truy vấn
if ($stmt->num_rows > 0) { // Nếu có kết quả, tên đăng nhập đã tồn tại
    $stmt->close();
    ThongBaoLoi("Tên đăng nhập này đã có người sử dụng, vui lòng chọn tên khác!"); 
    exit;
}
$stmt->close(); // Đóng truy vấn

// 7. Hash mật khẩu bằng MD5
$matKhauHash = md5($matKhau); // Mã hóa mật khẩu bằng MD5 (không an toàn, chỉ dùng cho PHP cũ)

// 8. Thêm người dùng mới vào cơ sở dữ liệu
$sql = "INSERT INTO nguoidung
        (`QuyenHan`, `TenNguoiDung`, `TenDangNhap`, `MatKhau`, `DiaChi`)
        VALUES (?, ?, ?, ?, ?)"; // Câu lệnh SQL thêm người dùng
$stmt = $connect->prepare($sql); // Chuẩn bị truy vấn
$stmt->bind_param(
    "issss", // Gán các giá trị vào truy vấn (1 số nguyên, 4 chuỗi)
    $quyen,
    $hoVaTen,
    $tenDangNhap,
    $matKhauHash,
    $diaChi
);

if ($stmt->execute()) { // Thực thi truy vấn
    // 9. Đăng ký thành công
    ThongBao("Đăng ký thành công! Vui lòng đăng nhập để tiếp tục."); // Thông báo thành công
} else {
    // 10. Báo lỗi nếu có
    ThongBaoLoi("Đã xảy ra lỗi khi thêm dữ liệu vào CSDL: " . $stmt->error); // Thông báo lỗi
}
$stmt->close(); // Đóng truy vấn
exit; // Kết thúc xử lý
?>