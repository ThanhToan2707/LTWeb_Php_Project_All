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
    $sql = "SELECT 
                cn.*, 
                tk.HoTen,
                COALESCE(COUNT(DISTINCT ls.MaLS), 0) AS SoLanMuon
            FROM camnghi cn 
            INNER JOIN taikhoan tk ON cn.MaTK = tk.MaTK 
            LEFT JOIN lichsu ls ON ls.MaTK = cn.MaTK
            LEFT JOIN chitietlichsu ctls ON ls.MaLS = ctls.MaLS AND ctls.MaSach = ?
            WHERE cn.MaSach = ? 
            GROUP BY cn.MaCN, cn.MaTK, cn.MaSach, cn.NoiDung, cn.NgayGui, tk.HoTen
            ORDER BY cn.NgayGui DESC";
    return pdo_getAll($sql, $MaSach, $MaSach);
}