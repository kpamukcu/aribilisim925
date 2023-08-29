<div class="col-md-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="sonuclar.php" method="GET">
                        <div class="form-group">
                            <input type="text" name="arabul" placeholder="Aradığınız Konuyu Girin" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Ara" class="btn bg-mor text-white w-100" name="araButon">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Kategoriler</h5>
                    <?php
                    $katList = $db->prepare('select distinct kategori from yazilar order by kategori asc');
                    $katList->execute();

                    if ($katList->rowCount()) {
                        foreach ($katList as $katListSatir) {
                    ?>
                            <a href="kategori.php?kat=<?php echo $katListSatir['kategori']; ?>" class="text-dark text-decoration-none"><?php echo $katListSatir['kategori']; ?></a> <br>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Son Yazılar</h5>
                    <?php
                    $blogList = $db->prepare('select * from yazilar order by id desc limit 5');
                    $blogList->execute();

                    if ($blogList->rowCount()) {
                        foreach ($blogList as $blogListSatir) {
                    ?>
                            <a href="makale.php?postId=<?php echo $blogListSatir['id']; ?>" class="text-dark text-decoration-none"><?php echo $blogListSatir['baslik']; ?></a><br>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <!-- Button trigger modal -->
                <img src="./assets/img/reklam.png" alt="Reklam Alanı" data-toggle="modal" data-target="#exampleModal">

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Reklam Verin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="adi" placeholder="Adını Soyadınız" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="tel" name="telefon" placeholder="Telefon Numaranız" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="eposta" placeholder="E-Posta Adresiniz" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="aciklama" placeholder="Lütfen Reklamınız Hakkında Kısa Bilgi Yazın" rows="4" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Reklam Görseli</label><br>
                                        <input type="file" name="gorsel">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Gönder" class="btn bg-mor text-white" name="reklamButon">
                                    </div>
                                </form>
                                <?php
                                if (isset($_POST['reklamButon'])) {
                                    $adi = $_POST['adi'];
                                    $telefon = $_POST['telefon'];
                                    $eposta = $_POST['eposta'];
                                    $aciklama = $_POST['aciklama'];
                                    $gorsel = './assets/img/' . $_FILES['gorsel']['name'];

                                    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $gorsel)) {
                                        $reklamKaydet = $db->prepare('insert into reklam(adi,telefon,eposta,aciklama,gorsel,durum) values(?,?,?,?,?,?)');
                                        $reklamKaydet->execute(array($adi, $telefon, $eposta, $aciklama, $gorsel,'Beklemede'));

                                        if ($reklamKaydet->rowCount()) {
                                            echo '<div class="alert alert-success text-center">Başvurunuz Gönderildi</div>';
                                        } else {
                                            echo '<div class="alert alert-danger text-center">Hata Oluştu</div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>