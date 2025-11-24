<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Thanh Toàn Library</title>
    <link rel="stylesheet" href="<?= $baseUrl ?>Library_Template/bootstrap-5.3.2-dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 bg-primary collapse collapse-horizontal show" style="min-height:100vh"
                id="openMenu">
                <strong class="text-center d-block p-3 text-white">TRANG QUẢN LÝ</strong>
                <div class="list-group list-group-item-primary m-3">
                    <a href="admin.php?mod=page&act=dashboard"
                        class="list-group-item list-group-item-action <?= ($_GET['mod'] == 'page' ? "active" : "") ?>"
                        aria-current="true">
                        Tổng quan
                    </a>
                    <a href="admin.php?mod=user&act=list"
                        class="list-group-item list-group-item-action <?= ($_GET['mod'] == 'user' ? "active" : "") ?>">Tài
                        khoản</a>
                    <a href="admin.php?mod=subject&act=list"
                        class="list-group-item list-group-item-action <?= ($_GET['mod'] == 'subject' ? "active" : "") ?>">Chủ
                        đề</a>
                    <a href="admin.php?mod=book&act=list"
                        class="list-group-item list-group-item-action <?= ($_GET['mod'] == 'book' && $_GET['act'] == 'list') ? "active" : "" ?>">Sách</a>
                    <a href="admin.php?mod=book&act=order"
                        class="list-group-item list-group-item-action <?= ($_GET['mod'] == 'book' && $_GET['act'] == 'order') ? "active" : "" ?>">Mượn/trả</a>
                </div>
            </div>
            <div class="col-md p-0">
                <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
                    <div class="container-fluid">
                        <button class="btn btn-outline-light me-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#openMenu" aria-expanded="false" aria-controls="openMenu">
                            =
                        </button>
                        <a class="navbar-brand" href="admin.php?mod=page&act=dashboard">Thanh Toàn Library</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Xin chào, <?= $_SESSION['user']['HoTen'] ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="index.php?mod=page&act=home">Xem trang
                                                chủ</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-danger"
                                                href="index.php?mod=user&act=logout">Đăng xuất</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container">