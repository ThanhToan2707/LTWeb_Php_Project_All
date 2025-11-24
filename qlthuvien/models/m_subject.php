<?php
//ket noi csdl
include_once("models/pdo.php");

//lay ra tat ca chu de 
function subject_getAll()
{
    $sql = "SELECT * FROM chude ORDER BY MaCD DESC";
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

//lay thong tin chu de theo ID
function subject_getById($MaCD)
{
    $sql = "SELECT * FROM chude WHERE MaCD = ?";
    return pdo_getOne($sql, $MaCD);
}

//them chu de moi
function subject_add($TenChuDe)
{
    $sql = "INSERT INTO chude (TenChuDe) VALUES (?)";
    return pdo_execute($sql, $TenChuDe);
}

//cap nhat thong tin chu de
function subject_update($MaCD, $TenChuDe)
{
    $sql = "UPDATE chude SET TenChuDe = ? WHERE MaCD = ?";
    return pdo_execute($sql, $TenChuDe, $MaCD);
}

//xoa chu de
function subject_delete($MaCD)
{
    $sql = "DELETE FROM chude WHERE MaCD = ?";
    return pdo_execute($sql, $MaCD);
}

//kiem tra chu de co sach khong
function subject_hasBooks($MaCD)
{
    $sql = "SELECT COUNT(*) FROM sach WHERE MaCD = ?";
    $count = pdo_getValue($sql, $MaCD);
    return $count > 0;
}
