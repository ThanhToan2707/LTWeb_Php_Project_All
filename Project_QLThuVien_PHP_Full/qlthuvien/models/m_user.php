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