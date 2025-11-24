<?php
//quan ly cac trang lien quan den chu de (subject/category)
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        //Lay ra danh sach tat ca chu de
        case 'list': //admin.php?mod=subject&act=list
            //xu ly
            include_once("models/m_subject.php");
            $subjectList = subject_getAll();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_subject_list.php");
            include_once("views/v_admin_footer.php");
            break;

        //Them chu de moi
        case 'add': //admin.php?mod=subject&act=add
            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_subject_add.php");
            include_once("views/v_admin_footer.php");
            break;

        //Xu ly khi them chu de moi 
        case 'postAdd': //admin.php?mod=subject&act=postAdd
            //xu ly
            $TenChuDe = trim($_POST['TenChuDe']);

            // Kiểm tra dữ liệu đầu vào
            if (empty($TenChuDe)) {
                $_SESSION['alert'] = 'Tên chủ đề không được để trống';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=subject&act=add");
                exit();
            }

            include_once("models/m_subject.php");
            subject_add($TenChuDe);

            // Thêm thông báo thành công
            $_SESSION['alert'] = 'Thêm chủ đề mới thành công';
            $_SESSION['alert_type'] = 'success';
            // Chuyển hướng về danh sách chủ đề
            header("Location: admin.php?mod=subject&act=list");
            break;

        //Hien thi thong tin chu de len cac truong de cap nhat
        case 'update': //admin.php?mod=subject&act=update&id=?
            //xu ly
            include_once("models/m_subject.php");
            $MaCD = $_GET['id'];
            $subject = subject_getById($MaCD);

            if (!$subject) {
                $_SESSION['alert'] = 'Không tìm thấy chủ đề';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=subject&act=list");
                exit();
            }

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_subject_update.php");
            include_once("views/v_admin_footer.php");
            break;

        //Xu ly khi cap nhat thong tin chu de
        case 'postUpdate': //admin.php?mod=subject&act=postUpdate
            //xu ly
            $MaCD = $_POST['MaCD'];
            $TenChuDe = trim($_POST['TenChuDe']);

            // Kiểm tra dữ liệu đầu vào
            if (empty($TenChuDe)) {
                $_SESSION['alert'] = 'Tên chủ đề không được để trống';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=subject&act=update&id=" . $MaCD);
                exit();
            }

            include_once("models/m_subject.php");
            subject_update($MaCD, $TenChuDe);

            // Thêm thông báo thành công
            $_SESSION['alert'] = 'Cập nhật thông tin chủ đề thành công';
            $_SESSION['alert_type'] = 'success';
            // Chuyển hướng về danh sách chủ đề
            header("Location: admin.php?mod=subject&act=list");
            break;

        //Xoa chu de
        case 'delete': //admin.php?mod=subject&act=delete&id=?
            //xu ly
            $MaCD = $_GET['id'];
            include_once("models/m_subject.php");

            // Kiểm tra xem chủ đề có sách không
            if (subject_hasBooks($MaCD)) {
                $_SESSION['alert'] = 'Không thể xóa chủ đề này vì vẫn còn sách thuộc chủ đề này. Vui lòng xóa hoặc chuyển các sách sang chủ đề khác trước.';
                $_SESSION['alert_type'] = 'warning';
            } else {
                subject_delete($MaCD);
                $_SESSION['alert'] = 'Xóa chủ đề thành công';
                $_SESSION['alert_type'] = 'success';
            }

            // Chuyển hướng về danh sách chủ đề
            header("Location: admin.php?mod=subject&act=list");
            break;

        default:
            //chuyen den trang danh sach
            header("Location: admin.php?mod=subject&act=list");
            break;
    }
} else {
    //chuyen den trang danh sach
    header("Location: admin.php?mod=subject&act=list");
}
