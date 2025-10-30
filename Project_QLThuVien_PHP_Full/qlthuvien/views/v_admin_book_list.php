<a href="admin.php?mod=book&act=add" class="btn btn-success float-end">Thêm sách mới</a>
<h2 class="my-3">Sách</h2>

<!-- Hiển thị thông báo thành công -->
<?php if (isset($_SESSION['alert'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['alert'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php unset($_SESSION['alert']); ?>

<table class="table text-center align-middle">
    <thead>
        <tr>
            <th>STT</th>
            <th>Hình ảnh</th>
            <th class="text-start">Tựa sách</th>
            <th>Tác giả</th>
            <th class="text-end">Giá trị</th>
            <th>Số lượng</th>
            <th>Chủ đề</th>
            <th>Số cảm nghĩ</th>
            <th>Lượt đọc</th>
            <th>Lượt xem</th>
            <th class="text-end">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($bookList as $book): ?>
            <tr>
                <td><?= $i ?></td>
                <td><img src="<?= $baseUrl ?>upload/product/<?= $book['HinhAnh'] ?>" class="rounded-3" style="width: 64px;">
                </td>
                <td class="text-start"><?= $book['TuaSach'] ?></td>
                <td><?= $book['TacGia'] ?></td>
                <td class="text-end"><?= number_format($book['GiaTri'], 0, ',', '.') ?>đ</td>
                <td><?= $book['SoLuong'] ?></td>
                <td><?= $book['TenChuDe'] ?></td>
                <td><?= $book['SoCamNghi'] ?></td>
                <td><?= $book['LuotDoc'] ?></td>
                <td><?= $book['LuotXem'] ?></td>
                <td class="text-end">
                    <a class="btn btn-warning" href="admin.php?mod=book&act=update&id=<?= $book['MaSach'] ?>"><i
                            class="fa-solid fa-gear"></i></a>
                    <button class="btn btn-danger btn delete" data-id="<?= $book['MaSach'] ?>"
                        data-name="<?= $book['TuaSach'] ?>"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
            <?php $i++; endforeach; ?>
    </tbody>
</table>

<!-- Xóa sách -->
<script>
    document.querySelectorAll('.btn.delete').forEach(btn => {
        btn.addEventListener('click', (event) => {
            // Lấy id sách cần xóa
            let id = event.target.closest('.btn').getAttribute('data-id');
            let name = event.target.closest('.btn').getAttribute('data-name');
            // Yêu cầu xác nhận
            if (confirm(`Bạn có chắc chắn muốn xóa sách "${name}" không?`)) {
                // Chuyển hướng về trang xóa
                location.href = `admin.php?mod=book&act=delete&id=${id}`;
            }
        });
    });
</script>