<!-- Ruột của website -->
<?php if (isset($searchResults) && $searchResults !== null): ?>
    <h2>Kết quả tìm kiếm (<?= count($searchResults) ?>)</h2>
    <div class="row">
        <?php if (count($searchResults) > 0): ?>
            <?php foreach ($searchResults as $book): ?>
                <div class="col-sm-3">
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
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">Không tìm thấy sách phù hợp với truy vấn.</div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<h2>Sách nổi bật</h2>
<div class="row">
    <?php foreach ($hotBooks as $book): ?>
        <div class="col-sm-3">
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


    <!-- <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div> -->
</div>

<h2>Sách mới</h2>
<div class="row">
    <?php foreach ($newBooks as $book): ?>
        <div class="col-sm-3">
            <div class="card mb-3">
                <img src="<?= $baseUrl ?>/upload/product/<?= $book['HinhAnh'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $book['TuaSach'] ?></h5>
                    <p class="card-text"><?= number_format($book['GiaTri'], 0, ',', '.') ?>đ</p>
                    <a href="?mod=book&act=detail&id=<?= $book['MaSach'] ?>" class="btn btn-primary">Mượn</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="card mb-3">
            <img src="<?= $baseUrl ?>library_Template/sach1.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Truyện đọc cho bé trướC giờ ngủ</h5>
                <p class="card-text">68.500đ</p>
                <a href="#" class="btn btn-primary">Mượn</a>
            </div>
        </div>
    </div> -->
</div>