<div class="row">
    <div class="col-md-6">
        <img src="<?= $baseUrl ?>upload/product/<?= $bookDetail['HinhAnh'] ?>" class="w-100">
    </div>
    <div class="col-md-6">
        <h2><?= $bookDetail['TuaSach'] ?></h2>
        <div class="row">
            <div class="col-md-6">
                Tác giả:
                <strong><?= $bookDetail['TacGia'] ?></strong>
            </div>
            <div class="col-md-6">
                Chủ đề:
                <strong><?= $bookDetail['TenChuDe'] ?></strong>
            </div>
        </div>
        <div class="text-danger fs-1"><?= number_format($bookDetail['GiaTri'], 0, ',', '.') ?>đ</div>
        <small>Còn <strong><?= $bookDetail['SoLuong'] ?></strong> quyển trong thư viện</small>
        <br>

        <!-- Thông báo mượn sách thành công -->
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-success mt-3" role="alert">
                <?= $_SESSION['alert'] ?>
            </div>
            <?php unset($_SESSION['alert']); //hiện thị 1 lần rồi xóa đi ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?> <!--Neu dang nhap roi thi hien len nut muon sach-->
            <a href="?mod=book&act=addToCart&id=<?= $bookDetail['MaSach'] ?>" class="btn btn-outline-primary btn-lg">Mượn
                sách</a>
        <?php else: ?>
            <div class="alert alert-warning mt-3" role="alert">
                Vui lòng <a href="?mod=user&act=login" class="alert-link">đăng nhập</a> để mượn sách!
            </div>
        <?php endif; ?>
        <hr>
        <p class="my-3">
            <?= $bookDetail['MoTa'] ?>
        </p>
    </div>
</div>
<h2>Có thể bạn thích đọc</h2>
<div class="row">
    <?php foreach ($randomBooks as $book): ?>
        <div class="col-md-3 col-sm-6">
            <div class="card mb-3">
                <img src="<?= $baseUrl ?>upload/product/<?= $book['HinhAnh'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $book['TuaSach'] ?></h5>
                    <p class="card-text"><?= number_format($book['GiaTri'], 0, ',', '.') ?>đ</p>
                    <a href="?mod=book&act=detail&id=<?= $book['MaSach'] ?>" class="btn btn-primary">Mượn</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- <div class="col-md-3 col-sm-6">
        <div class="card mb-3">
            <img src="sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card mb-3">
            <img src="sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card mb-3">
            <img src="sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div> -->
</div>
<h2>Cảm nghĩ của bạn đọc</h2>
<?php if (isset($_SESSION['user'])): ?> <!--Neu dang nhap roi thi hien lem form binh luan  -->
    <form action="?mod=comment&act=post-comment" method="post">
        <input type="hidden" name="MaSach" value="<?= $bookDetail['MaSach'] ?>">
        <div class="input-group mb-3">
            <input type="text" name="NoiDung" class="form-control" placeholder="Nhập cảm nghĩ của bạn...">
            <button type="submit" class="btn btn-primary">Gửi</button>
        </div>
    </form>
<?php else: ?> <!-- Neu chua dang nhap thi hien thong bao dang nhap de duoc binh luan -->
    <div class="alert alert-warning" role="alert">
        Vui lòng <a href="?mod=user&act=login" class="alert-link">đăng nhập</a> để gửi cảm nghĩ của bạn!
    </div>
<?php endif; ?>

<?php foreach ($comments as $cm): ?>
    <div class="row my-3 border rounded-3">
        <div class="col-sm-3">
            <strong><?= $cm['HoTen'] ?></strong><br>
            <?= date('H:i d/m/Y', strtotime($cm['NgayGui'])) ?><br>
            <i>Đã mượn <?= $cm['SoLanMuon'] ?> lần</i>
        </div>
        <div class="col-sm-9">
            <?= $cm['NoiDung'] ?>
        </div>
    </div>
<?php endforeach; ?>

<!-- <div class="row my-3 border rounded-3">
    <div class="col-sm-3">
        <strong>Phạm Ngọc Cường</strong><br>
        11:17 28/09/2023<br>
        <i>Đã mượn 1 lần</i>
    </div>
    <div class="col-sm-9">
        Trong muôn vàn nhà văn viết truyện cho thiếu nhi, Tô Hoài vẫn có một vị trí nhất định. Bởi ông đem đến người
        đọc
        thứ văn chương mộc mạc, dễ hiểu, dễ gần, dễ cảm. Ông khiến người đọc rung cảm theo từng trang viết, từng câu
        chuyện giản đơn nhưng thấm thía. Bước vào thế giới của tác phẩm “Những truyện ngắn viết cho thiếu nhi- Tô
        Hoài”,
        bạn sẽ thấy rõ điều đó.
    </div>
</div>
<div class="row my-3 border rounded-3">
    <div class="col-sm-3">
        <strong>Phạm Ngọc Cường</strong><br>
        11:17 28/09/2023<br>
        <i>Đã mượn 1 lần</i>
    </div>
    <div class="col-sm-9">
        Trong muôn vàn nhà văn viết truyện cho thiếu nhi, Tô Hoài vẫn có một vị trí nhất định. Bởi ông đem đến người
        đọc
        thứ văn chương mộc mạc, dễ hiểu, dễ gần, dễ cảm. Ông khiến người đọc rung cảm theo từng trang viết, từng câu
        chuyện giản đơn nhưng thấm thía. Bước vào thế giới của tác phẩm “Những truyện ngắn viết cho thiếu nhi- Tô
        Hoài”,
        bạn sẽ thấy rõ điều đó.
    </div>
</div> -->