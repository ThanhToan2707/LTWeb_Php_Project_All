<?php
//admin.php?mod=page&act=dashboard
//quan ly cac trang roi rac dashboard, setting, profile
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        case 'dashboard':
            //xu ly
            include_once("models/m_book.php");
            $soSach = book_count(); //dem so luong sach
            include_once("models/m_user.php");
            $soTaiKhoan = user_count(); //dem so luong tai khoan
            include_once("models/m_subject.php");
            $soChuDe = subject_count(); //dem so luong chu de
            include_once("models/m_history.php");
            $soLuotMuon = history_count(); //dem so luong don hang
            //lay ra doanh thu theo thang
            $incomeList = history_income();
            //thong ke sach duoc muon 
            $thongKeSach = subject_countBook();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_page_dashboard.php");
            include_once("views/v_admin_footer.php");
            break;

        default:
            # code...
            break;
    }
} else {
    //chuyen den trang home
    header("Location: ?mod=page&act=home");
}