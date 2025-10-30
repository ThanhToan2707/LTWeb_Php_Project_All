<?php
//quan ly cac trang lien quan den sach
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        case 'detail': //?mod=book&act=detail&id=?
            //xu ly
            include_once("models/m_book.php");
            //lay ra chi tiet 1 cuon sach
            if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                $bookDetail = book_getBookById($_GET['id']);
            } else {
                //chuyen den trang home
                header("Location: ?mod=page&act=home");
            }
            //lay ra ngau nhieu 4 cuon sach cung chu de
            $randomBooks = book_getRandomBooksByCategory($bookDetail['MaCD']);

            include_once("models/m_comment.php");
            //lay ra tat ca binh luan cua 1 cuon sach
            $comments = comment_getCommentsByBook($bookDetail['MaSach']);

            //hien thi len view
            include_once("views/v_header.php");
            include_once("views/v_book_detail.php");
            include_once("views/v_footer.php");
            break;

        //hien thi gio hang cua nguoi dung 
        case 'cart': //?mod=book&act=cart
            //xu ly
            //lay gio hang tu session neu co 
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = []; //khoi tao gio hang rong neu chua co

            }
            //lay gio hang tu session de hien thi len view 
            $cart = $_SESSION['cart'];

            //gia su ngay muon mat dinh la ngay hien tai + 7 ngay
            $NgayMuon = date('Y-m-d');

            // kiểm tra xem có ngày trả trong GET không 
            if (isset($_GET['returnDate'])) {
                // nếu có thì gán giá trị cho biến $NgayTra 
                $NgayTra = $_GET['returnDate'];
            } else {
                // nếu không có thì đặt ngày trả mặc định là ngày mượn + 7 ngày
                $NgayTra = date('Y-m-d', strtotime($NgayMuon . ' + 7 days'));
            }
            // luu vao session de su dung o view cart v_book_cart.php va xu ly o controller c_order.php
            $_SESSION['NgayTra'] = $NgayTra;
            //tinh so ngay muon de tinh tien muon sach o controller c_order.php 
            $SoNgayMuon = date_diff(date_create($NgayTra), date_create($NgayMuon));
            $SoNgayMuon = $SoNgayMuon->days;


            include_once("models/m_book.php");
            foreach ($cart as &$book) {
                $detail = book_getBookById($book['MaSach']);
                $book['TuaSach'] = $detail['TuaSach'];
                $book['HinhAnh'] = $detail['HinhAnh'];
                // gia su Gia muon sach = 10% Gia tri sach
                $book['GiaMuon'] = $detail['GiaTri'] * 0.1;
                $book['ThanhTien'] = $book['GiaMuon'] * $book['SoLuong'] * $SoNgayMuon;
            }

            //hien thi len view
            include_once("views/v_header.php");
            include_once("views/v_book_cart.php");
            include_once("views/v_footer.php");
            break;


        // Thêm sách vào giỏ hàng 
        case 'addToCart': //?mod=book&act=addToCart&id=?
            //tao ra gio hang neu chua co
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = []; //khoi tao gio hang rong
            }

            $MaSach = $_GET['id'];
            $inCart = false; //Giả sử sách chưa có trong giỏ hàng

            foreach ($_SESSION['cart'] as &$book) {
                if ($book['MaSach'] == $MaSach) {
                    //sách đã có trong giỏ hàng -> tăng số lượng
                    $book['SoLuong']++;
                    $inCart = true; //cập nhật lại biến
                    break;
                }
            }

            //sách chưa có trong giỏ hàng -> thêm vào với số lượng = 1
            if (!$inCart) {
                array_push($_SESSION['cart'], [
                    'MaSach' => $MaSach,
                    'SoLuong' => 1
                ]);
            }

            //thông báo đã thêm vào giỏ hàng
            $_SESSION['alert'] = "Đã thêm sách vào giỏ hàng!";

            //load lại trang chi tiết sách sau khi thêm vào giỏ hàng
            header("Location: ?mod=book&act=detail&id=$MaSach");
            break;

        // Tăng số lượng sách trong giỏ hàng
        case 'increase': //?mod=book&act=increase&id=?
            $MaSach = $_GET['id'];
            foreach ($_SESSION['cart'] as &$book) {
                if ($book['MaSach'] == $MaSach) {
                    //sách đã có trong giỏ hàng -> tăng số lượng
                    $book['SoLuong']++;
                    break;
                }
            }
            //load lại trang giỏ hàng sau khi tăng số lượng
            header("Location: ?mod=book&act=cart");
            break;

        // Giảm số lượng sách trong giỏ hàng
        case 'decrease': //?mod=book&act=decrease&id=?
            $MaSach = $_GET['id'];
            foreach ($_SESSION['cart'] as &$book) {
                if ($book['MaSach'] == $MaSach) {
                    //sách đã có trong giỏ hàng -> giảm số lượng
                    if ($book['SoLuong'] > 1) {
                        $book['SoLuong']--;
                    }
                    break;
                }
            }
            //load lại trang giỏ hàng sau khi giảm số lượng
            header("Location: ?mod=book&act=cart");
            break;

        // Xóa 1 cuốn sách trong giỏ hàng
        case 'delete': //?mod=book&act=delete&index=?
            $index = $_GET['index'];
            //xoa sach tai vi tri index khoi gio hang
            array_splice($_SESSION['cart'], $index, 1);
            //load lại trang giỏ hàng sau khi xóa sách
            header("Location: ?mod=book&act=cart");
            break;

        // Xóa tất cả sách trong giỏ hàng
        case 'deleteAllCart': //?mod=book&act=deleteAllCart
            //xoa sach tai vi tri index khoi gio hang
            unset($_SESSION['cart']);
            //load lại trang giỏ hàng sau khi xóa sách
            header("Location: ?mod=book&act=cart");
            break;

        // Đặt mượn sách trong giỏ hàng
        case 'postCart': //?mod=book&act=postCart
            include_once("models/m_history.php");
            $MaTK = $_SESSION['user']['MaTK'];
            $NgayMuon = date('Y-m-d');
            $NgayTra = $_SESSION['NgayTra'];
            $SoSachMuon = $_SESSION['SoSachMuon'];
            $TongTien = $_SESSION['TongTien'];
            $MaLS = history_add($MaTK, $NgayMuon, $NgayTra, $SoSachMuon, $TongTien, 'gio-sach');
            //them chi tiet lich su muon sach vao csdl 
            foreach ($_SESSION['cart'] as $book) {
                history_addDetail($MaLS, $book['MaSach'], $book['SoLuong']);
            }
            //xoa gio hang
            unset($_SESSION['cart']);
            //chuyen den trang dat hang thanh cong
            header("Location: ?mod=book&act=cartSuccess");
            break;


        case 'cartSuccess': //?mod=page&act=cartSuccess
            //xu ly
            //hien thi len view
            include_once("views/v_header.php");
            include_once("views/v_book_cartSuccess.php");
            include_once("views/v_footer.php");
            break;

        default:
            # code...
            break;
    }
} else {
    //chuyen den trang home
    header("Location: ?mod=page&act=home");
}