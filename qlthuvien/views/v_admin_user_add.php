<h2 class="my-3">Thêm tài khoản mới</h2>

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
        <form method="post" action="admin.php?mod=user&act=postAdd" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="HoTen" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="HoTen" name="HoTen" placeholder="Nhập họ tên..."
                            required autofocus maxlength="100">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="SoDienThoai" class="form-label">Số điện thoại <span
                                class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai"
                            placeholder="Nhập số điện thoại..." pattern="[0-9]{10}" required maxlength="10">
                        <div class="form-text">Định dạng: 10 chữ số (VD: 0123456789)</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="MatKhau" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="MatKhau" name="MatKhau"
                            placeholder="Nhập mật khẩu..." required minlength="6">
                        <div class="form-text">Tối thiểu 6 ký tự</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="Quyen" class="form-label">Quyền <span class="text-danger">*</span></label>
                        <select name="Quyen" id="Quyen" class="form-select" required>
                            <option value="0" selected>Người dùng</option>
                            <option value="1">Thủ thư</option>
                            <option value="2">Admin</option>
                        </select>
                        <div class="form-text">
                            <small>
                                <strong>Người dùng:</strong> Chỉ mượn/trả sách<br>
                                <strong>Thủ thư:</strong> Quản lý sách, mượn/trả<br>
                                <strong>Admin:</strong> Toàn quyền
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="TrangThai" name="TrangThai" value="1" checked>
                    <label for="TrangThai" class="form-check-label">Kích hoạt tài khoản ngay</label>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Lưu ý:</strong> Mật khẩu sẽ được mã hóa tự động khi lưu vào hệ thống.
            </div>

            <div class="mb-3">
                <small class="text-muted">
                    <span class="text-danger">*</span> Trường bắt buộc phải điền
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm tài khoản
                </button>
                <a href="admin.php?mod=user&act=list" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>