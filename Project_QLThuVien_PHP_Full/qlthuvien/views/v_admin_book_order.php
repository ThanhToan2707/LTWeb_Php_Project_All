<h2 class="my-3">Mượn sách và Trả sách</h2>
<table class="table">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Người mượn</th>
            <th>Ngày mượn</th>
            <th>Ngày trả</th>
            <th>Số sách mượn</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($historyList as $his): ?>
            <tr>
                <td><?= $his['MaLS'] ?></td>
                <td><?= $his['HoTen'] ?></td>
                <td><?= date('d/m/Y', strtotime($his['NgayMuon'])) ?></td>
                <td><?= date('d/m/Y', strtotime($his['NgayTra'])) ?></td>
                <td><?= $his['SoSachMuon'] ?></td>
                <td><?= number_format($his['TongTien'], 0, ',', '.') ?>đ</td>
                <td>
                    <?php switch ($his['TrangThai']) {
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

                </td>
                <td>
                    <a href="admin.php?mod=book&act=orderDetail&id=<?= $his['MaLS'] ?>" class="btn btn-primary">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <!-- <a href="#" class="btn btn-warning">
                        <i class="fa-solid fa-gear"></i>
                    </a> -->
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>