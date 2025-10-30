<h2>Giỏ sách</h2>

<?php if (count($cart) > 0): ?>
    <div class="input-group">
        <div class="input-group-text">Ngày dự kiến trả</div>
        <input type="date" class="form-control" name="NgayTra" value="<?= $_SESSION['NgayTra'] ?>" id="NgayTra">
        <button type="button" class="btn btn-primary" id="btnDoiNgay">Đổi ngày</button>
    </div>
    <script>
        document.querySelector('#btnDoiNgay').addEventListener('click', (event) => {
            let NgayTra = document.querySelector('#NgayTra').value;
            location.search = `?mod=book&act=cart&returnDate=${NgayTra}`;
        });
    </script>
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tựa sách</th>
                <th>Giá mượn</th>
                <th class="text-center">Số lượng</th>
                <th class="text-end">Thành tiền</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            $tong = 0;
            $tongSoLuong = 0;
            foreach ($cart as $sach): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td>
                        <img src="<?= $baseUrl ?>upload/product/<?= $sach['HinhAnh'] ?>" alt="" style="height: 100px;">
                        <?= $sach['TuaSach'] ?>
                    </td>
                    <td><?= number_format($sach['GiaMuon'], 0, ',', '.') ?>đ/ngày</td>
                    <td class="text-center">
                        <a href="?mod=book&act=decrease&id=<?= $sach['MaSach'] ?>"
                            class="btn btn-sm btn-outline-secondary">-</a>
                        <?= $sach['SoLuong'] ?>
                        <a href="?mod=book&act=increase&id=<?= $sach['MaSach'] ?>"
                            class="btn btn-sm btn-outline-secondary">+</a>
                    </td>
                    <td class="text-end"><?= number_format($sach['ThanhTien'], 0, ',', '.') ?>đ</td>
                    <td class="text-center">
                        <a href="?mod=book&act=delete&index=<?= $i - 1 ?>" class="btn btn-sm btn-outline-danger">Xóa</a>
                    </td>
                </tr>
                <?php $i++;
                $tong += $sach['ThanhTien'];
                $tongSoLuong += $sach['SoLuong'];
            endforeach;
            $_SESSION['TongTien'] = $tong;
            $_SESSION['SoSachMuon'] = $tongSoLuong; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Tổng Tiền:</th>
                <th class="text-end"><?= number_format($tong, 0, ',', '.') ?>đ</th>
                <th class="text-center">
                    <a href="?mod=book&act=deleteAllCart" class="btn btn-sm btn-outline-danger">Xóa hết</a>
                </th>
            </tr>
        </tfoot>
    </table>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Đăng kí mượn sách
    </button>
<?php else: ?>
    <div class="alert alert-info text-center">Chưa có sách nào trong giỏ sách!</div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2>Xác nhận đơn mượn</h2>
                Tiền trong ví:<strong> 100.000đ</strong><br>
                Tổng tiền mượn:<strong> 68.000đ</strong><br>
                <hr>
                Số tiền còn lại trong ví:<strong> 32.000đ</strong><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="?mod=book&act=postCart" method="post">
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</div>