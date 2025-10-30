<?php
//ket noi csdl
include_once("models/pdo.php");

//them lich su muon sach vao csdl 
function history_add($MaTK, $NgayMuon, $NgayTra, $SoSachMuon, $TongTien, $TrangThai)
{
    $sql = "INSERT INTO lichsu(MaTK, NgayMuon, NgayTra, SoSachMuon, TongTien, TrangThai) VALUES(?, ?, ?, ?, ?, ?)";
    return pdo_insert($sql, $MaTK, $NgayMuon, $NgayTra, $SoSachMuon, $TongTien, $TrangThai);
}

//them chi tiet lich su muon sach vao csdl
function history_addDetail($MaLS, $MaSach, $SoLuong)
{
    $sql = "INSERT INTO chitietlichsu(MaLS, MaSach, SoLuong) VALUES(?, ?, ?)";
    pdo_execute($sql, $MaLS, $MaSach, $SoLuong);
}

//lay tat ca lich su muon sach 
function history_getAll()
{
    $sql = "SELECT ls.*, tk.HoTen, tk.SoDienThoai 
            FROM lichsu ls INNER JOIN taikhoan tk ON ls.MaTK = tk.MaTK ORDER BY ls.NgayMuon DESC";
    return pdo_getAll($sql);
}

//lay lich su muon sach theo ma lich su 
function history_getById($MaLS)
{
    $sql = "SELECT ls.*, tk.HoTen
            FROM lichsu ls INNER JOIN taikhoan tk ON ls.MaTK = tk.MaTK WHERE ls.MaLS=?";
    return pdo_getOne($sql, $MaLS);
}

//lay chi tiet lich su muon sach theo ma lich su
function history_getDetailById($MaLS)
{
    $sql = "SELECT ctls.*, s.TuaSach, s.HinhAnh FROM chitietlichsu ctls INNER JOIN sach s ON ctls.MaSach = s.MaSach WHERE ctls.MaLS=?";
    return pdo_getAll($sql, $MaLS);
}

//cap nhat trang thai don hang 
function history_updateStatus($MaLS, $TrangThai)
{
    $sql = "UPDATE lichsu SET TrangThai=? WHERE MaLS=?";
    pdo_execute($sql, $TrangThai, $MaLS);
}

//dem so luong lich su muon sach cho phan tong quat
function history_count()
{
    $sql = "SELECT COUNT(*) FROM lichsu where TrangThai = ? OR TrangThai = ?";
    return pdo_getValue($sql, 'dang-muon', 'da-tra');
}

//thong ke doanh thu theo thang 
function history_income()
{
    $sql = "SELECT year(NgayMuon) as Nam, month(NgayMuon) as Thang, sum(TongTien) as DoanhThu FROM lichsu GROUP BY year(NgayMuon), month(NgayMuon) order by year(NgayMuon) asc, month(NgayMuon) asc";
    return pdo_getAll($sql);
}