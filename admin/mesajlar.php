<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mesajSil = $db->prepare('delete from iletisim where id=?');
    $mesajSil->execute(array($id));

    if ($mesajSil->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=mesajlar.php"><script>alert("Mesaj Silindi")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=mesajlar.php"><script>alert("Hata Oluştu")</script>';
    }
} elseif (isset($_GET['oku'])) {
    $mesajOku = $db->prepare('select * from iletisim where id=?');
    $mesajOku->execute(array($_GET['oku']));
    $mesajOkuSatir = $mesajOku->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#myModal").modal("show");
    });
    </script>
    ';
}
?>

<!-- Mesaj List Start -->
<section id="mesajList" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Mesaj Kutusu</h4>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Telefon</th>
                            <th>E-Posta</th>
                            <th>Konu</th>
                            <th>Durum</th>
                            <th>Oku</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $mesajList = $db->prepare('select * from iletisim order by id desc');
                        $mesajList->execute();

                        if ($mesajList->rowCount()) {
                            foreach ($mesajList as $mesajListSatir) {
                        ?>
                                <tr>
                                    <td><?php echo $mesajListSatir['adiniz']; ?></td>
                                    <td><?php echo $mesajListSatir['telefon']; ?></td>
                                    <td><?php echo $mesajListSatir['eposta']; ?></td>
                                    <td><?php echo $mesajListSatir['konu']; ?></td>
                                    <td><?php echo $mesajListSatir['durum']; ?></td>
                                    <td><a href="mesajlar.php?oku=<?php echo $mesajListSatir['id']; ?>"><i class="bi bi-eye-fill"></i></a></td>
                                    <td><a href="mesajlar.php?id=<?php echo $mesajListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a></td>
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

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal"><?php echo $mesajOkuSatir['adiniz']."'dan Gelen Mesaj" ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <b>Kimden:</b> <?php echo $mesajOkuSatir['adiniz']; ?><br>
                <b>E-Posta:</b> <?php echo $mesajOkuSatir['eposta']; ?><br>
                <b>Konu:</b> <?php echo $mesajOkuSatir['konu']; ?> <br><br>
                <b>Mesaj:</b><br>
                <?php echo $mesajOkuSatir['mesaj']; ?>
            </div>
            <div class="modal-footer">
                <a href="mesajlar.php?sondurum=<?php echo $mesajOkuSatir['id']; ?>"><button type="button" class="btn btn-secondary" name="sondurum">Okundu</button></a>
                <button type="button" class="btn btn-primary">Cevap Ver</button>
            </div>
        </div>
    </div>
</div>
<!-- Mesaj List End -->

<?php
if(isset($_GET['sondurum'])){
    $durumguncelle = $db -> prepare('update iletisim set durum=? where id=?');
    $durumguncelle -> execute(array('okundu', $_GET['sondurum']));

    if($durumguncelle -> rowCount()){
        echo '<meta http-equiv="refresh" content="0; url=mesajlar.php"><script>alert("Durum Güncellendi")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=mesajlar.php"><script>alert("Hata Oluştu")</script>';
    }
}


// if(isset($_GET['sondurum'])){
//     if($mesajOkuSatir['durum'] == 'okunmadı'){
//         $durumguncelle = $db -> prepare('update iletisim set durum=? where id=?');
//         $durumguncelle -> execute(array('okundu', $_GET['sondurum']));
//     } elseif($mesajOkuSatir['durum'] == 'okundu'){
//         $durumguncelle = $db -> prepare('update iletisim set durum=? where id=?');
//         $durumguncelle -> execute(array('okunmadı', $_GET['sondurum']));
//     }
// }
?>



<?php require_once('footer.php'); ?>