<?php
//quan ly cac trang dang nhap, dang ky, thoat
if (isset($_GET['act'])) {

    switch ($_GET['act']) {
        case 'login':
            //xu ly hien thi form dang nhap


            //hien thi len view
            include_once("views/v_header.php");
            include_once("views/v_user_login.php");
            include_once("views/v_footer.php");
            break;

        case 'post-login':
            //xu ly du lieu tu form dang nhap
            $SoDienThoai = $_POST['SoDienThoai'];
            $MatKhau = $_POST['MatKhau'];
            include_once("models/m_user.php");
            $user = user_login($SoDienThoai, $MatKhau);
            if (isset($user['MaTK'])) {
                echo "Dang nhap thanh cong";
                //Khong luu mat khau vao session
                unset($user['MatKhau']);
                //luu thong tin dang nhap vao session
                $_SESSION['user'] = $user;

                //chuyen den trang home
                header("Location: ?mod=page&act=home");

            } else {
                $_SESSION['alert'] = "Số điện thoại hoặc mật khẩu không đúng!";
                //Neu so dien thoai va mat khau khong dung, chuyen den trang dang nhap
                header("Location: ?mod=user&act=login");
            }
            break;

        case 'logout':
            //huy session
            unset($_SESSION['user']);
            //chuyen den trang home
            header("Location: ?mod=user&act=login");
            break;

        case 'register': //?mod=user&act=register
            //xu ly thi form dang ky


            //hien thi len view
            include_once("views/v_header.php");
            include_once("views/v_user_register.php");
            include_once("views/v_footer.php");
            break;

        case 'post-register': //?mod=user&act=post-register
            //xu ly du lieu tu form dang ky
            $HoTen = $_POST['HoTen'];
            $SoDienThoai = $_POST['SoDienThoai'];
            $MatKhau = $_POST['MatKhau'];

            include_once("models/m_user.php");
            //Kiem tra so dien thoai da ton tai chua
            $check = user_checkPhone($SoDienThoai);
            if ($check == true) {
                $_SESSION['alert'] = "Số điện thoại đã tồn tại, vui lòng sử dụng số khác!";
                //Neu so dien thoai da ton tai, chuyen den trang dang ky
                header("Location: ?mod=user&act=register");
            } else {
                //Neu so dien thoai chua ton tai, cho phep dang ky
                user_register($HoTen, $SoDienThoai, $MatKhau);
                //Thong bao dang ky thanh cong
                $_SESSION['alert2'] = "Đăng ký tài khoản thành công, vui lòng đăng nhập!";
                //chuyen den trang dang nhap
                header("Location: ?mod=user&act=login");
            }
            break;

        default:
            # code...
            break;
    }
} else {
    //chuyen den trang home
    header("Location: ?mod=page&act=home");
}