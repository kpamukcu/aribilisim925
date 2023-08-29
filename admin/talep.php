<?php
require_once('header.php');

if (isset($_GET['silId'])) {
    $id = $_GET['silId'];
    $talepSil = $db->prepare('delete from talep where id=?');
    $talepSil->execute(array($id));

    if ($talepSil->rowCount()) {
        echo '<meta http-equiv="refresh" content="0; url=talep.php"><script>alert("Talep Silindi")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=talep.php"><script>alert("Hata Oluştu. Tekrar Deneyin")</script>';
    }
} elseif (isset($_GET['talepId'])) {
    $id = $_GET['talepId'];
    $talepOku = $db->prepare('select * from talep where id=?');
    $talepOku->execute(array($id));
    $talepOkuSatir = $talepOku->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#myModal").modal("show");
    });
    </script>
    ';
}

?>



<!-- Talep List Section Start -->
<section id="talepler" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Hizmet Talepleri</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Talep No</th>
                            <th>Adı Soyadı</th>
                            <th>Telefon</th>
                            <th>Oku</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $talepList = $db->prepare('select * from talep order by id desc');
                        $talepList->execute();

                        if ($talepList->rowCount()) {
                            foreach ($talepList as $talepListSatir) {
                        ?>
                                <tr>
                                    <td><?php echo $talepListSatir['id']; ?></td>
                                    <td><?php echo $talepListSatir['adi']; ?></td>
                                    <td><?php echo $talepListSatir['telefon']; ?></td>
                                    <td><a href="talep.php?talepId=<?php echo $talepListSatir['id']; ?>"><i class="bi bi-eye-fill"></i></a></td>
                                    <td><a href="talep.php?silId=<?php echo $talepListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a></td>
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
<!-- Talep List Section End -->

<!-- Talep Oku Modal Start -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal"><?php echo $talepOkuSatir['sayfa']; ?> Yeni Talep</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <b>Kimden:</b> <?php echo $talepOkuSatir['adi']; ?> <br>
                <b>Telefon:</b> <a href="tel:<?php echo $talepOkuSatir['telefon']; ?>"><?php echo $talepOkuSatir['telefon']; ?></a> <br>
                <b>E-Posta:</b> <a href="mailto:<?php echo $talepOkuSatir['eposta']; ?>"><?php echo $talepOkuSatir['eposta']; ?></a> <br>
                <b>Açıklama:</b> <?php echo $talepOkuSatir['info']; ?> <br><br>
                Ek Dosyayı Görmek için <a href=".<?php echo $talepOkuSatir['dosya']; ?>">Tıklayın</a>
            </div>
        </div>
    </div>
</div>
<!-- Talep Oku Modal End -->


<?php require_once('footer.php'); ?>