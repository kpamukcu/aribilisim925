<?php
session_start();
require_once('./admin/baglan.php');

/* Ayarlar DB Start */
$main = $db->prepare('select * from ayarlar order by id desc limit 1');
$main->execute();
$mainSatir = $main->fetch();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <!-- Css Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Arı Bilişim | XXXXXX</title>
</head>

<body>

    <!-- Header Section Start -->
    <header id="header" class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php">
                            <img src="<?php echo substr($mainSatir['logo'], 3); ?>" alt="Arı Bilişim Logo" style="width: 35%;">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Ana Sayfa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="sayfa.php?pageId=5">Hakkımızda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="portfolyo.php">Portfolyo</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        Hizmetlerimiz
                                    </a>
                                    <div class="dropdown-menu">

                                        <?php
                                        $menuList = $db->prepare('select * from sayfalar where saytur="hizmet" order by baslik asc');
                                        $menuList->execute();
                                        if ($menuList->rowCount()) {
                                            foreach ($menuList as $menuListSatir) {
                                        ?>
                                                <a class="dropdown-item" href="sayfa.php?pageId=<?php echo $menuListSatir['id']; ?>"><?php echo $menuListSatir['baslik']; ?></a>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="blog.php">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="iletisim.php">İletişim</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->