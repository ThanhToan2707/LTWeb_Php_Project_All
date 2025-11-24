<h2 class="my-3">Chi tiết đơn #<?= $history['MaLS'] ?>
    <?php switch ($history['TrangThai']) {
        case 'gio-sach':
            echo '<span class="badge text-bg-secondary">Chờ xác nhận!</span>';
            break;
        case 'chuan-bi':
            echo '<span class="badge text-bg-warning">Đang chuẩn bị sách</span>';
            break;
        case 'cho-giao':
            echo '<span class="badge text-bg-primary">Chờ giao sách!</span>';
            break;
        case 'dang-muon':
            echo '<span class="badge text-bg-danger">Đang mượn</span>';
            break;
        case 'da-tra':
            echo '<span class="badge text-bg-success">Đã trả</span>';
            break;

        default:
            # code...
            break;
    }
    ?>
</h2>
<div class="row">
    <div class="col-sm-4">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Người mượn</th>
                    <td><?= $history['HoTen'] ?></td>
                </tr>
                <tr>
                    <th>Ngày mượn</th>
                    <td><?= date('d/m/Y', strtotime($history['NgayMuon'])) ?></td>
                </tr>
                <tr>
                    <th>Ngày trả</th>
                    <td><?= date('d/m/Y', strtotime($history['NgayTra'])) ?></td>
                </tr>
                <tr>
                    <th>Số sách mượn</th>
                    <td><?= $history['SoSachMuon'] ?></td>
                </tr>
                <tr>
                    <th>Tổng tiền</th>
                    <td><?= number_format($history['TongTien'], 0, ',', '.') ?>đ</td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>
                        <select class="form-select" aria-label="Default select example" id="status">
                            <option value="gio-sach" <?= $history['TrangThai'] == 'gio-sach' ? 'selected' : '' ?>>Chờ xác
                                nhận!</option>
                            <option value="chuan-bi" <?= $history['TrangThai'] == 'chuan-bi' ? 'selected' : '' ?>>Đang
                                chuẩn bị sách</option>
                            <option value="cho-giao" <?= $history['TrangThai'] == 'cho-giao' ? 'selected' : '' ?>>Chờ giao
                                sách!</option>
                            <option value="dang-muon" <?= $history['TrangThai'] == 'dang-muon' ? 'selected' : '' ?>>Đang
                                mượn</option>
                            <option value="da-tra" <?= $history['TrangThai'] == 'da-tra' ? 'selected' : '' ?>>Đã trả
                            </option>
                        </select>
                        <script>
                            // Cập nhật trạng thái đơn hàng
                            document.querySelector('#status').addEventListener('change', (event) => {
                                // Lấy giá trị trạng thái mới
                                let value = event.target.value;
                                // Cập nhật trạng thái đơn hàng
                                location.search = `?mod=book&act=updateOrderStatus&id=<?= $history['MaLS'] ?>&status=${value}`;
                            });
                        </script>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-sm-8">
        <h4>Sách đã mượn</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Tựa sách</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historyDetail as $book): ?>
                    <tr>
                        <td>
                            <img src="<?= $baseUrl ?>upload/product/<?= $book['HinhAnh'] ?>" alt="" width="100px">
                            <?= $book['TuaSach'] ?>
                        </td>
                        <td><?= $book['SoLuong'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>