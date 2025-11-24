<h2 class="my-3">Thêm chủ đề mới</h2>

<!-- Hiển thị thông báo lỗi nếu có -->
<?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?= isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : 'danger' ?> alert-dismissible fade show"
        role="alert">
        <?= $_SESSION['alert'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php unset($_SESSION['alert']);
unset($_SESSION['alert_type']); ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="admin.php?mod=subject&act=postAdd" class="mb-3">
            <div class="mb-3">
                <label for="TenChuDe" class="form-label">Tên chủ đề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenChuDe" name="TenChuDe" placeholder="Nhập tên chủ đề..."
                    required autofocus maxlength="255">
                <div class="form-text">Ví dụ: Tiểu thuyết, Khoa học, Lịch sử, Văn học...</div>
            </div>

            <div class="mb-3">
                <small class="text-muted">
                    <span class="text-danger">*</span> Trường bắt buộc phải điền
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm chủ đề
                </button>
                <a href="admin.php?mod=subject&act=list" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Focus vào input khi tải trang
    document.getElementById('TenChuDe').focus();
</script>