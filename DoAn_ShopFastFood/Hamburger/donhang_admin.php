<?php
// donhang_admin.php — Danh sách đơn hàng cho Admin

// 1. Bắt buộc phải là admin
if (session_id() === '') session_start();
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 0) {
    header('Location:index.php?do=dangnhap');
    exit;
}

require 'cauhinh.php';  // Kết nối DB, UTF-8

// 2. Lấy tất cả đơn hàng, kèm tên khách, sắp xếp mới nhất lên trên
$sql = "
  SELECT d.MaDonHang, d.NgayDatHang, d.TrangThai, d.TongTien,
         u.TenNguoiDung
  FROM donhang d
  JOIN nguoidung u ON d.MaNguoiDung = u.MaNguoiDung
  ORDER BY d.NgayDatHang DESC
";
$res = $connect->query($sql);
if (!$res) die("Lỗi truy vấn: ".$connect->error);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản Lý Đơn Hàng</title>
  <!-- Phần CSS hiện đại cho giao diện -->
  <style>
    /* ===== Container chung ===== */
    body {
      background: #f8f8f8;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .admin-container {
      max-width: 1100px;
      margin: 40px auto 0 auto;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 6px 32px rgba(0,0,0,0.10);
      padding: 32px 24px 24px 24px;
    }
    .admin-header {
      text-align: center;
      color: #e93e00;
      font-size: 2.2rem;
      margin-bottom: 28px;
      letter-spacing: 1px;
      font-weight: bold;
      text-shadow: 0 2px 8px #ffe0d0;
    }

    /* ===== Bảng danh sách ===== */
    .DanhSach {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: #fafbfc;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      margin-bottom: 0;
    }
    .DanhSach th, .DanhSach td {
      padding: 15px 10px;
      text-align: center;
      font-size: 1rem;
      word-break: break-word;
    }
    .DanhSach th {
      background: linear-gradient(90deg, #ff7e3f 0%, #e93e00 100%);
      color: #fff;
      font-weight: 600;
      border-bottom: 2px solid #fff;
      letter-spacing: 0.5px;
    }
    .DanhSach tr {
      transition: background 0.2s;
    }
    .DanhSach tr:nth-child(even) td {
      background: #fff5ee;
    }
    .DanhSach tr:hover td {
      background: #ffe0d0;
    }
    .DanhSach td {
      color: #333;
      vertical-align: middle;
    }

    /* ===== Trạng thái đơn hàng ===== */
    .order-status {
      padding: 5px 16px;
      border-radius: 12px;
      font-weight: 500;
      font-size: .98rem;
      display: inline-block;
      min-width: 110px;
      border: 1px solid #eee;
    }
    .order-status[data-status="Chưa Xử Lý"] {
      background: #ffe5e0;
      color: #e93e00;
      border-color: #ffc2b3;
    }
    .order-status[data-status="Đang Xử Lý"] {
      background: #fffbe0;
      color: #e9a800;
      border-color: #ffe9a3;
    }
    .order-status[data-status="Đã Hoàn Thành"] {
      background: #e0ffe5;
      color: #28a745;
      border-color: #b3ffd1;
    }

    /* ===== Nút hành động ===== */
    .action-link {
      display: inline-block;
      padding: 7px 18px;
      background: linear-gradient(90deg, #ff7e3f 0%, #e93e00 100%);
      color: #fff;
      text-decoration: none;
      border-radius: 7px;
      font-size: 1rem;
      font-weight: 600;
      transition: background .15s, color .15s, box-shadow .15s;
      cursor: pointer;
      box-shadow: 0 1px 4px rgba(0,0,0,0.07);
      margin: 0 auto;
    }
    .action-link:hover {
      background: #e93e00;
      color: #fff;
      box-shadow: 0 2px 8px #ffc2b3;
    }

    /* ===== Responsive cho mobile ===== */
    @media (max-width: 800px) {
      .admin-container { max-width: 98vw; padding: 10px; }
      .DanhSach th, .DanhSach td { font-size: 0.95rem; padding: 8px 4px; }
      .admin-header { font-size: 1.2rem; }
    }
  </style>
</head>
<body>

  <div class="admin-container">
    <!-- Tiêu đề trang -->
    <div class="admin-header">Quản Lý Đơn Hàng</div>

    <!-- Bảng hiển thị danh sách đơn hàng -->
    <table class="DanhSach">
      <tr>
        <th>Mã Đơn</th>
        <th>Khách hàng</th>
        <th>Ngày đặt</th>
        <th>Trạng thái</th>
        <th>Tổng tiền</th>
        <th>Hành động</th>
      </tr>
      <?php while ($o = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $o['MaDonHang']; ?></td>
        <td><?php echo htmlspecialchars($o['TenNguoiDung'], ENT_QUOTES); ?></td>
        <td><?php echo $o['NgayDatHang']; ?></td>
        <td>
          <!-- Hiển thị trạng thái với màu sắc riêng -->
          <span class="order-status" data-status="<?php echo $o['TrangThai']; ?>">
            <?php echo $o['TrangThai']; ?>
          </span>
        </td>
        <td><?php echo number_format($o['TongTien']); ?>₫</td>
        <td>
          <!-- Nút chuyển trạng thái -->
          <a
            href="index.php?do=donhang_admin_edit&madon=<?php echo $o['MaDonHang']; ?>"
            class="action-link"
            title="Chuyển trạng thái"
          >Sửa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

</body>
</html>