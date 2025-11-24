<?php
//quan ly cac binh luan cảm nghĩ về sách
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        case 'post-comment': //?mod=comment&act=post-comment
            //xu ly du lieu tu form binh luan
            $NoiDung = $_POST['NoiDung'];
            $MaSach = $_POST['MaSach'];
            $MaTK = $_SESSION['user']['MaTK'];

            include_once("models/m_comment.php");
            comment_add($MaTK, $MaSach, $NoiDung);
            //chuyen den trang chi tiet sach
            header("Location: ?mod=book&act=detail&id=$MaSach");

            break;



        default:
            # code...
            break;
    }
} else {
    //chuyen den trang home
    header("Location: ?mod=page&act=home");
}