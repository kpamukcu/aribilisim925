<?php
require_once('header.php');
?>

<!-- Main Banner Start -->
<section id="mainBanner" class="py-8 bg-lila text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <small><a href="index.php" class="text-decoration-none text-mor">Ana Sayfa</a> / İletişim</small>
                <h1 class="display-2">İletişim</h1>
            </div>
        </div>
    </div>
</section>
<!-- Main Banner End -->

<!-- Info Section Start -->
<section id="info" class="text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-geo-fill text-mor"></i>
                        <p>Adres</p>
                        <?php echo $mainSatir['adres']; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-telephone-fill text-mor"></i>
                        <p>Telefon</p>
                        <a href="tel:+90<?php echo $mainSatir['telefon']; ?>" class="text-dark text-decoration-none"><?php echo $mainSatir['telefon']; ?></a><br>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-envelope-fill text-mor"></i>
                        <p>E-Posta Adresi</p>
                        <a href="mailto:<?php echo $mainSatir['eposta']; ?>" class="text-dark text-decoration-none"><?php echo $mainSatir['eposta']; ?></a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Info Section End -->

<!-- Form Section Start -->
<section id="form" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Bize Mesaj Gönderin</h2>
            </div>
            <div class="col-md-6">
                <form action="" method="post" class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="adiniz" placeholder="Adınız Soyadınız" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="tel" name="telefon" placeholder="Telefon Numaranız" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="email" name="eposta" placeholder="E-Posta Adresiniz" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="konu" placeholder="Konu" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea name="mesaj" placeholder="Mesajınız" rows="6" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="durum" value="okunmadı">
                            <input type="submit" value="Gönder" class="btn bg-mor text-white">
                        </div>
                    </div>
                </form>
                <?php
                if ($_POST) {
                    $adiniz = $_POST['adiniz'];
                    $telefon = $_POST['telefon'];
                    $eposta = $_POST['eposta'];
                    $konu = $_POST['konu'];
                    $mesaj = $_POST['mesaj'];
                    $durum = $_POST['durum'];

                    $mesajKaydet = $db->prepare('insert into iletisim(adiniz,telefon,eposta,konu,mesaj,durum) values(?,?,?,?,?,?)');
                    $mesajKaydet->execute(array($adiniz, $telefon, $eposta, $konu, $mesaj,$durum));

                    if ($mesajKaydet->rowCount()) {
                        echo '<div class="alert alert-success text-center">Mesajınız Gönderildi.</div>';
                    } else {
                        echo '<div class="alert alert-danger text-center">Mesajınız Gönderilemedi.</div>';
                    }
                }
                ?>
            </div>
            <div class="col-md-6">
                <?php echo $mainSatir['harita']; ?>
            </div>
        </div>
    </div>
</section>
<!-- Form Section End -->

<?php require_once('footer.php'); ?>