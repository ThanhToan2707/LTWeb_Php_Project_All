<a href="admin.php?mod=subject&act=add" class="btn btn-success float-end">Thêm chủ đề mới</a>
<h2 class="my-3">Quản lý Chủ đề</h2>

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
                    <th style="width: 10%;">Mã CD</th>
                    <th style="width: 50%;" class="text-start">Tên chủ đề</th>
                    <th style="width: 15%;">Số lượng sách</th>
                    <th style="width: 25%;" class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($subjectList)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <i class="text-muted">Chưa có chủ đề nào</i>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($subjectList as $subject):
                        // Đếm số sách của chủ đề này
                        include_once("models/m_book.php");
                        $countBooks = pdo_getValue("SELECT COUNT(*) FROM sach WHERE MaCD = ?", $subject['MaCD']);
                        ?>
                        <tr>
                            <td><?= $subject['MaCD'] ?></td>
                            <td class="text-start">
                                <strong><?= htmlspecialchars($subject['TenChuDe']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= $countBooks ?> sách</span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-warning"
                                    href="admin.php?mod=subject&act=update&id=<?= $subject['MaCD'] ?>" title="Chỉnh sửa">
                                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                                </a>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $subject['MaCD'] ?>"
                                    data-name="<?= htmlspecialchars($subject['TenChuDe']) ?>" data-count="<?= $countBooks ?>"
                                    title="Xóa">
                                    <i class="fa-solid fa-trash-can"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Xóa chủ đề -->
<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', (event) => {
            // Lấy thông tin chủ đề cần xóa
            let id = event.target.closest('.btn').getAttribute('data-id');
            let name = event.target.closest('.btn').getAttribute('data-name');
            let count = event.target.closest('.btn').getAttribute('data-count');

            // Kiểm tra xem chủ đề có sách không
            if (count > 0) {
                alert(`Không thể xóa chủ đề "${name}" vì vẫn còn ${count} sách thuộc chủ đề này.\n\nVui lòng xóa hoặc chuyển các sách sang chủ đề khác trước khi xóa chủ đề này.`);
                return;
            }

            // Yêu cầu xác nhận
            if (confirm(`Bạn có chắc chắn muốn xóa chủ đề "${name}" không?`)) {
                // Chuyển hướng về trang xóa
                location.href = `admin.php?mod=subject&act=delete&id=${id}`;
            }
        });
    });
</script>