<?php
//quan ly cac trang lien quan den tai khoan nguoi dung
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        //Lay ra danh sach tat ca tai khoan
        case 'list': //admin.php?mod=user&act=list
            //xu ly
            include_once("models/m_user.php");
            $userList = user_getAll();

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_user_list.php");
            include_once("views/v_admin_footer.php");
            break;

        //Them tai khoan moi
        case 'add': //admin.php?mod=user&act=add
            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_user_add.php");
            include_once("views/v_admin_footer.php");
            break;

        //Xu ly khi them tai khoan moi 
        case 'postAdd': //admin.php?mod=user&act=postAdd
            //xu ly
            $HoTen = trim($_POST['HoTen']);
            $SoDienThoai = trim($_POST['SoDienThoai']);
            $MatKhau = trim($_POST['MatKhau']);
            $Quyen = $_POST['Quyen'];
            $TrangThai = isset($_POST['TrangThai']) ? 1 : 0;

            // Kiểm tra dữ liệu đầu vào
            include_once("models/m_user.php");

            if (empty($HoTen) || empty($SoDienThoai) || empty($MatKhau)) {
                $_SESSION['alert'] = 'Vui lòng điền đầy đủ thông tin bắt buộc';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=add");
                exit();
            }

            // Kiểm tra số điện thoại đã tồn tại chưa
            if (user_checkPhone($SoDienThoai)) {
                $_SESSION['alert'] = 'Số điện thoại đã tồn tại trong hệ thống';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=add");
                exit();
            }

            // Validate số điện thoại
            if (!preg_match('/^[0-9]{10}$/', $SoDienThoai)) {
                $_SESSION['alert'] = 'Số điện thoại không hợp lệ (phải là 10 chữ số)';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=add");
                exit();
            }

            user_add($HoTen, $SoDienThoai, $MatKhau, $Quyen, $TrangThai);

            // Thêm thông báo thành công
            $_SESSION['alert'] = 'Thêm tài khoản mới thành công';
            $_SESSION['alert_type'] = 'success';
            // Chuyển hướng về danh sách
            header("Location: admin.php?mod=user&act=list");
            break;

        //Hien thi thong tin tai khoan len cac truong de cap nhat
        case 'update': //admin.php?mod=user&act=update&id=?
            //xu ly
            include_once("models/m_user.php");
            $MaTK = $_GET['id'];
            $user = user_getById($MaTK);

            if (!$user) {
                $_SESSION['alert'] = 'Không tìm thấy tài khoản';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=list");
                exit();
            }

            //hien thi len view
            include_once("views/v_admin_header.php");
            include_once("views/v_admin_user_update.php");
            include_once("views/v_admin_footer.php");
            break;

        //Xu ly khi cap nhat thong tin tai khoan
        case 'postUpdate': //admin.php?mod=user&act=postUpdate
            //xu ly
            $MaTK = $_POST['MaTK'];
            $HoTen = trim($_POST['HoTen']);
            $SoDienThoai = trim($_POST['SoDienThoai']);
            $Quyen = $_POST['Quyen'];
            $TrangThai = isset($_POST['TrangThai']) ? 1 : 0;
            $MatKhauMoi = trim($_POST['MatKhauMoi']);

            include_once("models/m_user.php");

            // Kiểm tra dữ liệu đầu vào
            if (empty($HoTen) || empty($SoDienThoai)) {
                $_SESSION['alert'] = 'Vui lòng điền đầy đủ thông tin bắt buộc';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=update&id=" . $MaTK);
                exit();
            }

            // Kiểm tra số điện thoại đã tồn tại chưa (trừ user hiện tại)
            if (user_checkPhoneExcept($SoDienThoai, $MaTK)) {
                $_SESSION['alert'] = 'Số điện thoại đã được sử dụng bởi tài khoản khác';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=update&id=" . $MaTK);
                exit();
            }

            // Validate số điện thoại
            if (!preg_match('/^[0-9]{10}$/', $SoDienThoai)) {
                $_SESSION['alert'] = 'Số điện thoại không hợp lệ (phải là 10 chữ số)';
                $_SESSION['alert_type'] = 'danger';
                header("Location: admin.php?mod=user&act=update&id=" . $MaTK);
                exit();
            }

            // Cập nhật thông tin cơ bản
            user_update($MaTK, $HoTen, $SoDienThoai, $Quyen, $TrangThai);

            // Nếu có mật khẩu mới thì cập nhật
            if (!empty($MatKhauMoi)) {
                user_updatePassword($MaTK, $MatKhauMoi);
                $_SESSION['alert'] = 'Cập nhật thông tin và mật khẩu thành công';
            } else {
                $_SESSION['alert'] = 'Cập nhật thông tin tài khoản thành công';
            }

            $_SESSION['alert_type'] = 'success';
            // Chuyển hướng về danh sách
            header("Location: admin.php?mod=user&act=list");
            break;

        //Xoa tai khoan
        case 'delete': //admin.php?mod=user&act=delete&id=?
            //xu ly
            $MaTK = $_GET['id'];
            include_once("models/m_user.php");

            // Không cho xóa tài khoản đang đăng nhập
            if ($MaTK == $_SESSION['user']['MaTK']) {
                $_SESSION['alert'] = 'Không thể xóa tài khoản đang đăng nhập';
                $_SESSION['alert_type'] = 'warning';
                header("Location: admin.php?mod=user&act=list");
                exit();
            }

            // Kiểm tra xem user có lịch sử mượn sách không
            if (user_hasHistory($MaTK)) {
                $_SESSION['alert'] = 'Không thể xóa tài khoản này vì đã có lịch sử mượn sách. Bạn có thể vô hiệu hóa tài khoản thay vì xóa.';
                $_SESSION['alert_type'] = 'warning';
            } else {
                user_delete($MaTK);
                $_SESSION['alert'] = 'Xóa tài khoản thành công';
                $_SESSION['alert_type'] = 'success';
            }

            // Chuyển hướng về danh sách
            header("Location: admin.php?mod=user&act=list");
            break;

        //Thay doi trang thai tai khoan
        case 'toggleStatus': //admin.php?mod=user&act=toggleStatus&id=?&status=?
            $MaTK = $_GET['id'];
            $TrangThai = $_GET['status'];

            include_once("models/m_user.php");

            // Không cho vô hiệu hóa tài khoản đang đăng nhập
            if ($MaTK == $_SESSION['user']['MaTK'] && $TrangThai == 0) {
                $_SESSION['alert'] = 'Không thể vô hiệu hóa tài khoản đang đăng nhập';
                $_SESSION['alert_type'] = 'warning';
            } else {
                user_updateStatus($MaTK, $TrangThai);
                $statusText = $TrangThai == 1 ? 'kích hoạt' : 'vô hiệu hóa';
                $_SESSION['alert'] = 'Đã ' . $statusText . ' tài khoản thành công';
                $_SESSION['alert_type'] = 'success';
            }

            header("Location: admin.php?mod=user&act=list");
            break;

        default:
            //chuyen den trang danh sach
            header("Location: admin.php?mod=user&act=list");
            break;
    }
} else {
    //chuyen den trang danh sach
    header("Location: admin.php?mod=user&act=list");
}
