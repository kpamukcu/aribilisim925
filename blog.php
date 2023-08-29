<?php
require_once('header.php');
?>

<!-- Main Banner Start -->
<section id="mainBanner" class="py-8 bg-lila text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <small><a href="index.php" class="text-decoration-none text-mor">Ana Sayfa</a> / Blog</small>
                <h1 class="display-2">Blog</h1>
            </div>
        </div>
    </div>
</section>
<!-- Main Banner End -->

<!-- Search Section Start -->
<section id="search" class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="" method="get" class="form-row">
                    <div class="col-10">
                        <div class="form-group">
                            <input type="search" name="ara" placeholder="Kelime Girin" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <input type="submit" value="Ara" class="btn bg-mor text-white w-100">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Search Section End -->

<!-- Blog List Section Start -->
<section id="blogList">
    <div class="container">
        <div class="row">
            <?php
            $blogList = $db->prepare('select * from yazilar where durum="Yayında" order by id desc');
            $blogList->execute();

            if ($blogList->rowCount()) {
                foreach ($blogList as $blogListSatir) {
            ?>
                    <div class="col-md-4 my-3">
                        <a href="makale.php?postId=<?php echo $blogListSatir['id']; ?>" class="text-decoration-none">
                            <div class="card">
                                <img src="<?php echo substr($blogListSatir['gorsel'],3); ?>" alt="<?php echo $blogListSatir['alt']; ?>" class="card-img-top">
                                <div class="card-body">
                                    <h2><?php echo $blogListSatir['baslik']; ?></h2>
                                    <small>Yayın Tarihi: <?php echo $blogListSatir['tarih']; ?></small>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>
<!-- Blog List Section End -->

<?php require_once('footer.php'); ?>