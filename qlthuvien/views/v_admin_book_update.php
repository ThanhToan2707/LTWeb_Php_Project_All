<h2 class="my-3">Cập nhật sách #<?= $book['MaSach'] ?></h2>
<!-- thong bao cap nhat thanh cong -->
<?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['alert'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php unset($_SESSION['alert']); ?>

<!-- enctype="multipart/form-data dung upload hinh anh khi dung type="file" -->
<form method="post" action="admin.php?mod=book&act=postUpdate" enctype="multipart/form-data" class="mb-3">
    <!-- lay thong tin ma sach theo id-->
    <input type="hidden" name="MaSach" value="<?= $book['MaSach'] ?>">
    <div class="mb-3">
        <label for="TuaSach" class="form-label">Tựa sách </label>
        <input type="text" class="form-control" id="TuaSach" name="TuaSach" value="<?= $book['TuaSach'] ?>">
    </div>
    <div class="mb-3">
        <label for="HinhAnh" class="form-label">Hình ảnh</label>
        <img src="<?= $baseUrl ?>upload/product/<?= $book['HinhAnh'] ?>" class="rounded-3 mb-2" style="width: 128px;">
        <input type="file" class="form-control" id="HinhAnh" name="HinhAnh">
        <input type="hidden" name="HinhAnhHienTai" value="<?= $book['HinhAnh'] ?>">
    </div>
    <div class="mb-3">
        <label for="TacGia" class="form-label">Tác giả </label>
        <input type="text" class="form-control" id="TacGia" name="TacGia" value="<?= $book['TacGia'] ?>">
    </div>
    <div class="mb-3">
        <label for="GiaTri" class="form-label">Giá trị </label>
        <input type="number" class="form-control" id="GiaTri" name="GiaTri" min="0" value="<?= $book['GiaTri'] ?>">
    </div>
    <div class="mb-3">
        <label for="MoTa" class="form-label">Mô tả</label>
        <textarea name="MoTa" id="MoTa" class="form-control" rows="3"><?= $book['MoTa'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="ChuDe" class="form-label">Chủ đề </label>
        <select name="ChuDe" id="ChuDe" class="form-select">
            <option value="">Chọn chủ đề</option>
            <?php foreach ($subjectList as $subject): ?>
                <option value="<?= $subject['MaCD'] ?>" <?= $subject['MaCD'] == $book['MaCD'] ? "selected" : "" ?>>
                    <?= $subject['TenChuDe'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="SoLuong" class="form-label">Số lượng </label>
        <input type="number" class="form-control" id="SoLuong" name="SoLuong" min="1" value="<?= $book['SoLuong'] ?>"
            required>
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="GhimTrangChu" name="GhimTrangChu" value="1"
                <?= $book['GhimTrangChu'] == 1 ? 'checked' : '' ?>>
            <label for="GhimTrangChu" class="form-check-label">Ghim trang chủ</label>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-plus"></i> Lưu cập nhật
        </button>
        <a href="admin.php?mod=book&act=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</form>