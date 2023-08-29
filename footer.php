    <!-- Footer Section Start -->
    <footer id="footer" class="bg-dark text-white">
        <div class="container">
            <div class="row py-5">
                <div class="col-md-3">
                    <a href="index.php">
                        <img src="<?php echo substr($mainSatir['logo'], 3); ?>" alt="Arı Bilişim Logo" style="width: 50%;">
                    </a> <br>
                    <small><?php echo $mainSatir['kisaaciklama']; ?></small> <br>
                    <a href="https://www.facebook.com/<?php echo $mainSatir['facebook']; ?>" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/<?php echo $mainSatir['insta']; ?>" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.twitter.com/<?php echo $mainSatir['twitter']; ?>" target="_blank"><i class="bi bi-twitter"></i></a>
                    <a href="https://wa.me/+90<?php echo $mainSatir['whatsapp']; ?>" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
                <div class="col-md-3">
                    <h4 class="lead">aribilisim.com</h4>
                    <small>
                        <a href="">Ana Sayfa</a><br>
                        <a href="">Hakkımızda</a><br>
                        <a href="">Portfolyo</a><br>
                        <a href="">Hizmetler</a><br>
                        <a href="">Blog</a><br>
                        <a href="">İletişim</a><br>
                    </small>
                </div>
                <div class="col-md-3">
                    <h4 class="lead">İletişim</h4>
                    <small>
                        <?php echo $mainSatir['adres']; ?><br>
                        <a href="tel:+90<?php echo $mainSatir['telefon']; ?>">0<?php echo $mainSatir['telefon']; ?></a> <br>
                        <a href="mailto:<?php echo $mainSatir['eposta']; ?>"><?php echo $mainSatir['eposta']; ?></a>
                    </small>
                </div>
                <div class="col-md-3">
                    <h4 class="lead">E-Bültene Üye Olun</h4>
                    <small>Güncel teknoloji haberleri ve blog yazıları hakkında bilgi almak için E-Bültene üye olun.</small>
                    <form action="" method="post" class="pt-3">
                        <div class="form-group">
                            <input type="email" name="eposta" placeholder="E-Posta Adresiniz" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gönder" class="btn btn-success w-100" name="ebultenuye">
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['ebultenuye'])) {
                        $ebultenuyekaydet = $db->prepare('insert into ebulten(eposta) values(?)');
                        $ebultenuyekaydet->execute(array($_POST['eposta']));

                        if($ebultenuyekaydet -> rowCount()){
                            echo '<script>alert("E-Bülten Üyeliğiniz Oluşturuldu")</script>';
                        } else {
                            echo '<script>alert("Hata Oluştu")</script>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-12 text-center">
                    Buraya Copywrite Gelecek
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- JS Files (Jquery, Popper, Bootstrap-JS) -->
    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    </body>

    </html>