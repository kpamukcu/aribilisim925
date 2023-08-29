<?php
require_once('header.php');

if (isset($_GET['projeId'])) {
    $id = $_GET['projeId'];
    $projeGor = $db->prepare('select * from portfolyo where id=?');
    $projeGor->execute(array($id));
    $projeGorSatir = $projeGor->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#projeGor").modal("show");
    });
    </script>
    ';
} elseif (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    $portfolyoSil = $db->prepare('delete from portfolyo where id=?');
    $portfolyoSil->execute(array($id));

    if ($portfolyoSil->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=portfolyo.php"><script>alert("Kayıt Silinmiştir")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=portfolyo.php"><script>alert("Hata Oluştu")</script>';
    }
} elseif (isset($_GET['guncelle'])) {
    $id = $_GET['guncelle'];
    $portfolyoCek = $db->prepare('select * from portfolyo where id=?');
    $portfolyoCek->execute(array($id));
    $portfolyoCekSatir = $portfolyoCek->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#guncelle").modal("show");
    });
    </script>
    ';
}

?>



<!-- Portfolyo Ekle Section Start -->
<section id="portfolyo" class="py-5">
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-6">
                <h4>Portfolyo</h4>
            </div>
            <div class="col-md-6 text-right">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#staticBackdrop">
                    Yeni Ekle
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Portfolyo Ekle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="projeadi" placeholder="Proje Adını Girin" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <select name="turu" class="form-control">
                                            <option value="">Proje Türü Seçiniz</option>
                                            <option value="Kurumsal">Kurumsal</option>
                                            <option value="Bireysel">Bireysel</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="projeCinsi" class="form-control">
                                            <option value="">Proje Cinsini Seçiniz</option>
                                            <option value="Web Tasarımı">Web Tasarımı</option>
                                            <option value="Grafik Tasarımı">Grafik Tasarımı</option>
                                            <option value="Dijital Pazarlama">Dijital Pazarlama</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="sektor" placeholder="Sektör Bilgisi" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="teknoloji" placeholder="Kullanılan Teknolojileri Girin" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="url" name="projeadresi" placeholder="Proje Adresini Girin" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="konu" placeholder="Proje Konusu" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Proje Görseli</label><br>
                                        <input type="file" name="gorsel">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Kaydet" class="btn btn-success w-100" name="kaydet">
                                    </div>
                                </form>
                                <?php
                                if (isset($_POST['kaydet'])) {
                                    $projeadi = $_POST['projeadi'];
                                    $turu = $_POST['turu'];
                                    $projeCinsi = $_POST['projeCinsi'];
                                    $sektor = $_POST['sektor'];
                                    $teknoloji = $_POST['teknoloji'];
                                    $projeadresi = $_POST['projeadresi'];
                                    $konu = $_POST['konu'];
                                    $gorsel = '../assets/img/' . $_FILES['gorsel']['name'];

                                    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $gorsel)) {
                                        $projeKaydet = $db->prepare('insert into portfolyo(projeadi,turu,projeCinsi,sektor,teknoloji,projeadresi,konu,gorsel) values(?,?,?,?,?,?,?,?)');
                                        $projeKaydet->execute(array($projeadi, $turu, $projeCinsi, $sektor, $teknoloji, $projeadresi, $konu, $gorsel));

                                        if ($projeKaydet->rowCount()) {
                                            echo '<meta http-equiv="refresh" content="0; url=portfolyo.php"><script>alert("Kayıt Başarılı")</script>';
                                        } else {
                                            echo '<meta http-equiv="refresh" content="0; url=portfolyo.php"><script>alert("Hata Oluştu")</script>';
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
                            <th>Proje Adı</th>
                            <th>Proje Türü</th>
                            <th>Proje Cinsi</th>
                            <th>Teknoloji</th>
                            <th class="text-center">İncele</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $projeList = $db->prepare('select * from portfolyo order by id and projeCinsi desc');
                        $projeList->execute();

                        if ($projeList->rowCount()) {
                            foreach ($projeList as $projeListSatir) {
                        ?>
                                <tr>
                                    <td class="w-25"><img src="<?php echo $projeListSatir['gorsel']; ?>" class="w-100"></td>
                                    <td><?php echo $projeListSatir['projeadi']; ?></td>
                                    <td><?php echo $projeListSatir['turu']; ?></td>
                                    <td><?php echo $projeListSatir['projeCinsi']; ?></td>
                                    <td><?php echo $projeListSatir['teknoloji']; ?></td>
                                    <td class="text-center"><a href="portfolyo.php?projeId=<?php echo $projeListSatir['id']; ?>"><i class="bi bi-eye-fill"></i></a></td>
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
<!-- Portfolyo Ekle Section End -->

<!-- Portfolyo Gör Modal Start -->
<div class="modal fade" id="projeGor" tabindex="-1" aria-labelledby="projeGor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projeGor"><?php echo $projeGorSatir['projeadi']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <img src="<?php echo $projeGorSatir['gorsel']; ?>" class="w-100">
                    </div>
                    <div class="col-md-3">
                        <b>Proje Türü:</b><br>
                        <span><?php echo $projeGorSatir['turu']; ?></span> <br>
                    </div>
                    <div class="col-md-3">
                        <b>Proje Cinsi:</b> <br>
                        <span><?php echo $projeGorSatir['projeCinsi']; ?></span><br>
                    </div>
                    <div class="col-md-3">
                        <b>Sektör</b><br>
                        <span><?php echo $projeGorSatir['sektor']; ?></span><br>
                    </div>
                    <div class="col-md-3">
                        <b>Teknoloji</b><br>
                        <span><?php echo $projeGorSatir['teknoloji']; ?></span><br>
                    </div>
                    <div class="col-12">
                        <b>Konu:</b><br>
                        <span><?php echo $projeGorSatir['konu']; ?></span><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?php echo $projeGorSatir['projeadresi']; ?>" target="_blank"><button type="button" class="btn btn-primary">Siteyi Gör</button></a>
                <a href="portfolyo.php?guncelle=<?php echo $projeGorSatir['id']; ?>"><button type="button" class="btn btn-warning">Güncelle</button></a>
                <a href="portfolyo.php?sil=<?php echo $projeGorSatir['id']; ?>"><button type="button" class="btn btn-danger">Sil</button></a>
            </div>
        </div>
    </div>
</div>
<!-- Portfolyo Gör Modal End -->

<!-- Portfolyo Güncelle Start -->
<div class="modal fade" id="guncelle" tabindex="-1" aria-labelledby="guncelle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guncelle"><?php echo $portfolyoCekSatir['projeadi']; ?> Güncelle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="projeadi" value="<?php echo $portfolyoCekSatir['projeadi']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <select name="turu" class="form-control">
                            <option value="<?php echo $portfolyoCekSatir['turu']; ?>"><?php echo $portfolyoCekSatir['turu']; ?></option>
                            <option value="Kurumsal">Kurumsal</option>
                            <option value="Bireysel">Bireysel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="projeCinsi" class="form-control">
                            <option value="<?php echo $portfolyoCekSatir['projeCinsi']; ?>"><?php echo $portfolyoCekSatir['projeCinsi']; ?></option>
                            <option value="Web Tasarımı">Web Tasarımı</option>
                            <option value="Grafik Tasarımı">Grafik Tasarımı</option>
                            <option value="Dijital Pazarlama">Dijital Pazarlama</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="sektor" value="<?php echo $portfolyoCekSatir['sektor']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="teknoloji" value="<?php echo $portfolyoCekSatir['teknoloji']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="url" name="projeadresi" value="<?php echo $portfolyoCekSatir['projeadresi']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea name="konu" rows="3" class="form-control"><?php echo $portfolyoCekSatir['konu']; ?></textarea>
                    </div>
                    <div class="form-group text-left">
                        <label>Proje Görseli</label><br>
                        <input type="file" name="gorsel"> <br>
                        <img src="<?php echo $portfolyoCekSatir['gorsel']; ?>" class="w-25 mt-2">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Güncelle" class="btn btn-success w-100" name="guncelle">
                    </div>
                </form>
                <?php
                if (isset($_POST['guncelle'])) {
                    $projeadi = $_POST['projeadi'];
                    $turu = $_POST['turu'];
                    $projeCinsi = $_POST['projeCinsi'];
                    $sektor = $_POST['sektor'];
                    $teknoloji = $_POST['teknoloji'];
                    $projeadresi = $_POST['projeadresi'];
                    $konu = $_POST['konu'];
                    $gorsel = '../assets/img/' . $_FILES['gorsel']['name'];

                    if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $gorsel)) {
                        $portfolyoGuncelle = $db->prepare('update portfolyo set projeadi=?, turu=?, projeCinsi=?, sektor=?, teknoloji=?, projeadresi=?, konu=?, gorsel=? where id=?');
                        $portfolyoGuncelle->execute(array($projeadi, $turu, $projeCinsi, $sektor, $teknoloji, $projeadresi, $konu, $gorsel, $id));

                        if($portfolyoGuncelle -> rowCount()){
                            echo '<meta http-equiv="refresh" content="0; url=portfolyo.php"><script>alert("Kayıt Güncellendi")</script>';
                        } else {
                            echo '<meta http-equiv="refresh" content="0; url=portfolyo.php"><script>alert("Hata Oluştu")</script>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Portfolyo Güncelle End -->



<?php require_once('footer.php'); ?>