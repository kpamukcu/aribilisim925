<?php require_once('header.php'); ?>

<!-- Sayfalar Section Start -->
<section id="sayfaEkle" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Sayfa Ekle</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
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
                            <input type="submit" value="Kaydet" class="btn btn-success w-100">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Sayfalar Section End -->

<?php require_once('footer.php'); ?>