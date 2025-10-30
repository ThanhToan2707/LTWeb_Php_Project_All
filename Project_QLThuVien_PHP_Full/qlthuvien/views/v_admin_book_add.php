<h2 class="my-3">Thêm sách mới</h2>

<!-- enctype="multipart/form-data dung upload hinh anh khi dung type="file" -->
<form method="post" action="admin.php?mod=book&act=postAdd" enctype="multipart/form-data" class="mb-3">
    <div class="mb-3">
        <label for="TuaSach" class="form-label">Tựa sách <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="TuaSach" name="TuaSach" required>
    </div>
    <div class="mb-3">
        <label for="HinhAnh" class="form-label">Hình ảnh</label>
        <input type="file" class="form-control" id="HinhAnh" name="HinhAnh">
    </div>
    <div class="mb-3">
        <label for="TacGia" class="form-label">Tác giả <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="TacGia" name="TacGia" required>
    </div>
    <div class="mb-3">
        <label for="GiaTri" class="form-label">Giá trị <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="GiaTri" name="GiaTri" min="0" required>
    </div>
    <div class="mb-3">
        <label for="MoTa" class="form-label">Mô tả</label>
        <textarea name="MoTa" id="MoTa" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="ChuDe" class="form-label">Chủ đề <span class="text-danger">*</span></label>
        <select name="ChuDe" id="ChuDe" class="form-select" required>
            <option value="">Chọn chủ đề</option>
            <?php foreach ($subjectList as $subject): ?>
                <option value="<?= $subject['MaCD'] ?>"><?= $subject['TenChuDe'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="SoLuong" class="form-label">Số lượng <span class="text-danger">*</span></label>
        <input type="number" class="form-control" id="SoLuong" name="SoLuong" min="1" required>
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="GhimTrangChu" name="GhimTrangChu" value="1">
            <label for="GhimTrangChu" class="form-check-label">Ghim trang chủ</label>
        </div>
    </div>

    <div class="mb-3">
        <small class="text-muted">
            <span class="text-danger">*</span> Các trường bắt buộc phải điền
        </small>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm mới
        </button>
        <a href="admin.php?mod=book&act=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</form>