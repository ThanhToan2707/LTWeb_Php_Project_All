<?php
include_once("models/pdo.php");

//them binh luan
function comment_add($MaTK, $MaSach, $NoiDung)
{
    $sql = "INSERT INTO camnghi (MaTK, MaSach, NoiDung) VALUES (?,?,?)";
    //Thuc thi truy van insert, update, delete
    pdo_execute($sql, $MaTK, $MaSach, $NoiDung);
}

//lay tat ca binh luan cua 1 cuon sach
function comment_getCommentsByBook($MaSach)
{
    $sql = "SELECT cn.*, tk.HoTen FROM camnghi cn INNER JOIN taikhoan tk ON cn.MaTK = tk.MaTK WHERE MaSach=? ORDER BY NgayGui DESC";
    return pdo_getAll($sql, $MaSach);
}