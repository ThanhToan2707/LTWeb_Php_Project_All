<?php
// tiep nha yc cua ng dung
//su dung de dieu huong den cac controllers

//khai bao bien taon cuc
$baseUrl = "http://localhost/qlthuvien/";

//Khai bao session
session_start();

//Controller nhiem vu ket noi giua Model va View
//Dieu huong den c_page
if (isset($_GET['mod'])) {

    switch ($_GET['mod']) {
        case 'page':
            include_once("controllers/c_page.php");
            break;
        case 'user':
            include_once("controllers/c_user.php");
            break;
        case 'book':
            include_once("controllers/c_book.php");
            break;

        case 'comment':
            include_once("controllers/c_comment.php");
            break;

        default:
            include_once("controllers/c_page.php");
            break;
    }
} else {
    //chuyen dem trang home
    header("Location: ?mod=page&act=home");
}
//Model tuong tac voi Database de lay du lieu

//View hien thi giao dien