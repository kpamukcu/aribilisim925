<?php
require_once('header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $ayrinti = $db->prepare('select * from portfolyo where id=?');
    $ayrinti->execute(array($id));
    $ayrintiSatir = $ayrinti->fetch();

    echo '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      $("#myModal").modal("show");
    });
    </script>
    ';
}

?>

<!-- Main Banner Start -->
<section id="mainBanner" class="py-8 bg-lila text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <small><a href="index.php" class="text-decoration-none text-mor">Ana Sayfa</a> / Portfolyo</small>
                <h1 class="display-2">Portfolyo</h1>
            </div>
        </div>
    </div>
</section>
<!-- Main Banner End -->

<!-- Proje List Start -->
<section id="projeList" class="py-5">
    <div class="container">
        <div class="row">
            <?php
            $portfolyoList = $db->prepare('select * from portfolyo order by id desc');
            $portfolyoList->execute();

            if ($portfolyoList->rowCount()) {
                foreach ($portfolyoList as $portfolyoListSatir) {
            ?>
                    <div class="col-md-4 mt-4">
                        <div class="card">
                            <img src="<?php echo substr($portfolyoListSatir['gorsel'], 3); ?>" alt="<?php echo $portfolyoListSatir['projeadi']; ?>" class="w-100">
                            <div class="card-body">
                                <h2 class="lead"><b><?php echo $portfolyoListSatir['projeadi']; ?></b></h2>
                            </div>
                            <div class="card-footer text-right">
                                <a href="portfolyo.php?id=<?php echo $portfolyoListSatir['id']; ?>" class="btn btn-info">Ayrıntılar</a>
                                <a href="<?php echo $portfolyoListSatir['projeadresi']; ?>" class="btn btn-warning" target="blank">Siteyi Ziyaret Et</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>
<!-- Proje List End -->

<!-- Porje Ayrıntı Modal Start -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal"><?php echo $ayrintiSatir['projeadi']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="<?php echo substr($ayrintiSatir['gorsel'], 3); ?>" alt="<?php echo $ayrintiSatir['projeadi']; ?>" class="w-100 border">
                <div class="row mt-4">
                    <div class="col-md-3">
                        <b>Proje Türü</b><br>
                        <span><?php echo $ayrintiSatir['turu']; ?></span>
                    </div>
                    <div class="col-md-3">
                        <b>Verilen Hizmet</b><br>
                        <span><?php echo $ayrintiSatir['projeCinsi']; ?></span>
                    </div>
                    <div class="col-md-3">
                        <b>Sektör Bilgisi</b><br>
                        <span><?php echo $ayrintiSatir['sektor']; ?></span>
                    </div>
                    <div class="col-md-3">
                        <b>Teknoloji</b><br>
                        <span><?php echo $ayrintiSatir['teknoloji']; ?></span>
                    </div>
                    <div class="col-12">
                        <b>Konu</b><br>
                        <span><?php echo $ayrintiSatir['konu']; ?></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?php echo $ayrintiSatir['projeadresi']; ?>" class="btn btn-success" target="_blank">Siteyi Ziyaret Et</a>
            </div>
        </div>
    </div>
</div>
<!-- Porje Ayrıntı Modal End -->

<?php require_once('footer.php'); ?>