<?php
// donhang_chitiet.php — Hiển thị chi tiết một đơn hàng

// 1. Khởi session nếu chưa có
if (session_id() === '') {
    session_start();
}

// 2. Kết nối DB (đã set charset UTF-8)
require 'cauhinh.php';  

// 3. Lấy và kiểm tra tham số đầu vào: mã đơn hàng và mã khách
$maDon = isset($_GET['madon'])   ? intval($_GET['madon'])   : 0;
$maND  = isset($_GET['id'])      ? intval($_GET['id'])      : 0;
if ($maDon <= 0 || $maND <= 0) {
    // Thiếu tham số → quay về trang danh sách đơn hàng
    header("Location: index.php?do=donhang_khachhang&id={$maND}");
    exit;
}

// 4. Lấy thông tin chung của đơn từ bảng donhang
$sqlInfo = "
    SELECT NgayDatHang, TrangThai, TongTien
    FROM donhang
    WHERE MaDonHang = ? 
      AND MaNguoiDung = ?
";
$stmtInfo = $connect->prepare($sqlInfo);
// Debug nếu prepare() thất bại
if (!$stmtInfo) {
    die("Prepare donhang failed: " . $connect->error);
}
$stmtInfo->bind_param("ii", $maDon, $maND);
$stmtInfo->execute();
$info = $stmtInfo->get_result()->fetch_assoc();
$stmtInfo->close();

// Nếu không tìm thấy đơn → quay về
if (!$info) {
    header("Location: index.php?do=donhang_khachhang&id={$maND}");
    exit;
}

// 5. Lấy chi tiết các món trong đơn từ chitietdonhang
$sqlDet = "
    SELECT ct.MaMonAn, ds.TenMonAn, ct.SoLuong, ct.DonGia
    FROM chitietdonhang AS ct
    JOIN danhsach AS ds 
      ON ct.MaMonAn = ds.MaMonAn
    WHERE ct.MaDonHang = ?
";
$stmtDet = $connect->prepare($sqlDet);
if (!$stmtDet) {
    die("Prepare chitiet failed: " . $connect->error);
}
$stmtDet->bind_param("i", $maDon);
$stmtDet->execute();
$rows = $stmtDet->get_result();
$stmtDet->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đơn #<?php echo $maDon; ?></title>
  <style>
    /* reset và font */
    body {
      background: #ffeeda;
      font-family: Arial, sans-serif;
      margin: 0; padding: 0;
    }
    /* container chính */
    .container {
      max-width: 900px;
      margin: 20px auto;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    /* header */
    .header {
      background: #e93e00;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    .header h2 {
      margin: 0;
      font-size: 2rem;
    }
    /* meta thông tin đơn */
    .order-meta {
      padding: 12px 20px;
      background: #ffe0c4;
      font-size: .95rem;
      color: #333;
    }
    .order-meta span {
      margin-right: 16px;
    }
    .order-meta .label {
      font-weight: bold;
      color: #e86020;
    }
    /* bảng chi tiết */
    .details-table {
      width: 100%;
      border-collapse: collapse;
    }
    .details-table th, .details-table td {
      padding: 12px 8px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    .details-table th {
      background: #f2f2f2;
      color: #555;
      font-weight: normal;
    }
    .details-table tr:nth-child(even) td {
      background: #fafafa;
    }
    .details-table tr:hover td {
      background: #fff0e5;
    }
    .details-table td.amount {
      text-align: right;
      padding-right: 20px;
    }
    /* link quay lại */
    .back-link {
      display: block;
      padding: 12px 20px;
      text-align: center;
      background: #ffe0c4;
      text-decoration: none;
      color: #e93e00;
      font-weight: bold;
    }
    .back-link:hover {
      background: #ffd0a0;
    }
    /* footer */
    .footer {
      background: #e93e00;
      color: #fff;
      text-align: center;
      padding: 12px 0;
      font-size: .9rem;
    }
  </style>
</head>
<body>

  <div class="container">
    <!-- 1. Header -->
    <div class="header">
      <h2>Chi tiết đơn #<?php echo $maDon; ?></h2>
    </div>

    <!-- 2. Thông tin chung -->
    <div class="order-meta">
      <span><span class="label">Ngày đặt:</span> <?php echo $info['NgayDatHang']; ?></span>
      <span><span class="label">Trạng thái:</span> <?php echo $info['TrangThai']; ?></span>
      <span><span class="label">Tổng tiền:</span> <?php echo number_format($info['TongTien']); ?>₫</span>
    </div>

    <!-- 3. Bảng chi tiết món -->
    <table class="details-table">
      <tr>
        <th>Mã SP</th>
        <th>Tên món</th>
        <th>Số lượng</th>
        <th>Đơn giá (₫)</th>
        <th>Thành tiền (₫)</th>
      </tr>
      <?php while ($row = $rows->fetch_assoc()):
        $thanhTien = $row['SoLuong'] * $row['DonGia'];
      ?>
      <tr>
        <td><?php echo $row['MaMonAn']; ?></td>
        <td><?php echo htmlspecialchars($row['TenMonAn'], ENT_QUOTES); ?></td>
        <td><?php echo intval($row['SoLuong']); ?></td>
        <td class="amount"><?php echo number_format($row['DonGia']); ?>₫</td>
        <td class="amount"><?php echo number_format($thanhTien); ?>₫</td>
      </tr>
      <?php endwhile; ?>
    </table>

    <!-- 4. Quay về danh sách đơn -->
    <a 
      href="index.php?do=donhang_khachhang&id=<?php echo $maND; ?>" 
      class="back-link"
    >
      ← Quay về Đơn hàng của tôi
    </a>
  </div>

</body>
</html>
