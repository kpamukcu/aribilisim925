<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $reklamSil = $db->prepare('delete from reklam where id=?');
    $reklamSil->execute(array($_GET['id']));

    if ($reklamSil->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=reklam.php"><script>alert("Başvuru Silindi")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=reklam.php"><script>alert("Hata Oluştu")</script>';
    }
} elseif (isset($_GET['basNo'])) {
    $basvuruOku = $db->prepare('select * from reklam where id=?');
    $basvuruOku->execute(array($_GET['basNo']));
    $basvuruOkuSatir = $basvuruOku->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#myModal").modal("show");
    });
    </script>
    ';
} elseif (isset($_GET['onayId'])) {
    $reklamOnay = $db->prepare('update reklam set durum="Onaylandı" where id=?');
    $reklamOnay->execute(array($_GET['onayId']));

    if ($reklamOnay->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=reklam.php"><script>alert("Başvuru Onaylandı")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=reklam.php"><script>alert("Hata Oluştu")</script>';
    }
} elseif(isset($_GET['onayiptalId'])){
    $onayIptal = $db -> prepare('update reklam set durum="Beklemede" where id=?');
    $onayIptal -> execute(array($_GET['onayiptalId']));

    if ($onayIptal->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=reklam.php"><script>alert("Onay İptal Edildi")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=reklam.php"><script>alert("Hata Oluştu")</script>';
    }

}
?>



<!-- Reklam List Section Start -->
<section id="reklamList" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Reklam Talepleri</h4>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Baş.No</th>
                            <th>Adı</th>
                            <th>Telefon</th>
                            <th>E-Posta</th>
                            <th>Durum</th>
                            <th class="text-center">Oku</th>
                            <th class="text-center">Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $reklamList = $db->prepare('select * from reklam order by id desc');
                        $reklamList->execute();

                        if ($reklamList->rowCount()) {
                            foreach ($reklamList as $reklamListSatir) {
                        ?>
                                <tr>
                                    <td><?php echo $reklamListSatir['id']; ?></td>
                                    <td><?php echo $reklamListSatir['adi']; ?></td>
                                    <td><?php echo $reklamListSatir['telefon']; ?></td>
                                    <td><?php echo $reklamListSatir['eposta']; ?></td>
                                    <td><?php echo $reklamListSatir['durum']; ?></td>
                                    <td class="text-center"><a href="reklam.php?basNo=<?php echo $reklamListSatir['id']; ?>"><i class="bi bi-eye-fill"></i></a></td>
                                    <td class="text-center"><a href="reklam.php?id=<?php echo $reklamListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a></td>
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
<!-- Reklam List Section End -->

<!-- Reklam Başvuru Oku Modal Start -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal"><?php echo $basvuruOkuSatir['id']; ?> Nolu Başvuru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src=".<?php echo $basvuruOkuSatir['gorsel']; ?>" class="w-100">
                <div class="row py-3">
                    <div class="col-md-4">
                        <b>Adı Soyadı</b><br>
                        <?php echo $basvuruOkuSatir['adi']; ?>
                    </div>
                    <div class="col-md-3">
                        <b>Telefon No</b><br>
                        <?php echo $basvuruOkuSatir['telefon']; ?>
                    </div>
                    <div class="col-md-5">
                        <b>E-Posta Adresi</b><br>
                        <?php echo $basvuruOkuSatir['eposta']; ?>
                    </div>
                    <div class="col-12 mt-3">
                        <b>Açıklama</b><br>
                        <?php echo $basvuruOkuSatir['aciklama']; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php

                if ($basvuruOkuSatir['durum'] == 'Beklemede') {
                ?>
                    <a href="reklam.php?onayId=<?php echo $basvuruOkuSatir['id']; ?>"><button type="button" class="btn btn-secondary">Onayla</button></a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">İptal</button>
                <?php
                } elseif($basvuruOkuSatir['durum'] == 'Onaylandı'){
                    ?>
                    <a href="reklam.php?onayiptalId=<?php echo $basvuruOkuSatir['id']; ?>"><button type="button" class="btn btn-secondary">Onay İptal</button></a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">İptal</button>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Reklam Başvuru Oku Modal End -->

<?php require_once('footer.php'); ?>