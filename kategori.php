<?php
require_once('header.php');
?>

<!-- Main Banner Start -->
<section id="mainBanner" class="py-8 bg-lila text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <small><a href="index.php" class="text-decoration-none text-mor">Ana Sayfa</a> / <a href="blog.php">Blog</a> / <?php echo $_GET['kat']; ?></small>
                <h1 class="display-2"><?php echo $_GET['kat']; ?></h1>
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
            if (isset($_GET['kat'])) {
                $katList = $db->prepare('select * from yazilar where kategori=?');
                $katList->execute(array($_GET['kat']));

                if ($katList->rowCount()) {
                    foreach ($katList as $katListSatir) {
            ?>
                        <div class="col-md-4 my-3">
                            <a href="makale.php?postId=<?php echo $katListSatir['id']; ?>" class="text-decoration-none">
                                <div class="card">
                                    <img src="<?php echo substr($katListSatir['gorsel'], 3); ?>" alt="<?php echo $katListSatir['alt']; ?>" class="card-img-top">
                                    <div class="card-body">
                                        <h2><?php echo $katListSatir['baslik']; ?></h2>
                                        <small>Yayın Tarihi: <?php echo $katListSatir['tarih']; ?></small>
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