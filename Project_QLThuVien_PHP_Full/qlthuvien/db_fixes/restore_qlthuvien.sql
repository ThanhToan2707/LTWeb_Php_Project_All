-- SQL helper: restore_qlthuvien.sql
-- Purpose: non-destructive ALTERs to add missing columns and full CREATE TABLE statements
-- Usage: inspect and run the ALTER statements first. If a table is missing entirely, run the matching CREATE TABLE.

/* ---------------------------
   1) Safe ALTER statements
   Run these first. They attempt to add missing columns with conservative defaults.
   --------------------------- */

-- Add SoLuong to sach if missing
ALTER TABLE `sach`
  ADD COLUMN IF NOT EXISTS `SoLuong` INT NOT NULL DEFAULT 0 AFTER `MaCD`;

-- Add SoLuong to chitietlichsu if missing
ALTER TABLE `chitietlichsu`
  ADD COLUMN IF NOT EXISTS `SoLuong` INT NOT NULL DEFAULT 1 AFTER `MaSach`;

-- Add other common columns that app references (try to be safe)
ALTER TABLE `sach`
  ADD COLUMN IF NOT EXISTS `GhimTrangChu` BIT(1) DEFAULT b'0',
  ADD COLUMN IF NOT EXISTS `SoCamNghi` INT DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `LuotDoc` INT DEFAULT 0,
  ADD COLUMN IF NOT EXISTS `LuotXem` INT DEFAULT 0;


/* ---------------------------
   2) CREATE TABLE statements (use only if a table is missing)
   If SHOW TABLES shows a table is absent, run the appropriate CREATE TABLE block.
   These are taken from a compatible demo SQL; adjust engine/charset if needed.
   --------------------------- */

-- CREATE TABLE sach
CREATE TABLE IF NOT EXISTS `sach` (
  `MaSach` int NOT NULL AUTO_INCREMENT,
  `TuaSach` varchar(255) NOT NULL,
  `HinhAnh` varchar(255) NOT NULL,
  `TacGia` varchar(255) NOT NULL,
  `GiaTri` int NOT NULL DEFAULT 0,
  `MoTa` text NOT NULL,
  `MaCD` int NOT NULL,
  `SoLuong` int NOT NULL DEFAULT 0,
  `GhimTrangChu` bit(1) DEFAULT b'0',
  `SoCamNghi` int DEFAULT 0,
  `LuotDoc` int DEFAULT 0,
  `LuotXem` int DEFAULT 0,
  PRIMARY KEY (`MaSach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CREATE TABLE lichsu
CREATE TABLE IF NOT EXISTS `lichsu` (
  `MaLS` int NOT NULL AUTO_INCREMENT,
  `MaTK` int NOT NULL,
  `NgayMuon` datetime NOT NULL,
  `NgayTra` datetime NOT NULL,
  `SoSachMuon` int NOT NULL DEFAULT 0,
  `TongTien` int NOT NULL DEFAULT 0,
  `TrangThai` set('gio-sach','chuan-bi','cho-giao','dang-muon','da-tra') NOT NULL DEFAULT 'gio-sach',
  PRIMARY KEY (`MaLS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CREATE TABLE chitietlichsu
CREATE TABLE IF NOT EXISTS `chitietlichsu` (
  `MaLS` int NOT NULL,
  `MaSach` int NOT NULL,
  `SoLuong` int NOT NULL DEFAULT 1,
  KEY `MaLS_idx` (`MaLS`),
  KEY `MaSach_idx` (`MaSach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* ---------------------------
   3) Notes
   - If ALTER TABLE fails with "Table doesn't exist in engine", that indicates InnoDB metadata corruption.
     In that case, you must restore from a SQL dump or recover InnoDB tablespace files.
   - Always BACKUP current database or export affected tables before running CREATE/ALTER.
   - If your phpMyAdmin/MySQL is < 8.0 and does not support IF NOT EXISTS for ADD COLUMN, run a small check first:
       SHOW COLUMNS FROM `sach` LIKE 'SoLuong';
     and only run ALTER if no rows returned.
*/
