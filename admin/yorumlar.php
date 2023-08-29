<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $yorumSil = $db->prepare('delete from yorumlar where id=?');
    $yorumSil->execute(array($id));

    if($yorumSil -> rowCount()){
        echo '<meta http-equiv="refresh" content="0; url=yorumlar.php"><script>alert("Yorum Silindi")</script>';
    } else {
        echo '<meta http-equiv="refresh" content="0; url=yorumlar.php"><script>alert("Hata Oluştu")</script>';
    }
} elseif(isset($_GET['onayID'])){
    $id = $_GET['onayID'];
    $yorumCek = $db -> prepare('select * from yorumlar where id=?');
    $yorumCek -> execute(array($id));
    $yorumCekSatir = $yorumCek -> fetch();

    if($yorumCekSatir['durum'] == '-'){
        $onay = $db -> prepare('update yorumlar set durum=? where id=?');
        $onay -> execute(array('onay',$id));

        if($onay -> rowCount()){
            echo '<meta http-equiv="refresh" content="0; url=yorumlar.php"><script>alert("Yorum Onaylandı")</script>';
        } else {
            echo '<meta http-equiv="refresh" content="0; url=yorumlar.php"><script>alert("Hata Oluştu")</script>';
        }
    } else{
        $iptal = $db -> prepare('update yorumlar set durum=? where id=?');
        $iptal -> execute(array('-',$id));

        if($iptal -> rowCount()){
            echo '<meta http-equiv="refresh" content="0; url=yorumlar.php"><script>alert("Onay İptal Edildi")</script>';
        } else {
            echo '<meta http-equiv="refresh" content="0; url=yorumlar.php"><script>alert("Hata Oluştu")</script>';
        }
    }
}

?>

<!-- Yorumlar Start -->
<section id="yorumList" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Yorumlar</h4>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>E-Posta</th>
                            <th>Yorum</th>
                            <th>Durum</th>
                            <th>Onay</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $yorumList = $db->prepare('select * from yorumlar order by id desc');
                        $yorumList->execute();

                        if ($yorumList->rowCount()) {
                            foreach ($yorumList as $yorumListSatir) {
                        ?>
                                <tr>
                                    <td><?php echo $yorumListSatir['ad']; ?></td>
                                    <td><?php echo $yorumListSatir['eposta']; ?></td>
                                    <td><?php echo $yorumListSatir['yorum']; ?></td>
                                    <td><?php echo $yorumListSatir['durum']; ?></td>
                                    <td><a href="yorumlar.php?onayID=<?php echo $yorumListSatir['id']; ?>"><i class="bi bi-check-square-fill"></i></a></td>
                                    <td><a href="yorumlar.php?id=<?php echo $yorumListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a></td>
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
<!-- Yorumlar End -->

<?php require_once('footer.php'); ?>