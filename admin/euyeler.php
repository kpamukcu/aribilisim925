<?php
require_once('header.php');

if (isset($_GET['uyeID'])) {
    $uyeSil = $db->prepare('delete from ebulten where id=?');
    $uyeSil->execute(array($_GET['uyeID']));

    if ($uyeSil->rowCount()) {
        echo '
        <meta http-equiv="refresh" content="0; url=euyeler.php">
        <script>alert("Kayıt Silindi")</script>
        ';
    } else {
        echo '
        <meta http-equiv="refresh" content="0; url=euyeler.php">
        <script>alert("Hata Oluştu")</script>
        ';
    }
} elseif (isset($_GET['id'])) {
    $uyemailGuncelle = $db->prepare('select * from ebulten where id=?');
    $uyemailGuncelle->execute(array($_GET['id']));
    $uyemailGuncelleSatir = $uyemailGuncelle->fetch();


    echo '
            <script>
            document.addEventListener("DOMContentLoaded", function() {
            $("#myModal").modal("show");
            });
            </script>
            ';
}

?>


<!-- Güncelle Modal Start -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal">Üye Mail Adresi Güncelle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="email" name="eposta" value="<?php echo $uyemailGuncelleSatir['eposta']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Güncelle" class="btn btn-success w-100">
                    </div>
                </form>
                <?php
                if ($_POST) {
                    $epostaGuncelle = $db->prepare('update ebulten set eposta=? where id=?');
                    $epostaGuncelle->execute(array($_POST['eposta'],$_GET['id']));

                    if ($epostaGuncelle->rowCount()) {
                        echo '<meta http-equiv="refresh" content="0; url=euyeler.php"><script>alert("Kayıt Güncellendi")</script>';
                    } else {
                        echo '<meta http-equiv="refresh" content="0; url=euyeler.php"><script>alert("Hata Oluştu")</script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Güncelle Modal End -->


<!-- Ebülten Üyeler Section Start -->
<section id="ebultenuyeler" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="lead">E-Bülten Üye Listesi</h4>
            </div>
            <div class="col-12 pt-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>E-Posta</th>
                            <th class="text-center">Düzenle</th>
                            <th class="text-center">Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ebultenuyeList = $db->prepare('select * from ebulten order by id desc');
                        $ebultenuyeList->execute();

                        if ($ebultenuyeList->rowCount()) {
                            foreach ($ebultenuyeList as $ebultenuyeListSatir) {
                        ?>
                                <tr>
                                    <td>
                                        <?php echo $ebultenuyeListSatir['id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $ebultenuyeListSatir['eposta']; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="euyeler.php?id=<?php echo $ebultenuyeListSatir['id']; ?>">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="euyeler.php?uyeID=<?php echo $ebultenuyeListSatir['id']; ?>">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
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
<!-- Ebülten Üyeler Section End -->

<?php require_once('footer.php'); ?>