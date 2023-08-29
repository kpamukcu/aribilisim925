<?php require_once('header.php'); ?>

<!-- Site Settings Section Start -->
<section id="settings" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Site Ayarları</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="" method="post" class="form-row" enctype="multipart/form-data">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="logo">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Adres</label>
                            <input type="text" name="adres" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Telefon</label>
                            <input type="tel" name="telefon" class="form-control" placeholder="Ör: 0555 555 5555">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>E-Posta Adresi</label>
                            <input type="email" name="eposta" placeholder="Ör: info@aribilisim.com" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Facebook Profil Adı</label>
                            <input type="text" name="facebook" placeholder="Ör: kpamukcu" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Instagram Profil Adı</label>
                            <input type="text" name="insta" placeholder="Ör: pamukcukaan" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Twitter Profil Adı</label>
                            <input type="text" name="twitter" placeholder="Ör: kapawebtasarim" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Whatsapp No</label>
                            <input type="tel" name="whatsapp" placeholder="Ör: 0555 555 5555" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="kisaaciklama" placeholder="Kısa Tanıtım Yazısı" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="mainmeta" placeholder="Max.160 Karakterlik Site Açıklaması Yazın" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="harita" placeholder="Google Maps" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="pixel" placeholder="Facebook Pixel Kodu" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="analitik" placeholder="Google Analytics Kodu" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="konsol" placeholder="Google Search Console Kodu" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Blog Banner</label>
                            <input type="file" name="blogbanner">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>İletişim Banner</label>
                            <input type="file" name="iletisimbanner">
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="form-group">
                            <label>Birinci Buton Renk</label>
                            <input type="color" name="buton1" class="form-control w-50">
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="form-group">
                            <label>İkinci Buton Renk</label>
                            <input type="color" name="buton2" class="form-control w-50">
                        </div>
                    </div>
                    <div class="col-md-10 my-auto">
                        <div class="form-group">
                            <label>Her Hakkı Saklıdır Metni</label>
                            <input type="text" name="copy" class="form-control" placeholder="Her Hakkı Saklıdır &copy; Arı Bilişim">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Footer Back</label>
                            <input type="color" name="footerrenk" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <div class="form-group">
                            <input type="submit" value="Kaydet" class="btn btn-success">
                        </div>
                    </div>
                </form>
                <?php
                if ($_POST) {
                    $adres = $_POST['adres'];
                    $telefon = $_POST['telefon'];
                    $eposta = $_POST['eposta'];
                    $facebook = $_POST['facebook'];
                    $insta = $_POST['insta'];
                    $twitter = $_POST['twitter'];
                    $whatsapp = $_POST['whatsapp'];
                    $kisaaciklama = $_POST['kisaaciklama'];
                    $mainmeta = $_POST['mainmeta'];
                    $harita = $_POST['harita'];
                    $pixel = $_POST['pixel'];
                    $analitik = $_POST['analitik'];
                    $konsol = $_POST['konsol'];
                    $buton1 = $_POST['buton1'];
                    $buton2 = $_POST['buton2'];
                    $copy = $_POST['copy'];
                    $footerrenk = $_POST['footerrenk'];

                    $logo = '../assets/img/' . $_FILES['logo']['name'];
                    $blogbanner = '../assets/img/' . $_FILES['blogbanner']['name'];
                    $iletisimbanner = '../assets/img/' . $_FILES['iletisimbanner']['name'];

                    $foto1 = move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
                    $foto2 = move_uploaded_file($_FILES['blogbanner']['tmp_name'], $blogbanner);
                    $foto3 = move_uploaded_file($_FILES['iletisimbanner']['tmp_name'], $iletisimbanner);

                    if (isset($foto1) && isset($foto2) && isset($foto3)) {
                        $ayarlar = $db->prepare('insert into ayarlar(adres,telefon,eposta,facebook,insta,twitter,whatsapp,kisaaciklama,mainmeta,harita,pixel,analitik,konsol,buton1,buton2,copy,footerrenk,logo,blogbanner,iletisimbanner) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

                        $ayarlar -> execute(array($adres,$telefon,$eposta,$facebook,$insta,$twitter,$whatsapp,$kisaaciklama,$mainmeta,$harita,$pixel,$analitik,$konsol,$buton1,$buton2,$copy,$footerrenk,$logo,$blogbanner,$iletisimbanner));

                        if($ayarlar -> rowCount()){
                            echo '<script>alert("Kayıt Başarılı")</script>';
                        } else {
                            echo '<script>alert("Hata Oluştu")</script>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Site Settings Section End -->

<?php require_once('footer.php'); ?>