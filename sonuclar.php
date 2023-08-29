<?php require_once('header.php'); ?>

<!-- Main Banner Start -->
<section id="mainBanner" class="py-8 bg-lila text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <small><a href="index.php" class="text-decoration-none text-mor">Ana Sayfa</a> / İletişim</small>
                <h1 class="display-2">Arama Sonuçları</h1>
            </div>
        </div>
    </div>
</section>
<!-- Main Banner End -->

<!-- Blog List Section Start -->
<section id="blogList">
    <div class="container">
        <div class="row">
            <?php
            if (isset($_GET['arabul'])) {
                $ara = '%' . $_GET['arabul'] . '%';
                $araList = $db->prepare("select * from yazilar where baslik like ?");
                $araList->execute(array($ara));

                if ($araList->rowCount()) {
                    foreach ($araList as $araListSatir) {
            ?>
                        <div class="col-md-4 my-3">
                            <a href="makale.php?postId=<?php echo $araListSatir['id']; ?>" class="text-decoration-none">
                                <div class="card">
                                    <img src="<?php echo substr($araListSatir['gorsel'], 3); ?>" alt="<?php echo $araListSatir['alt']; ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h2><?php echo $araListSatir['baslik']; ?></h2>
                                        <small>Yayın Tarihi: <?php echo $araListSatir['tarih']; ?></small>
                                    </div>
                                </div>
                            </a>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</section>
<!-- Blog List Section End -->

<?php require_once('footer.php'); ?>