<?php 
require_once('header.php'); 

//Get ile gönderilen id parametresi ile data silme start
if($_GET){
    $id = $_GET['id'];
    $katSil = $db -> prepare('delete from kategoriler where id=?');
    $katSil -> execute(array($id));

    if($katSil -> rowCount()){
        echo '<meta http-equiv="refresh" content="0; url=kategori.php">';
    } else {
        echo '<script>alert("Hata Oluştu")</script>';
    }
}
//Get ile gönderilen id parametresi ile data silme end

?>



<!-- category add section start -->
<section id="kategori" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h4>Kategori Ekle</h4>
                <form method="post">
                    <div class="form-group">
                        <input type="text" name="katadi" placeholder="Kategori Adı Girin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Kategori Türü</label>
                        <select name="katturu" class="form-control">
                            <option value="">Seçiniz</option>
                            <option value="Ana Kategori">Ana Kategori</option>
                            <option value="Alt Kategori">Alt Kategori</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ana Kategori Seçin</label>
                        <select name="anakat" class="form-control">
                            <option value="">Seçiniz</option>
                            <?php
                            $anaKatList = $db->prepare('select * from kategoriler order by katadi asc');
                            $anaKatList->execute();

                            if ($anaKatList->rowCount()) {
                                foreach ($anaKatList as $anaKatListSatir) {
                            ?>
                                    <option value="<?php echo $anaKatListSatir['katadi']; ?>">
                                        <?php echo $anaKatListSatir['katadi']; ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="kataciklama" placeholder="Kategori Açıklaması Girin(Max. 160 Karakter)" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Kaydet" class="btn btn-success w-100">
                    </div>
                </form>
                <?php
                if ($_POST) {
                    $katadi = $_POST['katadi'];
                    $katturu = $_POST['katturu'];

                    if ($_POST['anakat'] == '') {
                        $anakat = '-';
                    } else {
                        $anakat = $_POST['anakat'];
                    }

                    $kataciklama = $_POST['kataciklama'];

                    //Kaydetme İşlemi start
                    $katekle = $db->prepare('insert into kategoriler(katadi,katturu,anakat,kataciklama) values(?,?,?,?)');
                    $katekle->execute(array($katadi, $katturu, $anakat, $kataciklama));
                    //Kaydetme İşlemi end

                    //Sonuç Uyarısı Start
                    if ($katekle->rowCount()) {
                        echo '<div class="alert alert-success text-center">Kayıt Başarılı</div>';
                    } else {
                        echo '<div class="alert alert-danger text-center">Hata Oluştu</div>';
                    }
                    //Sonuç Uyarısı End
                }
                ?>
            </div>
            <div class="col-md-9">
                <h4>Kategori Listesi</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Kat. Türü</th>
                            <th>Üst Kategorisi</th>
                            <th>Açıklama</th>
                            <th>Düzenle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $katList = $db->prepare('select * from kategoriler order by id desc');
                        $katList->execute();

                        if ($katList->rowCount()) {
                            foreach ($katList as $katListSatir) {
                        ?>
                                <tr>
                                    <td><?php echo $katListSatir['katadi']; ?></td>
                                    <td><?php echo $katListSatir['katturu']; ?></td>
                                    <td class="text-center"><?php echo $katListSatir['anakat']; ?></td>
                                    <td><?php echo $katListSatir['kataciklama']; ?></td>
                                    <td class="text-center">
                                        <a href="kategori-duzenle.php?id=<?php echo $katListSatir['id']; ?>"><i class="bi bi-pencil-square text-warning"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="kategori.php?id=<?php echo $katListSatir['id']; ?>"><i class="bi bi-trash text-danger"></i></a>
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
<!-- category add section end -->

<?php require_once('footer.php'); ?>