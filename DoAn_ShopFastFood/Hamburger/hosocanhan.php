<?php
// hosocanhan.php — Hồ sơ cá nhân
if (session_id() === '') session_start();
require 'cauhinh.php';

// Bắt buộc login
if (!isset($_SESSION['MaND'])) {
    header('Location: index.php?do=dangnhap');
    exit;
}

// Lấy user
$ma = intval($_SESSION['MaND']);
$stmt = $connect->prepare("SELECT TenNguoiDung,TenDangNhap,DiaChi FROM nguoidung WHERE MaNguoiDung = ?");
$stmt->bind_param("i", $ma);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hồ sơ cá nhân</title>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: #ffeeda;
      font-family: 'Comfortaa', cursive;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 480px;
      margin: 60px auto;
      background: #fff;
      padding: 30px 25px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      text-align: center;
    }
    h2 {
      margin-bottom: 20px;
      color: #e93e00;
      font-size: 2rem;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    form {
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }
    label {
      text-align: left;
      margin: 12px 0 4px;
      font-weight: 600;
      color: #333;
    }
    input[type="text"],
    input[type="password"] {
      padding: 10px 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: border-color .2s, box-shadow .2s;
    }
    input:focus {
      outline: none;
      border-color: #e93e00;
      box-shadow: 0 0 4px rgba(233,62,0,0.4);
    }
    .actions {
      display: flex;
      justify-content: space-between;
      margin-top: 24px;
    }
    .btn {
      flex: 1;
      padding: 10px 0;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background .2s, transform .1s;
      margin: 0 6px;
    }
    .btn-update {
      background: #e93e00;
      color: #fff;
    }
    .btn-reset {
      background: #aaa;
      color: #fff;
    }
    .btn:hover {
      transform: translateY(-2px);
    }
    .btn-update:hover {
      background: #cf2e00;
    }
    .btn-reset:hover {
      background: #888;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Hồ sơ cá nhân</h2>
    <form action="index.php?do=hosocanhan_xuly" method="post" id="profileForm">
      <label>Họ và tên *</label>
      <input type="text" name="HoVaTen"
             value="<?php echo htmlspecialchars($user['TenNguoiDung'], ENT_QUOTES); ?>"
             required />

      <label>Tên đăng nhập *</label>
      <input type="text" name="TenDangNhap"
             value="<?php echo htmlspecialchars($user['TenDangNhap'], ENT_QUOTES); ?>"
             required />

      <label>Mật khẩu mới</label>
      <input type="password" name="MatKhau"
             placeholder="Để trống nếu không đổi" />

      <label>Nhập lại mật khẩu mới</label>
      <input type="password" name="MatKhau2"
             placeholder="Để trống nếu không đổi" />

      <label>Địa chỉ *</label>
      <input type="text" name="DiaChi"
             value="<?php echo htmlspecialchars($user['DiaChi'], ENT_QUOTES); ?>"
             required />

      <div class="actions">
        <!-- Reset form về giá trị ban đầu -->
        <button type="reset" class="btn btn-reset">Reset</button>
        <!-- Submit cập nhật -->
        <button type="submit" class="btn btn-update">Cập nhật</button>
      </div>
    </form>
  </div>

</body>
</html>
