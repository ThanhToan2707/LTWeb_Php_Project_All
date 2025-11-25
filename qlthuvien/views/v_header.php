<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thư viện Thành phố (HCMC Lib)</title>
    <link rel="stylesheet" href="<?= $baseUrl ?>Library_Template/bootstrap-5.3.2-dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="?mod=page&act=home">Thanh Toàn Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?mod=page&act=home">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Chủ đề
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?mod=page&act=home">Tất cả</a></li>
                            <?php if (isset($categories) && count($categories) > 0): ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <?php foreach ($categories as $cat): ?>
                                    <li>
                                        <a class="dropdown-item <?= (isset($_GET['category']) && $_GET['category'] == $cat['MaCD']) ? 'active' : '' ?>"
                                            href="?mod=page&act=home&category=<?= $cat['MaCD'] ?>">
                                            <?= htmlspecialchars($cat['TenChuDe']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- <li class="nav-item"> //khi chua dang nhap nó hiện trên navbar
                        <a class="nav-link" href="#">Giỏ sách</a>
                    </li> -->
                    <?php if (isset($_SESSION['user'])): ?> <!-- Nếu đã đăng nhập thì hiện trên navbar-->
                        <li class="nav-item">
                            <a class="nav-link" href="?mod=book&act=cart">Giỏ sách</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false"> Xin chào, <?= $_SESSION['user']['HoTen'] ?>
                            </a>
                            <ul class="dropdown-menu end-0" style="left:auto">
                                <li><a class="dropdown-item" href="#">Thông tin tài khoản</a></li>
                                <li><a class="dropdown-item" href="#">Lịch sử mượn sách</a></li>
                                <!-- kiem tra neu tai khoan la admin thi hien thi trang quan ly neu tai khoan la user thi khong hien thi -->
                                <?php if ($_SESSION['user']['Quyen'] == 1 || $_SESSION['user']['Quyen'] == 2): ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-primary" href="admin.php?mod=page&act=dashboard">Trang quản
                                            lý</a></li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="?mod=user&act=logout">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?> <!-- Nếu chưa đăng nhập thì hiện trên navbar-->
                        <li class="nav-item">
                            <a class="nav-link" href="?mod=user&act=register">Đăng ký</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?mod=user&act=login">Đăng nhập</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-3">
        <?php if (isset($_GET['mod']) && $_GET['mod'] == "page" && isset($_GET['act']) && $_GET['act'] == "home"): //chi hien thi carousel khi o trang home ?>
            <style>
                /* Reverse carousel slide direction to give left-to-right movement */
                @keyframes bs-carousel-slide-left {
                    from {
                        transform: translateX(-100%);
                    }

                    to {
                        transform: translateX(0);
                    }
                }

                @keyframes bs-carousel-slide-right {
                    from {
                        transform: translateX(100%);
                    }

                    to {
                        transform: translateX(0);
                    }
                }

                /* Override the default carousel item animations to emphasize left-to-right */
                .carousel-item-next,
                .carousel-item-prev,
                .carousel-item.active {
                    animation-duration: .6s;
                    animation-fill-mode: both;
                }
            </style>

            <div id="carouselExample" class="carousel slide my-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= $baseUrl ?>library_Template/anh1.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $baseUrl ?>library_Template/anh2.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $baseUrl ?>library_Template/anh3.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <script>
                    // Make the carousel slide smoothly left-to-right every 2500ms by calling prev()
                    (function () {
                        try {
                            var myCarouselEl = document.getElementById('carouselExample');
                            if (!myCarouselEl) return;
                            // Initialize carousel without automatic next() so we control movement
                            var carousel = new bootstrap.Carousel(myCarouselEl, {
                                interval: false,
                                ride: false
                            });

                            // Smooth transition via CSS: ensure transform duration matches visual smoothness
                            var style = document.createElement('style');
                            style.innerHTML = '.carousel-item { transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out; }';
                            document.head.appendChild(style);

                            var slideInterval = 2000; // 2 seconds
                            var timer = setInterval(function () {
                                try { carousel.prev(); } catch (e) { }
                            }, slideInterval);

                            // Pause on hover
                            myCarouselEl.addEventListener('mouseenter', function () { clearInterval(timer); });
                            myCarouselEl.addEventListener('mouseleave', function () {
                                timer = setInterval(function () { try { carousel.prev(); } catch (e) { } }, slideInterval);
                            });
                        } catch (err) {
                            // ignore errors
                        }
                    })();
                </script>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-3">
                <form action="<?= $baseUrl ?>index.php?mod=page&act=home" method="get" class="mb-3"
                    id="site-search-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Nhập tựa sách cần tìm"
                            value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                        <button class="btn btn-primary" type="submit" id="search">Tìm</button>
                        <button class="btn btn-outline-secondary" type="button" id="search-reset"
                            title="Reset">Reset</button>
                    </div>
                </form>
                <script>
                    // Handle search submit and reset explicitly to avoid form/layout issues
                    (function () {
                        try {
                            var form = document.getElementById('site-search-form');
                            if (!form) return;

                            var qInput = form.querySelector('input[name="q"]');
                            var resetBtn = document.getElementById('search-reset');

                            form.addEventListener('submit', function (e) {
                                e.preventDefault();
                                var q = qInput ? qInput.value.trim() : '';
                                var action = form.getAttribute('action') || window.location.pathname;
                                var sep = action.indexOf('?') === -1 ? '?' : '&';
                                var url = action + (q ? (sep + 'q=' + encodeURIComponent(q)) : '');
                                window.location.href = url;
                            });

                            if (resetBtn) {
                                resetBtn.addEventListener('click', function () {
                                    // Clear input and go back to home without q
                                    if (qInput) qInput.value = '';
                                    var homeUrl = '<?= $baseUrl ?>index.php?mod=page&act=home';
                                    window.location.href = homeUrl;
                                });
                            }
                        } catch (err) {
                            // fallback: do nothing and allow normal form behavior
                        }
                    })();
                </script>

                <ul class="list-group mb-3">
                    <li class="list-group-item active" aria-current="true">Sách đọc nhiều</li>
                    <li class="list-group-item">1. Dark nhân tâm</li>
                    <li class="list-group-item">2. Tuổi trẻ đáng giá bao nhiêu?</li>
                    <li class="list-group-item">3. Bí quyết không ăn mà vẫn sống</li>
                    <li class="list-group-item">4. Sắc đẹp ngàn cân</li>
                </ul>
            </div>
            <div class="col-md-9"></div>