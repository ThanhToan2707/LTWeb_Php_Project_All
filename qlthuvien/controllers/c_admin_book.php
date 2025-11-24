<?php
//quan ly cac trang lien quan den sach
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        case 'order': //admin.php?mod=book&act=order
            //xu ly
            include_once("models/m_history.php");
            $historyList = history_getAll();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_book_order.php");
            include_once("views/v_admin_footer.php");
            break;

        case 'orderDetail': //admin.php?mod=book&act=orderDetail&id=?
            //xu ly
            include_once("models/m_history.php");
            $MaLS = $_GET['id'];
            $history = history_getById($MaLS);
            $historyDetail = history_getDetailById($MaLS);

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_book_orderDetail.php");
            include_once("views/v_admin_footer.php");
            break;

        case 'updateOrderStatus': //admin.php?mod=book&act=updateOrderStatus&status=?
            //xu ly
            $TrangThai = $_GET['status'];
            $MaLS = $_GET['id'];
            include_once("models/m_history.php");
            //cap nhat trang thai don hang
            history_updateStatus($MaLS, $TrangThai);
            //chuyen den trang chi tiet don hang
            header("Location: ?mod=book&act=orderDetail&id=$MaLS");
            break;

        //Lay ra danh sach tat ca sach
        case 'list': //admin.php?mod=book&act=list
            //xu ly
            include_once("models/m_book.php");
            $bookList = book_getAll();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_book_list.php");
            include_once("views/v_admin_footer.php");
            break;

        //Them sach moi
        case 'add': //admin.php?mod=book&act=add
            //xu ly
            include_once("models/m_subject.php");
            $subjectList = subject_getAll();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_book_add.php");
            include_once("views/v_admin_footer.php");
            break;

        //Xu ly khi them sach moi 
        case 'postAdd': //admin.php?mod=book&act=postAdd
            //xu ly
            $TuaSach = $_POST['TuaSach'];
            $TacGia = $_POST['TacGia'];
            $GiaTri = $_POST['GiaTri'];
            $MoTa = $_POST['MoTa'];
            $ChuDe = $_POST['ChuDe'];
            $SoLuong = $_POST['SoLuong'];
            $GhimTrangChu = isset($_POST['GhimTrangChu']) ? $_POST['GhimTrangChu'] : 0;

            if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == 0) {
                //tai len loi
                $fileName = rand(1000000, 9999999) . $_FILES['HinhAnh']['name'];
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "upload/product/$fileName");
            }
            $HinhAnh = isset($fileName) ? $fileName : '';
            include_once("models/m_book.php");
            book_add($TuaSach, $HinhAnh, $TacGia, $GiaTri, $MoTa, $ChuDe, $SoLuong, $GhimTrangChu);
            // Thêm thông báo thành công
            $_SESSION['alert'] = 'Thêm sách mới thành công';
            // Chuyển hướng về danh sách sách
            header("Location: admin.php?mod=book&act=list");
            break;

        //Hien thi thong tin sach len cac truong de cap nhat
        case 'update': //admin.php?mod=book&act=update&id=?
            //xu ly
            include_once("models/m_book.php");
            $MaSach = $_GET['id'];
            $book = book_getBookById($MaSach);

            include_once("models/m_subject.php");
            //Lay ra danh sach chu de
            $subjectList = subject_getAll();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_book_update.php");
            include_once("views/v_admin_footer.php");
            break;

        //Xu ly khi cap nhat thong tin sach
        case 'postUpdate': //admin.php?mod=book&act=postUpdate
            //xu ly
            $MaSach = $_POST['MaSach'];
            $TuaSach = $_POST['TuaSach'];
            $TacGia = $_POST['TacGia'];
            $GiaTri = $_POST['GiaTri'];
            $MoTa = $_POST['MoTa'];
            $ChuDe = $_POST['ChuDe'];
            $SoLuong = $_POST['SoLuong'];
            $GhimTrangChu = isset($_POST['GhimTrangChu']) ? $_POST['GhimTrangChu'] : 0;

            if (isset($_FILES['HinhAnh']) && $_FILES['HinhAnh']['error'] == 0) {
                //tai anh len khong loi
                $fileName = rand(1000000, 9999999) . $_FILES['HinhAnh']['name'];
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "upload/product/$fileName");
            } else {
                //neu khong thay doi anh hoac update bi loi thi lay anh hien tai
                $fileName = $_POST['HinhAnhHienTai'];
            }
            $HinhAnh = isset($fileName) ? $fileName : '';

            include_once("models/m_book.php");
            book_update($MaSach, $TuaSach, $HinhAnh, $TacGia, $GiaTri, $MoTa, $ChuDe, $SoLuong, $GhimTrangChu);
            // Thêm thông báo thành công
            $_SESSION['alert'] = 'Cập nhật thông tin sách thành công';
            // Chuyển hướng về danh sách sách
            header("Location: admin.php?mod=book&act=update&id=" . $MaSach);
            break;

        //Xoa sach
        case 'delete': //admin.php?mod=book&act=delete&id=?
            //xu ly
            $MaSach = $_GET['id'];
            include_once("models/m_book.php");
            book_delete($MaSach);
            // Thêm thông báo thành công
            $_SESSION['alert'] = 'Xóa sách thành công';
            // Chuyển hướng về danh sách sách
            header("Location: admin.php?mod=book&act=list");
            break;

    }
} else {
    //chuyen den trang home
    header("Location: ?mod=page&act=home");
}