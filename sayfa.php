<?php
require_once('header.php');

if (isset($_GET['pageId'])) {
    $id = $_GET['pageId'];
    $pageContent = $db->prepare('select * from sayfalar where id=?');
    $pageContent->execute(array($id));
    $pageContentSatir = $pageContent->fetch();
}

?>

<!-- Main Banner Start -->
<section id="mainBanner" class="py-8 bg-lila text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <small><a href="index.php" class="text-decoration-none text-mor">Ana Sayfa</a> / <?php echo $pageContentSatir['baslik']; ?></small>
                <h1 class="display-2"><?php echo $pageContentSatir['baslik']; ?></h1>
            </div>
        </div>
    </div>
</section>
<!-- Main Banner End -->

<!-- Service Content Section Start -->
<section id="serviceContent" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <main>
                    <img src="<?php echo substr($pageContentSatir['gorsel'], 3); ?>" alt="<?php echo $pageContentSatir['alt']; ?>" class="w-100 border">
                    <h2 class="my-4"><?php echo $pageContentSatir['baslik']; ?></h2>
                    <span class="text-justify"><?php echo $pageContentSatir['icerik']; ?></span>
                </main>
                <?php
                if ($pageContentSatir['saytur'] == 'hizmet') {
                ?>
                    <div>
                        <div class="row bg-mor py-5">
                            <div class="col-md-9 text-center">
                                <span class="text-white" style="font-size:28px;"><?php echo $pageContentSatir['baslik']; ?> Hakkında<br> Ayrıntılı Bilgi ve Teklif Alın.</span>
                            </div>
                            <div class="col-md-3 my-auto">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">
                                    Teklif Alın
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $pageContentSatir['baslik']; ?> Talep Başvurusu</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <input type="text" name="adi" placeholder="Adınız Soyadınız" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="tel" name="telefon" placeholder="Telefon Numaranız" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="email" name="eposta" placeholder="E-Posta Adresiniz" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="info" placeholder="Proje Talebiniz Hakkında Özet Bilgi Yazınız." class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Ek Açıklama</label><br>
                                                        <input type="file" name="dosya">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="sayfa" value="<?php echo $pageContentSatir['baslik']; ?>">
                                                        <input type="submit" value="Talep Gönder" class="btn bg-mor text-white" name="talep">
                                                    </div>
                                                </form>
                                                <?php
                                                if (isset($_POST['talep'])) {
                                                    $adi = $_POST['adi'];
                                                    $telefon = $_POST['telefon'];
                                                    $eposta = $_POST['eposta'];
                                                    $info = $_POST['info'];
                                                    $sayfa = $_POST['sayfa'];
                                                    $ekDosya = './docs/' . $_FILES['dosya']['name'];

                                                    if (move_uploaded_file($_FILES['dosya']['tmp_name'], $ekDosya)) {
                                                        $talepAl = $db->prepare('insert into talep(adi,telefon,eposta,info,sayfa,dosya) values(?,?,?,?,?,?)');
                                                        $talepAl->execute(array($adi, $telefon, $eposta, $info, $sayfa, $ekDosya));

                                                        if ($talepAl->rowCount()) {
                                                            echo "<meta http-equiv='refresh' content='0; url='><script>alert('Talebiniz İletildi. En kısa Sürede Sizi Arayacağız.')</script>";
                                                        } else {
                                                            echo "<meta http-equiv='refresh' content='0; url='><script>alert('Hata Oluştu. Lütfen Tekrar Deneyin')</script>";
                                                        }
                                                    } else {
                                                        echo "<meta http-equiv='refresh' content='0; url='><script>alert('Dosya Yüklenemedi Lütfen Tekrar Deneyin')</script>";
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
                <?php
                }
                ?>
            </div>
            <?php require_once('aside.php'); ?>
        </div>
    </div>
</section>
<!-- Service Content Section End -->

<?php require_once('footer.php'); ?>