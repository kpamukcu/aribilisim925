<?php
require_once('header.php');

if ($_GET) {
    $id = $_GET['id'];
    $yazi = $db->prepare('select * from yazilar where id=?');
    $yazi->execute(array($id));
    $yaziSatir = $yazi->fetch();
}

?>
<form action=""></form>

<!-- Blog Update Section Start  -->
<section id="blogUpdate" class="py-5">
    <div class="container">
        <div class="row">
            <h4>Yazı Güncelle</h4>
        </div>
        <div class="row">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="baslik" value="<?php echo $yaziSatir['baslik']; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <textarea name="icerik"><?php echo $yaziSatir['icerik']; ?></textarea>
                    <script>
                        CKEDITOR.replace('icerik', {
                            height: 350
                        });
                    </script>
                </div>
                <div class="form-group">
                    <textarea name="meta" rows="2" class="form-control"><?php echo $yaziSatir['meta']; ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="file" name="gorsel">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="alt" value="<?php echo $yaziSatir['alt']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="kategori" class="form-control">
                                <option value="<?php echo $yaziSatir['kategori']; ?>"><?php echo $yaziSatir['kategori']; ?></option>
                                <?php
                                    $katList = $db -> prepare('select * from kategoriler where katturu="Ana Kategori" order by katadi asc');
                                    $katList -> execute();

                                    if($katList -> rowCount()){
                                        foreach($katList as $katListSatir){
                                            ?>
<option value="<?php echo $katListSatir['katadi']; ?>"><?php echo $katListSatir['katadi']; ?></option>
                                            <?php
                                        }
                                    }
                                ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="date" name="tarih" value="<?php echo $yaziSatir['tarih']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="durum" class="form-control">
                                <option value="<?php echo $yaziSatir['durum']; ?>"><?php echo $yaziSatir['durum']; ?></option>
                                <option value="Yayında">Yayında</option>
                                <option value="Taslak">Taslak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Güncelle" class="btn btn-success">
            </form>
        </div>
    </div>
</section>
<!-- Blog Update Section End  -->

<!-- Update Module Start -->
<?php
if($_POST){
    $baslik = $_POST['baslik'];
    $icerik = $_POST['icerik'];
    $meta = $_POST['meta'];
    $gorsel = '../assets/img/' . $_FILES['gorsel']['name'];
    $alt = $_POST['alt'];
    $kategori = $_POST['kategori'];
    $tarih = $_POST['tarih'];
    $durum = $_POST['durum'];

    if(move_uploaded_file($_FILES['gorsel']['tmp_name'],$gorsel)){
        $makaleGuncelle = $db -> prepare('update yazilar set baslik=?, icerik=?, meta=?, alt=?, kategori=?, tarih=?, durum=?, gorsel=? where id=?');
        $makaleGuncelle -> execute(array($baslik,$icerik,$meta,$alt,$kategori,$tarih,$durum,$gorsel,$id));

        if($makaleGuncelle -> rowCount()){
            echo '<script>alert("Kayıt Güncellendi")</script><meta http-equiv="refresh" content="1; url=yazilar.php">';
        } else {
            echo '<script>alert("Hata Oluştu")</script><meta http-equiv="refresh" content="1; url=yazilar.php">';
        }
    }
}
?>
<!-- Update Module End -->



<?php require_once('footer.php'); ?>