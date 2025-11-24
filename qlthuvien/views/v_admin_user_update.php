<h2 class="my-3">Cập nhật tài khoản</h2>

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
        <form method="post" action="admin.php?mod=user&act=postUpdate" class="mb-3">
            <input type="hidden" name="MaTK" value="<?= $user['MaTK'] ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="MaTK" class="form-label">Mã tài khoản</label>
                        <input type="text" class="form-control" id="MaTK" value="<?= $user['MaTK'] ?>" disabled>
                        <div class="form-text">Mã tài khoản không thể thay đổi</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="NgayTao" class="form-label">Ngày tạo</label>
                        <input type="text" class="form-control" id="NgayTao"
                            value="<?= isset($user['NgayTao']) ? date('d/m/Y H:i', strtotime($user['NgayTao'])) : 'N/A' ?>"
                            disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="HoTen" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="HoTen" name="HoTen"
                            value="<?= htmlspecialchars($user['HoTen']) ?>" placeholder="Nhập họ tên..." required
                            autofocus maxlength="100">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="SoDienThoai" class="form-label">Số điện thoại <span
                                class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="SoDienThoai" name="SoDienThoai"
                            value="<?= $user['SoDienThoai'] ?>" placeholder="Nhập số điện thoại..." pattern="[0-9]{10}"
                            required maxlength="10">
                        <div class="form-text">Định dạng: 10 chữ số (VD: 0123456789)</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="MatKhauMoi" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="MatKhauMoi" name="MatKhauMoi"
                            placeholder="Để trống nếu không đổi mật khẩu" minlength="6">
                        <div class="form-text">Chỉ điền nếu muốn đổi mật khẩu (Tối thiểu 6 ký tự)</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="Quyen" class="form-label">Quyền <span class="text-danger">*</span></label>
                        <select name="Quyen" id="Quyen" class="form-select" required>
                            <option value="0" <?= $user['Quyen'] == 0 ? 'selected' : '' ?>>Người dùng</option>
                            <option value="1" <?= $user['Quyen'] == 1 ? 'selected' : '' ?>>Thủ thư</option>
                            <option value="2" <?= $user['Quyen'] == 2 ? 'selected' : '' ?>>Admin</option>
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
                    <input type="checkbox" class="form-check-input" id="TrangThai" name="TrangThai" value="1"
                        <?= $user['TrangThai'] == 1 ? 'checked' : '' ?>>
                    <label for="TrangThai" class="form-check-label">Tài khoản đang hoạt động</label>
                </div>
            </div>

            <?php
            // Kiểm tra lịch sử mượn sách
            include_once("models/m_user.php");
            $hasHistory = user_hasHistory($user['MaTK']);
            if ($hasHistory):
                ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tài khoản này đã có lịch sử mượn sách, không thể xóa.
                </div>
            <?php endif; ?>

            <?php if ($user['MaTK'] == $_SESSION['user']['MaTK']): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Đây là tài khoản bạn đang sử dụng.
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <small class="text-muted">
                    <span class="text-danger">*</span> Trường bắt buộc phải điền
                </small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
                <a href="admin.php?mod=user&act=list" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Focus vào input họ tên và select toàn bộ text
    const input = document.getElementById('HoTen');
    input.focus();
    input.select();
</script>