<?php
// hotro_admin.php — Danh sách Yêu cầu Hỗ trợ cho Admin

if (session_id() === '') session_start();
require 'cauhinh.php';

// 1. Chỉ cho quản lý vào
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 0) {
    header('Location: index.php?do=dangnhap');
    exit;
}

// 2. Truy vấn tất cả yêu cầu, mới nhất trước
$sql = "
  SELECT h.MaHoTro, h.MaND, u.TenNguoiDung, h.TieuDe, h.NgayGui, h.TrangThai
  FROM hotro h
  JOIN nguoidung u ON h.MaND = u.MaNguoiDung
  ORDER BY h.NgayGui DESC
";
$result = $connect->query($sql);
?>
<style>
  body {
    background: #f8f8f8;
  }
  .support-container {
    max-width: 700px;
    margin: 40px auto 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 6px 32px rgba(0,0,0,0.10);
    padding: 32px 24px 24px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .support-title {
    text-align: center;
    color: #e93e00;
    font-size: 2rem;
    margin-bottom: 28px;
    letter-spacing: 1px;
    font-weight: bold;
    text-shadow: 0 2px 8px #ffe0d0;
  }
  .support-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fafbfc;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    margin-bottom: 0;
  }
  .support-table th, .support-table td {
    padding: 13px 10px;
    text-align: center;
    font-size: 1rem;
    word-break: break-word;
  }
  .support-table th {
    background: linear-gradient(90deg, #ff7e3f 0%, #e93e00 100%);
    color: #fff;
    font-weight: 600;
    border-bottom: 2px solid #fff;
    letter-spacing: 0.5px;
  }
  .support-table tr {
    transition: background 0.2s;
  }
  .support-table tr:nth-child(even) {
    background: #fff5ee;
  }
  .support-table tr:hover {
    background: #ffe0d0;
  }
  .support-table td {
    color: #333;
    vertical-align: middle;
  }
  .support-status {
    padding: 4px 14px;
    border-radius: 12px;
    font-weight: 500;
    font-size: .98rem;
    display: inline-block;
    min-width: 90px;
  }
  .support-status[data-status="Chưa Xử Lý"] {
    background: #ffe5e0;
    color: #e93e00;
    border: 1px solid #ffc2b3;
  }
  .support-status[data-status="Đã Xử Lý"] {
    background: #e0ffe5;
    color: #28a745;
    border: 1px solid #b3ffd1;
  }
  .btn-edit {
    background: linear-gradient(90deg, #ff7e3f 0%, #e93e00 100%);
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 7px 22px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .15s, color .15s, box-shadow .15s;
    cursor: pointer;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    display: inline-block;
    margin: 0 auto;
  }
  .btn-edit:hover {
    background: #e93e00;
    color: #fff;
    box-shadow: 0 2px 8px #ffc2b3;
  }
  @media (max-width: 800px) {
    .support-container { max-width: 98vw; padding: 10px; }
    .support-table th, .support-table td { font-size: 0.95rem; padding: 8px 4px; }
    .support-title { font-size: 1.2rem; }
  }
</style>

<div class="support-container">
  <div class="support-title">Quản lý Yêu cầu Hỗ trợ</div>
  <table class="support-table">
    <tr>
      <th>#</th>
      <th>Khách</th>
      <th>Tiêu Đề</th>
      <th>Thời gian</th>
      <th>Trạng Thái</th>
      <th>Hành Động</th>
    </tr>
    <?php while ($r = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $r['MaHoTro']; ?></td>
        <td><?php echo htmlspecialchars($r['TenNguoiDung']); ?></td>
        <td style="text-align:left;"><?php echo htmlspecialchars($r['TieuDe']); ?></td>
        <td><?php echo $r['NgayGui']; ?></td>
        <td>
          <span class="support-status" data-status="<?php echo $r['TrangThai']; ?>">
            <?php echo $r['TrangThai']; ?>
          </span>
        </td>
        <td>
          <a 
            href="index.php?do=hotro_edit&id=<?php echo $r['MaHoTro']; ?>" 
            class="btn-edit"
            title="Sửa yêu cầu"
          >Sửa</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>