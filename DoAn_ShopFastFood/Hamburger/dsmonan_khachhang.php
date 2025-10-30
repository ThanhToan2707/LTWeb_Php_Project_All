<?php
// dsmonan_khachhang.php
// Hiển thị danh sách món ăn cho khách với:
//  - Phân loại (Tất cả / Hamburger / Đồ uống / Các món khác)
//  - Tìm kiếm (không phân biệt hoa thường)
//  - Mua ngay (✔️) dẫn đến form mua hàng
//  - Thêm vào giỏ (🛒) chọn số lượng qua modal

if (session_id() === '') session_start(); // Khởi tạo session nếu chưa có
require 'cauhinh.php';  // Kết nối cơ sở dữ liệu và thiết lập charset UTF-8

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['MaND'])) {
    header('Location: index.php?do=dangnhap'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

// Lấy thông tin người dùng từ session
$maND   = $_SESSION['MaND']; // Mã người dùng
$loai   = isset($_GET['loai'])   ? trim($_GET['loai'])   : ''; // Lấy loại món ăn từ URL (nếu có)
$search = isset($_GET['search']) ? trim($_GET['search']) : ''; // Lấy từ khóa tìm kiếm từ URL (nếu có)

// 1) Điều kiện WHERE động
$clauses = array("SoLuong > 0"); // Chỉ hiển thị món ăn còn hàng
$params  = array(); // Mảng tham số cho truy vấn
$types   = ""; // Chuỗi kiểu dữ liệu cho bind_param

// Lọc theo phân loại món ăn
if ($loai !== '') {
    $clauses[] = "PhanLoaiMon = ?"; // Thêm điều kiện phân loại
    $types   .= "s"; // Kiểu dữ liệu là chuỗi
    $params[] = $loai; // Thêm giá trị phân loại vào mảng tham số
}

// Lọc theo từ khóa tìm kiếm
if ($search !== '') {
    $clauses[] = "TenMonAn LIKE ?"; // Thêm điều kiện tìm kiếm
    $types   .= "s"; // Kiểu dữ liệu là chuỗi
    $params[] = "%" . $search . "%"; // Thêm giá trị tìm kiếm vào mảng tham số
}

// Kết hợp các điều kiện WHERE
$where = implode(" AND ", $clauses); // Nối các điều kiện bằng "AND"
$sql   = "SELECT * FROM danhsach WHERE $where"; // Truy vấn SQL
$stmt  = $connect->prepare($sql); // Chuẩn bị truy vấn
if (!$stmt) {
    die("Prepare failed: " . $connect->error); // Báo lỗi nếu truy vấn không hợp lệ
}

// Helper để bind_param với mảng trong PHP <5.6
function refValues($arr){
    $refs = array();
    foreach ($arr as $key => $value) {
        $refs[$key] = &$arr[$key]; // Tham chiếu từng phần tử
    }
    return $refs;
}

// 2) Bind nếu có tham số
if ($types !== "") {
    array_unshift($params, $types); // Thêm chuỗi kiểu dữ liệu vào đầu mảng tham số
    call_user_func_array(array($stmt, 'bind_param'), refValues($params)); // Gọi bind_param với các tham số
}

$stmt->execute(); // Thực thi truy vấn
$result = $stmt->get_result(); // Lấy kết quả truy vấn
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách Món Ăn</title>
  <link rel="stylesheet" href="css/style.css"> <!-- Liên kết file CSS -->
  <style>
    /* CSS định dạng giao diện */
    body { background:#ffeeda; font-family:Arial,sans-serif; margin:0; }
    h2 { text-align:center; color:#e93e00; margin:20px 0; }

    /* Phân loại */
    .category-menu{ text-align:center; margin-bottom:16px; }
    .category-menu .cat{
      display:inline-block; margin:0 6px; padding:6px 12px;
      background:#ddd; color:#333; text-decoration:none; border-radius:4px;
      transition:background .2s;
    }
    .category-menu .cat.active, .category-menu .cat:hover{
      background:#e93e00; color:#fff;
    }

    /* Tìm kiếm */
    .search-bar{ text-align:center; margin-bottom:20px; }
    .search-bar input[type="text"]{
      width:300px; padding:8px; font-size:1rem;
      border:1px solid #ccc; border-radius:4px 0 0 4px; outline:none;
    }
    .search-bar button{
      padding:8px 16px; font-size:1rem; border:none; cursor:pointer;
    }
    .btn-search{ background:#e93e00; color:#fff; border-radius:0 4px 4px 0; }
    .btn-reset{ background:#aaa; color:#fff; margin-left:8px; border-radius:4px; }
    .btn-search:hover{ background:#cf2e00; }
    .btn-reset:hover{ background:#888; }

    /* Grid & Card */
    .grid{
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
      gap:20px; max-width:1200px; margin:auto; padding:0 20px 40px;
    }
    .card{
      background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);
      display:flex; flex-direction:column; overflow:hidden; transition:transform .2s;
    }
    .card:hover{ transform:translateY(-4px); }
    .card img{ width:100%; height:140px; object-fit:cover; }
    .card-body{ flex:1; padding:12px; text-align:center; }
    .card-body h3{
      margin:10px 0; font-size:1.1rem; color:#333; text-transform:capitalize;
    }
    .card-body p{ margin:4px 0; font-size:.95rem; color:#555; }
    .card-actions{
      display:flex; justify-content:space-around;
      padding:10px; background:#fafafa; border-top:1px solid #eee;
    }
    .card-actions a, .card-actions button{
      background:none; border:none; cursor:pointer; font-size:1.4rem;
      transition:transform .1s;
    }
    .card-actions a:hover, .card-actions button:hover{ transform:scale(1.1); }
    .icon-pay{ color:#28a745; }  /* ✔️ */
    .icon-cart{ color:#555; }    /* 🛒 */

    /* Modal */
    .modal-backdrop{
      position:fixed; top:0; left:0; right:0; bottom:0;
      background:rgba(0,0,0,0.5); display:none;
      justify-content:center; align-items:center; z-index:1000;
    }
    .modal{
      background:#fff; padding:20px; border-radius:8px; width:300px;
      box-shadow:0 4px 12px rgba(0,0,0,0.2);
    }
    .modal h4{ margin:0 0 15px; color:#e93e00; text-align:center; }
    .modal .row{ display:flex; margin-bottom:12px; align-items:center; }
    .modal .row label{ flex:0 0 100px; font-weight:bold; }
    .modal .row input{
      flex:1; padding:6px; font-size:1rem;
      border:1px solid #ccc; border-radius:4px;
    }
    .modal .actions{ text-align:center; margin-top:15px; }
    .modal .actions button{
      padding:8px 14px; margin:0 6px; font-size:1rem;
      border:none; border-radius:4px; cursor:pointer;
    }
    .btn-confirm{ background:#28a745; color:#fff; }
    .btn-cancel{ background:#dc3545; color:#fff; }

    .not-found{
      text-align:center; color:#c00; font-size:1.1rem; margin:30px 0;
    }
  </style>
</head>
<body>

  <h2>Danh sách Món Ăn</h2>

  <!-- Phân loại -->
  <div class="category-menu">
    <?php
      $categories = array(
        ''           => 'Tất cả',
        'hamburger'  => 'Hamburger',
        'douong'     => 'Đồ uống',
        'cacmonkhac' => 'Các món khác'
      );
      foreach ($categories as $key => $label) {
        $cls = ($loai === $key) ? 'active' : '';
        $url = "index.php?do=dsmonan_khachhang&id=$maND";
        if ($key !== '') $url .= "&loai=$key";
        echo "<a href=\"$url\" class=\"cat $cls\">$label</a>";
      }
    ?>
  </div>

  <!-- Tìm kiếm -->
  <div class="search-bar">  
    <form method="get" action="index.php">
      <input type="hidden" name="do" value="dsmonan_khachhang">
      <input type="hidden" name="id" value="<?php echo $maND;?>">
      <?php if ($loai !== ''): ?>
        <input type="hidden" name="loai" value="<?php echo $loai;?>">
      <?php endif; ?>
      <input
        type="text"
        name="search"
        placeholder="Tìm theo tên món..."
        value="<?php echo htmlspecialchars($search, ENT_QUOTES);?>"
      />
      <button type="submit" class="btn-search">Tìm</button>
      <button
        type="button"
        class="btn-reset"
        onclick="window.location='<?php 
          $base = "index.php?do=dsmonan_khachhang&id=$maND";
          echo $loai? "$base&loai=$loai": $base;
        ?>'"
      >Reset</button>
    </form>
  </div>

  <?php if ($result->num_rows === 0): ?>
    <p class="not-found">
      <?php if ($search || $loai): ?>
        Không tìm thấy món phù hợp.
      <?php else: ?>
        Hiện chưa có món nào.
      <?php endif; ?>
    </p>
  <?php endif; ?>

  <!-- Grid sản phẩm -->
  <div class="grid">
    <?php while ($r = $result->fetch_assoc()): ?>
      <div class="card">
        <img src="<?php echo htmlspecialchars($r['AnhMonAn'],ENT_QUOTES);?>"
             alt="<?php echo htmlspecialchars($r['TenMonAn'],ENT_QUOTES);?>" />
        <div class="card-body">
          <h3><?php echo htmlspecialchars($r['TenMonAn'],ENT_QUOTES);?></h3>
          <p>Kho: <?php echo intval($r['SoLuong']);?></p>
          <p>Giá: <?php echo number_format($r['Gia']);?>₫</p>
        </div>
        <div class="card-actions">
          <a href="index.php?do=mua_ngay&id=<?php echo $r['MaMonAn'];?>"
             class="icon-pay"
             title="Mua ngay"
             onclick="return confirm('Bạn có chắc muốn mua “<?php echo addslashes($r['TenMonAn']);?>”?');"
          >✔️</a>
          <button class="icon-cart btn-add"
                  title="Thêm vào giỏ"
                  data-id="<?php echo $r['MaMonAn'];?>"
                  data-name="<?php echo htmlspecialchars($r['TenMonAn'],ENT_QUOTES);?>"
                  data-price="<?php echo floatval($r['Gia']);?>"
                  data-stock="<?php echo intval($r['SoLuong']);?>"
          >🛒</button>
        </div>
      </div>
    <?php endwhile;?>
  </div>

  <!-- Modal -->
  <div class="modal-backdrop" id="modalBackdrop">
    <div class="modal">
      <h4>Thêm vào giỏ hàng</h4>
      <form id="addForm" method="post" action="index.php?do=giohang_them_xuly">
        <input type="hidden" name="MaMonAn" id="mamon_input">
        <div class="row">
          <label>Tên món:</label>
          <input type="text" id="ten_input" readonly>
        </div>
        <div class="row">
          <label>Đơn giá:</label>
          <input type="text" id="dongia_input" readonly>
        </div>
        <div class="row">
          <label>Tồn kho:</label>
          <input type="text" id="stock_input" readonly>
        </div>
        <div class="row">
          <label>Số lượng:</label>
          <input type="number" name="SoLuongMua" id="soluong_input" min="1" value="1" required>
        </div>
        <div class="row">
          <label>Tổng tiền:</label>
          <input type="text" id="tong_input" readonly>
        </div>
        <div class="actions">
          <button type="button" class="btn-cancel" id="btnCancel">Hủy</button>
          <button type="submit" class="btn-confirm">Xác nhận</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const backdrop = document.getElementById('modalBackdrop');
    const idFld   = document.getElementById('mamon_input');
    const nameFld = document.getElementById('ten_input');
    const priceFld= document.getElementById('dongia_input');
    const stockFld= document.getElementById('stock_input');
    const qtyFld  = document.getElementById('soluong_input');
    const totalFld= document.getElementById('tong_input');
    let unitPrice = 0;

    document.querySelectorAll('.btn-add').forEach(function(btn){
      btn.addEventListener('click', function(){
        var id    = this.getAttribute('data-id');
        var name  = this.getAttribute('data-name');
        unitPrice = parseFloat(this.getAttribute('data-price'));
        var stock = parseInt(this.getAttribute('data-stock'));

        idFld.value    = id;
        nameFld.value  = name;
        priceFld.value = unitPrice.toLocaleString('vi-VN') + ' ₫';
        stockFld.value = stock;
        qtyFld.max     = stock;
        qtyFld.value   = 1;
        totalFld.value = unitPrice.toLocaleString('vi-VN') + ' ₫';
        backdrop.style.display = 'flex';
      });
    });

    qtyFld.addEventListener('input', function(){
      var q = parseInt(this.value) || 1;
      if (q < 1) q = 1;
      if (q > this.max) q = this.max;
      this.value = q;
      totalFld.value = (unitPrice * q).toLocaleString('vi-VN') + ' ₫';
    });

    document.getElementById('btnCancel').addEventListener('click', function(){
      backdrop.style.display = 'none';
    });
  </script>

</body>
</html>