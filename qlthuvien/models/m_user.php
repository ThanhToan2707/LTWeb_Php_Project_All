<?php
include_once("models/pdo.php");

//lay so dien thoai va mat khau
function user_login($SoDienThoai, $MatKhau)
{
    $sql = "SELECT * FROM TaiKhoan WHERE SoDienThoai=? AND MatKhau=?";
    return pdo_getOne($sql, $SoDienThoai, md5($MatKhau));
}

//kiểm tra so dien thoai da ton tai chua
function user_checkPhone($SoDienThoai)
{
    $sql = "SELECT * FROM TaiKhoan WHERE SoDienThoai=?";
    $user = pdo_getOne($sql, $SoDienThoai);
    if (isset($user['MaTK'])) {
        return true; //So dien thoai da ton tai
    } else {
        return false; //So dien thoai chua ton tai
    }
}

//kiểm tra so dien thoai da ton tai chua (trừ user hiện tại khi update)
function user_checkPhoneExcept($SoDienThoai, $MaTK)
{
    $sql = "SELECT * FROM TaiKhoan WHERE SoDienThoai=? AND MaTK!=?";
    $user = pdo_getOne($sql, $SoDienThoai, $MaTK);
    return isset($user['MaTK']);
}

//dang ky tai khoan moi
function user_register($HoTen, $SoDienThoai, $MatKhau)
{
    $sql = "INSERT INTO TaiKhoan (HoTen, SoDienThoai, MatKhau) VALUES (?,?,?)";
    //Thuc thi truy van insert, update, delete
    pdo_execute($sql, $HoTen, $SoDienThoai, md5($MatKhau));
}

//dem so luong tai khoan cho phan tong quat
function user_count()
{
    $sql = "SELECT COUNT(*) FROM taikhoan";
    return pdo_getValue($sql);
}

//lay tat ca tai khoan
function user_getAll()
{
    $sql = "SELECT * FROM TaiKhoan ORDER BY MaTK DESC";
    return pdo_getAll($sql);
}

//lay thong tin tai khoan theo ID
function user_getById($MaTK)
{
    $sql = "SELECT * FROM TaiKhoan WHERE MaTK = ?";
    return pdo_getOne($sql, $MaTK);
}

//them tai khoan moi (admin)
function user_add($HoTen, $SoDienThoai, $MatKhau, $Quyen, $TrangThai = 1)
{
    // Kiểm tra xem bảng có cột TrangThai không
    $conn = pdo_connect();
    $checkColumn = $conn->query("SHOW COLUMNS FROM TaiKhoan LIKE 'TrangThai'");
    $hasTrangThai = $checkColumn->rowCount() > 0;
    unset($conn);

    if ($hasTrangThai) {
        $sql = "INSERT INTO TaiKhoan (HoTen, SoDienThoai, MatKhau, Quyen, TrangThai) VALUES (?,?,?,?,?)";
        return pdo_execute($sql, $HoTen, $SoDienThoai, md5($MatKhau), $Quyen, $TrangThai);
    } else {
        $sql = "INSERT INTO TaiKhoan (HoTen, SoDienThoai, MatKhau, Quyen) VALUES (?,?,?,?)";
        return pdo_execute($sql, $HoTen, $SoDienThoai, md5($MatKhau), $Quyen);
    }
}

//cap nhat thong tin tai khoan
function user_update($MaTK, $HoTen, $SoDienThoai, $Quyen, $TrangThai = 1)
{
    // Kiểm tra xem bảng có cột TrangThai không
    $conn = pdo_connect();
    $checkColumn = $conn->query("SHOW COLUMNS FROM TaiKhoan LIKE 'TrangThai'");
    $hasTrangThai = $checkColumn->rowCount() > 0;
    unset($conn);

    if ($hasTrangThai) {
        $sql = "UPDATE TaiKhoan SET HoTen=?, SoDienThoai=?, Quyen=?, TrangThai=? WHERE MaTK=?";
        return pdo_execute($sql, $HoTen, $SoDienThoai, $Quyen, $TrangThai, $MaTK);
    } else {
        $sql = "UPDATE TaiKhoan SET HoTen=?, SoDienThoai=?, Quyen=? WHERE MaTK=?";
        return pdo_execute($sql, $HoTen, $SoDienThoai, $Quyen, $MaTK);
    }
}

//cap nhat mat khau
function user_updatePassword($MaTK, $MatKhau)
{
    $sql = "UPDATE TaiKhoan SET MatKhau=? WHERE MaTK=?";
    return pdo_execute($sql, md5($MatKhau), $MaTK);
}

//xoa tai khoan
function user_delete($MaTK)
{
    $sql = "DELETE FROM TaiKhoan WHERE MaTK=?";
    return pdo_execute($sql, $MaTK);
}

//kiem tra user co lich su muon sach khong
function user_hasHistory($MaTK)
{
    $sql = "SELECT COUNT(*) FROM lichsu WHERE MaTK=?";
    $count = pdo_getValue($sql, $MaTK);
    return $count > 0;
}

//cap nhat trang thai tai khoan
function user_updateStatus($MaTK, $TrangThai)
{
    // Kiểm tra xem bảng có cột TrangThai không
    $conn = pdo_connect();
    $checkColumn = $conn->query("SHOW COLUMNS FROM TaiKhoan LIKE 'TrangThai'");
    $hasTrangThai = $checkColumn->rowCount() > 0;
    unset($conn);

    if ($hasTrangThai) {
        $sql = "UPDATE TaiKhoan SET TrangThai=? WHERE MaTK=?";
        return pdo_execute($sql, $TrangThai, $MaTK);
    } else {
        // Nếu không có cột TrangThai thì không làm gì
        return false;
    }
}