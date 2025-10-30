<?php
//quan ly cac trang roi rac home, abourt, contact
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        case 'home':
            //xu ly
            include_once("models/m_book.php");
            // Nếu có từ khóa tìm kiếm q, sử dụng chức năng search
            $searchResults = null;
            if (isset($_GET['q']) && trim($_GET['q']) !== '') {
                $q = trim($_GET['q']);
                $searchResults = book_search($q);
            }
            //lay ra danh sach sach noi bat
            $hotBooks = book_getHotBooks();
            //lay ra danh sach sach moi nhat
            $newBooks = book_getNewBooks();

            //hien thi len view
            include_once("views/v_header.php");
            include_once("views/v_page_home.php");
            include_once("views/v_footer.php");
            break;

        case 'about':
            # code...
            break;

        case 'contact':
            # code...
            break;

        default:
            # code...
            break;
    }
} else {
    //chuyen den trang home
    header("Location: ?mod=page&act=home");
}