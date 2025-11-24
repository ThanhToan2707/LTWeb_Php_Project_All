<?php
//ket noi csdl
include_once("models/pdo.php");

//lay sach noi bat(nhieu luot xem)
function book_getHotBooks()
{
    $sql = "SELECT * FROM sach ORDER BY LuotXem DESC LIMIT 9";
    return pdo_getAll($sql);
}

//lay sach moi nhat
function book_getNewBooks()
{
    $sql = "SELECT * FROM sach ORDER BY MaSach DESC LIMIT 8";
    return pdo_getAll($sql);
}

// lay ra chi tiet 1 cuon sach
function book_getBookById($id)
{
    $sql = "SELECT * FROM sach s Inner Join chude cd On s.MaCD = cd.MaCD WHERE MaSach=?";
    return pdo_getOne($sql, $id);
}

//lay ra ngau nhieu 4 cuon sach cung chu de
function book_getRandomBooksByCategory($id)
{
    $sql = "SELECT * FROM sach WHERE MaCD=? ORDER BY RAND() LIMIT 4";
    return pdo_getAll($sql, $id);
}

// Tìm sách theo tựa (search)
function book_search($q)
{
    // Tìm theo tựa sách, tác giả hoặc mô tả để tăng khả năng khớp kết quả
    $sql = "SELECT * FROM sach s INNER JOIN chude cd ON s.MaCD = cd.MaCD ";
    $sql .= "WHERE s.TuaSach LIKE ? OR s.TacGia LIKE ? OR s.MoTa LIKE ? ";
    $sql .= "ORDER BY s.MaSach DESC";
    $like = '%' . $q . '%';
    return pdo_getAll($sql, $like, $like, $like);
}

//lay ra tat ca sach
function book_getAll()
{
    $sql = "SELECT * FROM sach s INNER JOIN chude cd ON s.MaCD = cd.MaCD ORDER BY s.MaSach DESC";
    return pdo_getAll($sql);
}

//them sach moi  
function book_add($TuaSach, $HinhAnh, $TacGia, $GiaTri, $MoTa, $ChuDe, $SoLuong, $GhimTrangChu)
{
    $sql = "INSERT INTO sach(TuaSach, HinhAnh, TacGia, GiaTri, MoTa, MaCD, SoLuong, GhimTrangChu) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $TuaSach, $HinhAnh, $TacGia, $GiaTri, $MoTa, $ChuDe, $SoLuong, $GhimTrangChu);
}

//cap nhat thong tin sach
function book_update($MaSach, $TuaSach, $HinhAnh, $TacGia, $GiaTri, $MoTa, $ChuDe, $SoLuong, $GhimTrangChu)
{
    $sql = "UPDATE sach SET TuaSach=?, HinhAnh=?, TacGia=?, GiaTri=?, MoTa=?, MaCD=?, SoLuong=?, GhimTrangChu=? WHERE MaSach=?";
    pdo_execute($sql, $TuaSach, $HinhAnh, $TacGia, $GiaTri, $MoTa, $ChuDe, $SoLuong, $GhimTrangChu, $MaSach);
}

//xoa sach
function book_delete($MaSach)
{
    $sql = "DELETE FROM sach WHERE MaSach=?";
    pdo_execute($sql, $MaSach);
}

//dem so luong sach cho phan tong quat
function book_count()
{
    $sql = "SELECT COUNT(*) FROM sach";
    return pdo_getValue($sql);
}