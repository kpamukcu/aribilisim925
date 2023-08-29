<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sayfaSil = $db->prepare('delete from sayfalar where id=?');
    $sayfaSil->execute(array($id));

    if ($sayfaSil->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=sayfalar.php"><script>alert("Kayıt Silinmiştir.")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=sayfalar.php"><script>alert("Hata Oluştu")</script>';
    }
} elseif (isset($_GET['sayfaId'])) {
    $id = $_GET['sayfaId'];
    $sayfaCek = $db->prepare('select * from sayfalar where id=?');
    $sayfaCek->execute(array($id));
    $sayfaCekSatir = $sayfaCek->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#sayfaGuncelle").modal("show");
    });
    </script>
    ';
}
?>

<!-- Sayfalar Section Start -->
<section id="sayfalar" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Sayfalar</h4>
            </div>
            <div class="col-md-6 text-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#sayfaekle">
                    Yeni Sayfa Ekle
                </button>

                <!-- Modal -->
                <div class="modal fade" id="sayfaekle" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sayfaekle" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sayfaekle">Yeni Sayfa Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                <form action="" method="post" class="form-row" enctype="multipart/form-data">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" name="baslik" placeholder="Yazı Başlığı Girin" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="icerik" placeholder="Blog Yazısını Girin"></textarea>
                                            <script>
                                                CKEDITOR.replace('icerik', {
                                                    height: 350
                                                });
                                            </script>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="meta" placeholder="Meta Açıklaması Girin(Max.160 Karakter)" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Öne Çıkan Görsel</label>
                                            <input type="file" name="gorsel">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="alt" placeholder="Görsel Açıklaması Girin" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="kategori" class="form-control">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $katlist = $db->prepare('select * from kategoriler where katturu="Ana Kategori" order by katadi asc');
                                                $katlist->execute();

                                                if ($katlist->rowCount()) {
                                                    foreach ($katlist as $katlistSatir) {
                                                ?>
                                                        <option value="<?php echo $katlistSatir['katadi']; ?>"><?php echo $katlistSatir['katadi']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Alt Kategori</label>
                                            <select name="altkategori" class="form-control">
                                                <option value="">Seçiniz</option>
                                                <?php
                                                $katlist = $db->prepare('select * from kategoriler where katturu="Alt Kategori" order by katadi asc');
                                                $katlist->execute();

                                                if ($katlist->rowCount()) {
                                                    foreach ($katlist as $katlistSatir) {
                                                ?>
                                                        <option value="<?php echo $katlistSatir['katadi']; ?>"><?php echo $katlistSatir['katadi']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Yayın Tarihi</label>
                                            <input type="date" name="tarih" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <select name="durum" class="form-control">
                                                <option value="">Seçiniz</option>
                                                <option value="Taslak">Taslak</option>
                                                <option value="Yayında">Yayında</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Sayfa Türü</label>
                                            <select name="saytur" class="form-control">
                                                <option value="">Seçiniz</option>
                                                <option value="hizmet">Hizmet</option>
                                                <option value="altsayfa">Alt Sayfa</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Kaydet" class="btn btn-success w-100" name="sayfaKaydet">
                                        </div>
                                    </div>
                                </form>

                                <?php
                                if (isset($_POST['sayfaKaydet'])) {
                                    $baslik = $_POST['baslik'];
                                    $icerik = $_POST['icerik'];
                                    $meta = $_POST['meta'];
                                    $gorsel = '../assets/img/' . $_FILES['gorsel']['name'];
                                    $alt = $_POST['alt'];
                                    $kategori = $_POST['kategori'];
                                    $altkategori = $_POST['altkategori'];
                                    $tarih = $_POST['tarih'];
                                    $durum = $_POST['durum'];
                                    $saytur = $_POST['saytur'];

                                    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $gorsel)) {
                                        $sayfaKaydet = $db->prepare('insert into sayfalar(baslik,icerik,meta,gorsel,alt,kategori,altkategori,tarih,durum,saytur) values(?,?,?,?,?,?,?,?,?,?)');
                                        $sayfaKaydet->execute(array($baslik, $icerik, $meta, $gorsel, $alt, $kategori, $altkategori, $tarih, $durum, $saytur));

                                        if ($sayfaKaydet->rowCount()) {
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
        <div class="row mt-3">
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
                        $sayfaList = $db->prepare('select * from sayfalar order by id desc');
                        $sayfaList->execute();
                        if ($sayfaList->rowCount()) {
                            foreach ($sayfaList as $sayfaListSatir) {
                        ?>
                                <tr>
                                    <td class="w-25">
                                        <img src="<?php echo $sayfaListSatir['gorsel']; ?>" class="w-100">
                                    </td>
                                    <td><?php echo $sayfaListSatir['baslik']; ?></td>
                                    <td>
                                        <?php echo substr($sayfaListSatir['icerik'], 0, 150); ?>
                                    </td>
                                    <td><?php echo $sayfaListSatir['kategori']; ?></td>
                                    <td><?php echo $sayfaListSatir['tarih']; ?></td>
                                    <td><?php echo $sayfaListSatir['durum']; ?></td>
                                    <td class="text-center">
                                        <a href="sayfalar.php?sayfaId=<?php echo $sayfaListSatir['id']; ?>"><i class="bi bi-pencil-square text-warning"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="sayfalar.php?id=<?php echo $sayfaListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a>
                                    </td>
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
<!-- Sayfalar Section End -->

<!-- Güncelle Modal Start -->
<div class="modal fade" id="sayfaGuncelle" tabindex="-1" aria-labelledby="sayfaGuncelle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sayfaGuncelle">Sayfa Güncelle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="form-row" enctype="multipart/form-data">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" name="baslik" value="<?php echo $sayfaCekSatir['baslik']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea name="guncelicerik"><?php echo $sayfaCekSatir['icerik']; ?></textarea>
                            <script>
                                CKEDITOR.replace('guncelicerik', {
                                    height: 350
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <textarea name="meta" rows="3" class="form-control"><?php echo $sayfaCekSatir['meta']; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Öne Çıkan Görsel</label>
                            <img src="<?php echo $sayfaCekSatir['gorsel']; ?>" class="img-fluid">
                            <input type="file" name="gorsel" class="mt-3">
                        </div>
                        <div class="form-group">
                            <input type="text" name="alt" value="<?php echo $sayfaCekSatir['alt']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control">
                                <option value="<?php echo $sayfaCekSatir['kategori']; ?>"><?php echo $sayfaCekSatir['kategori']; ?></option>
                                <?php
                                $katlist = $db->prepare('select * from kategoriler where katturu="Ana Kategori" order by katadi asc');
                                $katlist->execute();

                                if ($katlist->rowCount()) {
                                    foreach ($katlist as $katlistSatir) {
                                ?>
                                        <option value="<?php echo $katlistSatir['katadi']; ?>"><?php echo $katlistSatir['katadi']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alt Kategori</label>
                            <select name="altkategori" class="form-control">
                                <option value="<?php echo $sayfaCekSatir['altkategori']; ?>"><?php echo $sayfaCekSatir['altkategori']; ?></option>
                                <?php
                                $katlist = $db->prepare('select * from kategoriler where katturu="Alt Kategori" order by katadi asc');
                                $katlist->execute();

                                if ($katlist->rowCount()) {
                                    foreach ($katlist as $katlistSatir) {
                                ?>
                                        <option value="<?php echo $katlistSatir['katadi']; ?>"><?php echo $katlistSatir['katadi']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Yayın Tarihi</label>
                            <input type="date" name="tarih" class="form-control" value="<?php echo $sayfaCekSatir['tarih']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Durum</label>
                            <select name="durum" class="form-control">
                                <option value="<?php echo $sayfaCekSatir['durum']; ?>"><?php echo $sayfaCekSatir['durum']; ?></option>
                                <option value="Taslak">Taslak</option>
                                <option value="Yayında">Yayında</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Güncelle" class="btn btn-success w-100" name="sayfaGuncelle">
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST['sayfaGuncelle'])) {
                    $baslik = $_POST['baslik'];
                    $guncelicerik = $_POST['guncelicerik'];
                    $meta = $_POST['meta'];
                    $gorsel = '../assets/img/' . $_FILES['gorsel']['name'];
                    $alt = $_POST['alt'];
                    $kategori = $_POST['kategori'];
                    $altkategori = $_POST['altkategori'];
                    $tarih = $_POST['tarih'];
                    $durum = $_POST['durum'];

                    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $gorsel)) {
                        $sayfaGuncelle = $db->prepare('update sayfalar set baslik=?, icerik=?, meta=?, gorsel=?, alt=?, kategori=?, altkategori=?, tarih=?, durum=? where id=?');
                        $sayfaGuncelle->execute(array($baslik, $guncelicerik, $meta, $gorsel, $alt, $kategori, $altkategori, $tarih, $durum, $_GET['sayfaId']));

                        if($sayfaGuncelle -> rowCount()){
                            echo '<meta http-equiv="refresh" content="0; url=sayfalar.php"><script>alert("Kayıt Güncellendi")</script>';
                        } else {
                            echo '<meta http-equiv="refresh" content="0; url=sayfalar.php"><script>alert("Hata Oluştu")</script>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Güncelle Modal End -->

<?php require_once('footer.php'); ?>