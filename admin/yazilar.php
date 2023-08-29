<?php 
require_once('header.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $blogSil = $db -> prepare('delete from yazilar where id=?');
    $blogSil -> execute(array($id));
    if($blogSil -> rowCount()){
        echo '<div class="alert alert-success text-center mt-5">Kayıt Silindi</div><meta http-equiv="refresh" content="1; url=yazilar.php">';
    }
}
?>



<!-- Yazı Ekle Section Start -->
<section id="yaziEkle" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Yazılar</h4>
            </div>
            <div class="col-md-6 text-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Yazı Ekle
                </button>

                <!-- Modal -->
                <div class="modal fade text-left" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Yeni Yazı Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="baslik" placeholder="Yazı Başlığını Girin" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="icerik" placeholder="Blog Yazınızı Girin" class="form-control"></textarea>
                                        <script>
                                            CKEDITOR.replace('icerik', {
                                                height: 350
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="meta" placeholder="Yazı Hakkında Kısa Açıklama Girin (Max.160 Karakter)" rows="2" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Görsel Ekle</label>
                                                <input type="file" name="gorsel">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Görsel Alt Etiketi</label>
                                                <input type="text" name="alt" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Kategori</label>
                                                <select name="kategori" class="form-control">
                                                    <option value="">Seçiniz</option>
                                                    <?php
                                                    $katList = $db->prepare('select * from kategoriler order by katadi asc');
                                                    $katList->execute();
                                                    if ($katList->rowCount()) {
                                                        foreach ($katList as $katListSatir) {
                                                    ?>
                                                            <option value="<?php echo $katListSatir['katadi']; ?>"><?php echo $katListSatir['katadi']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Yayın Tarihi</label>
                                                <input type="date" name="tarih" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Yayın Durumu</label>
                                                <select name="durum" class="form-control">
                                                    <option value="">Seçiniz</option>
                                                    <option value="Yayında">Yayında</option>
                                                    <option value="Taslak">Taslak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" value="Kaydet" class="btn btn-success">
                                    </div>
                                </form>

                                <?php
                                // Form işlemi olduğu için if($_POST) unutulmamalı
                                if ($_POST) {
                                    $baslik = $_POST['baslik'];
                                    $icerik = $_POST['icerik'];
                                    $meta = $_POST['meta'];
                                    $alt = $_POST['alt'];
                                    $kategori = $_POST['kategori'];
                                    $tarih = $_POST['tarih'];
                                    $durum = $_POST['durum'];
                                    $gorsel = '../assets/img/' . $_FILES['gorsel']['name'];
                                    //$_FILES['gorsel']['name'] -> dosyanın adını yakalar
                                    //Dosya ekleme işlemi olduğu için ilgili dosyanın otomatik olarak img klasörüne taşınması gerekiyor. move uploded file fonksiyonu kullanılır.

                                    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $gorsel)) {
                                        $yaziKaydet = $db->prepare('insert into yazilar (baslik,icerik,meta,alt,kategori,tarih,durum,gorsel) values (?,?,?,?,?,?,?,?)');
                                        $yaziKaydet->execute(array($baslik, $icerik, $meta, $alt, $kategori, $tarih, $durum, $gorsel));

                                        if ($yaziKaydet->rowCount()) {
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Görsel</th>
                            <th>Başlık</th>
                            <th>İçerik</th>
                            <th>Kategori</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                            <th>Düzenle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $blogList = $db->prepare('select * from yazilar order by id desc');
                        $blogList->execute();
                        if ($blogList->rowCount()) {
                            foreach ($blogList as $blogListSatir) {
                        ?>
                                <tr>
                                    <td><img src="<?php echo $blogListSatir['gorsel']; ?>" class="w-50"></td>
                                    <td><?php echo $blogListSatir['baslik']; ?></td>
                                    <td><?php echo substr($blogListSatir['icerik'],0,111); ?></td>
                                    <td><?php echo $blogListSatir['kategori']; ?></td>
                                    <td><?php echo $blogListSatir['tarih']; ?></td>
                                    <td><?php echo $blogListSatir['durum']; ?></td>
                                    <td><a href="yazi-duzenle.php?id=<?php echo $blogListSatir['id']; ?>"><i class="bi bi-pencil-square text-warning"></i></a></td>
                                    <td><a href="yazilar.php?id=<?php echo $blogListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Yazı Ekle Section End -->

<?php require_once('footer.php'); ?>