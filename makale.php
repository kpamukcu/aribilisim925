<?php
require_once('header.php');

if (isset($_GET['postId'])) {
    $id = $_GET['postId'];
    $makale = $db->prepare('select * from yazilar where id=?');
    $makale->execute(array($id));
    $makaleSatir = $makale->fetch();
}

?>

<!-- Makale Section Start -->
<section id="makale" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <img src="<?php echo substr($makaleSatir['gorsel'], 3); ?>" alt="<?php echo $makaleSatir['alt']; ?>" class="w-100 border">
                <main>
                    <article>
                        <div class="py-3">
                            <h1><?php echo $makaleSatir['baslik']; ?></h1>
                            <small>
                                <i class="bi bi-clock-fill text-mor"></i> <?php echo $makaleSatir['tarih']; ?>
                                <i class="bi bi-chat-dots-fill text-mor"></i> 4 Yorum
                            </small>
                        </div>
                        <span class="text-justify">
                            <?php echo $makaleSatir['icerik']; ?>
                        </span>
                    </article>
                </main>
                <div id="yorumlar">
                    <h4>Yorumlar</h4>
                    <?php
                    $yorumCek = $db->prepare('select * from yorumlar where postId=? && durum=?');
                    $yorumCek->execute(array($_GET['postId'],"onay"));

                    if ($yorumCek->rowCount()) {
                        foreach ($yorumCek as $yorumCekSatir) {
                    ?>
                            <small><b><?php echo $yorumCekSatir['ad']; ?></b></small>
                            <p><?php echo $yorumCekSatir['yorum']; ?></p>
                            <hr>
                    <?php
                        }
                    }
                    ?>
                </div>
                <form action="" method="post" class="w-75">
                    <div class="form-group">
                        <input type="text" name="ad" placeholder="Adınız Soyadınız" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" name="eposta" placeholder="E-Posta Adresiniz" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea name="yorum" placeholder="Yorumunuz" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="postId" value="<?php echo $makaleSatir['id']; ?>">
                        <input type="submit" value="Gönder" class="btn bg-mor text-white" name="yorumGonder">
                    </div>
                </form>
                <?php
                if (isset($_POST['yorumGonder'])) {
                    $yorumKaydet = $db->prepare('insert into yorumlar(ad,eposta,yorum,postId,durum) values(?,?,?,?,?)');
                    $yorumKaydet->execute(array($_POST['ad'], $_POST['eposta'], $_POST['yorum'], $_POST['postId'],"-"));
                    if ($yorumKaydet->rowCount()) {
                        echo '<div class="alert alert-success w-75 text-center">Yorumunuz Onaya Gönderildi</div>';
                    } else {
                        echo '<div class="alert alert-danger w-75 text-center">Hata Oluştu</div>';
                    }
                }
                ?>
            </div>
            <?php require_once('aside.php'); ?>
        </div>
    </div>
</section>
<!-- Makale Section End -->

<?php require_once('footer.php'); ?>