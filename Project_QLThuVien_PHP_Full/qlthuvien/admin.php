<?php
// tiep nha yc cua ng dung
//su dung de dieu huong den cac controllers

//khai bao bien taon cuc
$baseUrl = "http://localhost/qlthuvien/";

//Khai bao session
session_start();

//Kiem tra dang nhap quyen admin (neuchua dang nhap hoac =1 la ng dung thi chuyen den trang home, neu 1 va 2 la admin)
if (!isset($_SESSION['user']) || $_SESSION['user']['Quyen'] == 0) {
    //chuyen den trang home
    header("Location: index.php?mod=page&act=home");
}

//Controller nhiem vu ket noi giua Model va View
//Dieu huong den c_page
if (isset($_GET['mod'])) {

    switch ($_GET['mod']) {
        case 'page':
            include_once("controllers/c_admin_page.php");
            break;
        case 'user':
            include_once("controllers/c_admin_user.php");
            break;
        case 'book':
            include_once("controllers/c_admin_book.php");
            break;

        case 'comment':
            include_once("controllers/c_admin_comment.php");
            break;

        default:
            include_once("controllers/c_admin_page.php");
            break;
    }
} else {
    //chuyen dem trang home
    header("Location: ?mod=page&act=home");
}
//Model tuong tac voi Database de lay du lieu

//View hien thi giao dien