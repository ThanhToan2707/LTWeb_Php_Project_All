<?php
// giohang_xem.php — giữ nguyên logic gốc, chỉ bổ sung tìm kiếm, cải tiến giao diện và thêm nút thanh toán toàn bộ giỏ

// 1. Khởi session nếu chưa có
if (session_id() === '') {
    session_start();
}

// 2. Kết nối DB và set charset
require 'cauhinh.php';  // trong đó có $connect->set_charset("utf8")

// 3. Xác định MaND (ưu tiên GET, fallback session)
$maND = isset($_GET['id'])
      ? intval($_GET['id'])
      : (isset($_SESSION['MaND']) ? intval($_SESSION['MaND']) : 0);
if ($maND <= 0) {
    // Nếu không có MaND thì buộc về trang đăng nhập
    header('Location: index.php?do=dangnhap');
    exit;
}

// 4. Lấy từ khóa tìm kiếm (nếu có)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 5. Chuẩn bị câu lệnh SQL: thêm LIKE nếu có search
if ($search !== '') {
    $sql = "SELECT * 
            FROM giohang 
            WHERE MaNguoiDung = ? 
              AND TenMon LIKE ?";
    $stmt = $connect->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $connect->error);
    }
    $like = "%{$search}%";
    $stmt->bind_param("is", $maND, $like);
} else {
    // Không tìm → lấy toàn bộ giỏ
    $sql  = "SELECT * FROM giohang WHERE MaNguoiDung = ?";
    $stmt = $connect->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $connect->error);
    }
    $stmt->bind_param("i", $maND);
}

// 6. Thực thi và lấy kết quả
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
/* ========= Container & Typography ========= */
.cart-container {
  max-width: 900px;
  margin: 40px auto;
  font-family: Arial, sans-serif;
}
.cart-container h3 {
  text-align: center;
  color: #e86020;
  font-size: 2rem;
  margin-bottom: 20px;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
}

/* ========= Thanh tìm kiếm ========= */
.search-bar {
  text-align: center;
  margin-bottom: 20px;
}
.search-bar input[type="text"] {
  width: 280px;
  padding: 8px 12px;
  font-size: 1rem;
  border:1px solid #ccc;
  border-radius:4px 0 0 4px;
  outline:none;
}
.search-bar button {
  padding:8px 16px;
  font-size:1rem;
  border:none;
  cursor:pointer;
  outline:none;
}
.btn-search {
  background:#e86020; color:#fff; border-radius:0 4px 4px 0;
}
.btn-reset {
  background:#888;    color:#fff; margin-left:8px; border-radius:4px;
}
.btn-search:hover { background:#d14f0f; }
.btn-reset:hover  { background:#666; }

/* ========= Bảng Giỏ hàng ========= */
.DanhSach {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  margin-bottom: 30px;
}
.DanhSach th, .DanhSach td {
  padding: 12px 8px;
  text-align: center;
  border-bottom: 1px solid #eee;
}
.DanhSach th {
  background: #f2f2f2;
  font-weight: 600;
  color: #555;
}
.DanhSach tr:nth-child(even) td { background: #fafafa; }
.DanhSach tr:hover td { background: #fff0e5; }

/* ========= Ảnh Món ========= */
.item-img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 6px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}

/* ========= Icon Hành động ========= */
.action-icon {
  font-size: 1.4rem;
  cursor: pointer;
  transition: transform .1s;
}
.action-icon:hover { transform: scale(1.2); }
.icon-pay    { color: #28a745; }  /* ✔️ xanh */
.icon-delete { color: #d12f2f; }  /* ❌ đỏ */

/* ========= Thông báo trống ========= */
.empty-msg {
  text-align: center;
  color: #c00;
  font-size: 1.1rem;
  margin-top: 30px;
}

/* ========= Nút Thanh toán ========= */
.checkout-btn {
  display: inline-block;
  padding: 10px 20px;
  background: #e93e00;
  color: #fff;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  margin-top: 20px;
  transition: background .2s;
}
.checkout-btn:hover { background: #cf2e00; }
</style>

<div class="cart-container">
  <!-- Tiêu đề -->
  <h3>Giỏ hàng</h3>

  <!-- Form tìm kiếm -->
  <div class="search-bar">
    <form method="get" action="index.php">
      <!-- giữ nguyên do= và id= -->
      <input type="hidden" name="do" value="giohang_xem">
      <input type="hidden" name="id" value="<?php echo $maND; ?>">
      <input
        type="text"
        name="search"
        placeholder="Tìm tên món trong giỏ..."
        value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>"
      />
      <button type="submit" class="btn-search">Tìm</button>
      <button
        type="button"
        class="btn-reset"
        onclick="window.location='index.php?do=giohang_xem&id=<?php echo $maND; ?>'"
      >Reset</button>
    </form>
  </div>

  <?php if ($result->num_rows === 0): ?>
    <!-- Giỏ trống hoặc không tìm thấy -->
    <p class="empty-msg">
      <?php if ($search !== ''): ?>
        Không tìm thấy món phù hợp với "<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" trong giỏ.
      <?php else: ?>
        Giỏ hàng của bạn đang trống.
      <?php endif; ?>
    </p>
  <?php else: ?>
    <!-- Bảng liệt kê món -->
    <table class="DanhSach">
      <tr>
        <th>Tên Món Ăn</th>
        <th>Số Lượng</th>
        <th>Giá</th>
        <th>Ảnh</th>
        <th>Thanh Toán</th>
        <th>Xóa</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <!-- Tên món -->
          <td><?php echo htmlspecialchars($row['TenMon'], ENT_QUOTES, 'UTF-8'); ?></td>
          <!-- Số lượng -->
          <td><?php echo intval($row['SoLuong']); ?></td>
          <!-- Giá -->
          <td><?php echo number_format($row['Gia']); ?>₫</td>
          <!-- Ảnh -->
          <td>
            <img
              src="<?php echo htmlspecialchars($row['Anh'], ENT_QUOTES, 'UTF-8'); ?>"
              alt="<?php echo htmlspecialchars($row['TenMon'], ENT_QUOTES, 'UTF-8'); ?>"
              class="item-img"
            />
          </td>
          <!-- Mua hàng (ghi đè bằng mua 1 món) -->
          <td>
            <a
              href="index.php?do=giohang_mua&MaGio=<?php echo $row['MaGio']; ?>&MaND=<?php echo $maND; ?>"
              onclick="return confirm('Bạn có muốn mua món “<?php echo addslashes($row['TenMon']); ?>” không?');"
              class="action-icon icon-pay"
              title="Mua hàng"
            >✔️</a>
          </td>
          <!-- Xóa khỏi giỏ -->
          <td>
            <a
              href="index.php?do=giohang_xoa&id=<?php echo $row['MaMonAn']; ?>&mand=<?php echo $maND; ?>"
              onclick="return confirm('Bạn có muốn xóa món này khỏi giỏ không?');"
              class="action-icon icon-delete"
              title="Xóa"
            >❌</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>

    <!-- Nút Thanh toán toàn bộ giỏ hàng -->
    <div style="text-align: center;">
      <form action="index.php?do=donhang_them_xuly" method="post">
        <!-- POST MaND để xử lý tạo đơn hàng, có thể bỏ nếu dùng $_SESSION -->
        <input type="hidden" name="MaND" value="<?php echo $maND; ?>">
        <button
          type="submit"
          class="checkout-btn"
          onclick="return confirm('Bạn có chắc muốn thanh toán toàn bộ giỏ hàng không?');"
        >
          Thanh toán giỏ hàng
        </button>
      </form>
    </div>
  <?php endif; ?>
</div>
