<?php
//ket noi csdl
include_once("models/pdo.php");

//lay ra tat ca chu de 
function subject_getAll()
{
    $sql = "SELECT * FROM chude";
    return pdo_getAll($sql);
}

//dem so luong chu de cho phan tong quat
function subject_count()
{
    $sql = "SELECT COUNT(*) FROM chude";
    return pdo_getValue($sql);
}

//thong ke so luong sach 
function subject_countBook()
{
    // Đếm số sách cho mỗi chủ đề; dùng LEFT JOIN để hiển thị cả chủ đề có 0 sách
    $sql = "SELECT cd.MaCD, cd.TenChuDe, COUNT(s.MaSach) AS SoLuongSach
            FROM chude cd
            LEFT JOIN sach s ON s.MaCD = cd.MaCD
            GROUP BY cd.MaCD, cd.TenChuDe
            ORDER BY cd.MaCD";
    return pdo_getAll($sql);
}
