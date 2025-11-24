<a href="admin.php?mod=user&act=add" class="btn btn-success float-end">Thêm tài khoản mới</a>
<h2 class="my-3">Quản lý Tài khoản</h2>

<!-- Hiển thị thông báo -->
<?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-<?= isset($_SESSION['alert_type']) ? $_SESSION['alert_type'] : 'success' ?> alert-dismissible fade show"
        role="alert">
        <?= $_SESSION['alert'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php unset($_SESSION['alert']);
unset($_SESSION['alert_type']); ?>

<div class="card">
    <div class="card-body">
        <table class="table table-hover text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th style="width: 5%;">Mã TK</th>
                    <th style="width: 20%;" class="text-start">Họ tên</th>
                    <th style="width: 15%;">Số điện thoại</th>
                    <th style="width: 10%;">Quyền</th>
                    <th style="width: 10%;">Trạng thái</th>
                    <th style="width: 15%;">Ngày tạo</th>
                    <th style="width: 25%;" class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($userList)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="text-muted">Chưa có tài khoản nào</i>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($userList as $user): ?>
                        <tr>
                            <td><?= $user['MaTK'] ?></td>
                            <td class="text-start">
                                <strong><?= htmlspecialchars($user['HoTen']) ?></strong>
                                <?php if ($user['MaTK'] == $_SESSION['user']['MaTK']): ?>
                                    <span class="badge bg-primary ms-1">Bạn</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $user['SoDienThoai'] ?></td>
                            <td>
                                <?php if ($user['Quyen'] == 2): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php elseif ($user['Quyen'] == 1): ?>
                                    <span class="badge bg-warning">Thủ thư</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Người dùng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($user['TrangThai'])): ?>
                                    <?php if ($user['TrangThai'] == 1): ?>
                                        <span class="badge bg-success">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Vô hiệu hóa</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php endif; ?>
                            </td>
                            <td><?= isset($user['NgayTao']) ? date('d/m/Y', strtotime($user['NgayTao'])) : 'N/A' ?></td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Toggle trạng thái - chỉ hiện nếu có cột TrangThai -->
                                    <?php if (isset($user['TrangThai'])): ?>
                                        <?php if ($user['TrangThai'] == 1): ?>
                                            <button class="btn btn-warning btn-toggle-status" data-id="<?= $user['MaTK'] ?>"
                                                data-status="0" data-name="<?= htmlspecialchars($user['HoTen']) ?>" title="Vô hiệu hóa">
                                                <i class="fa-solid fa-ban"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-success btn-toggle-status" data-id="<?= $user['MaTK'] ?>"
                                                data-status="1" data-name="<?= htmlspecialchars($user['HoTen']) ?>" title="Kích hoạt">
                                                <i class="fa-solid fa-check-circle"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Sửa -->
                                    <a class="btn btn-primary" href="admin.php?mod=user&act=update&id=<?= $user['MaTK'] ?>"
                                        title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Xóa -->
                                    <button class="btn btn-danger btn-delete" data-id="<?= $user['MaTK'] ?>"
                                        data-name="<?= htmlspecialchars($user['HoTen']) ?>"
                                        data-current="<?= $user['MaTK'] == $_SESSION['user']['MaTK'] ? '1' : '0' ?>"
                                        title="Xóa">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Script xử lý -->
<script>
    // Toggle trạng thái
    document.querySelectorAll('.btn-toggle-status').forEach(btn => {
        btn.addEventListener('click', (event) => {
            let id = event.target.closest('.btn').getAttribute('data-id');
            let status = event.target.closest('.btn').getAttribute('data-status');
            let name = event.target.closest('.btn').getAttribute('data-name');
            let action = status == '1' ? 'kích hoạt' : 'vô hiệu hóa';

            if (confirm(`Bạn có chắc chắn muốn ${action} tài khoản "${name}" không?`)) {
                location.href = `admin.php?mod=user&act=toggleStatus&id=${id}&status=${status}`;
            }
        });
    });

    // Xóa tài khoản
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', (event) => {
            let id = event.target.closest('.btn').getAttribute('data-id');
            let name = event.target.closest('.btn').getAttribute('data-name');
            let isCurrent = event.target.closest('.btn').getAttribute('data-current');

            if (isCurrent == '1') {
                alert('Không thể xóa tài khoản đang đăng nhập!');
                return;
            }

            if (confirm(`Bạn có chắc chắn muốn xóa tài khoản "${name}" không?\n\nLưu ý: Không thể xóa nếu tài khoản đã có lịch sử mượn sách.`)) {
                location.href = `admin.php?mod=user&act=delete&id=${id}`;
            }
        });
    });
</script>