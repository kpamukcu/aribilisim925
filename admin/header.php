<?php
session_start();
require_once('baglan.php');

if (!isset($_SESSION['user'])) {
    die('Giriş Yetkiniz Yoktur.');
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Css Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- CkEditor 4 Cdn -->
    <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    <title>Arı Bilişim Admin Paneli</title>
</head>

<body>

    <!-- Admin Page Start -->
    <section id="admin">
        <div class="container-fluid">
            <div class="row bg-dark">
                <div class="col-12 text-right">
                    <a href="logout.php" class="text-white">Güvenli Çıkış</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 bg-dark" style="min-height:96vh;">
                    <ul class="list-group">
                        <a href="dashboard.php">
                            <li class="list-group-item">Başlangıç</li>
                        </a>
                        <a href="reklam.php">
                            <li class="list-group-item">Reklam Başvuruları</li>
                        </a>
                        <a href="talep.php">
                            <li class="list-group-item">Hizmet Talepleri</li>
                        </a>
                        <a href="kategori.php">
                            <li class="list-group-item">Kategoriler</li>
                        </a>
                        <a href="yazilar.php">
                            <li class="list-group-item">Yazılar</li>
                        </a>
                        <a href="sayfalar.php">
                            <li class="list-group-item">Sayfalar</li>
                        </a>
                        <a href="portfolyo.php">
                            <li class="list-group-item">Portfolyo</li>
                        </a>
                        <a href="mesajlar.php">
                            <li class="list-group-item">Mesajlar</li>
                        </a>
                        <a href="yorumlar.php">
                            <li class="list-group-item">Yorumlar</li>
                        </a>
                        <a href="ayarlar.php">
                            <li class="list-group-item">Ayarlar</li>
                        </a>
                        <div class="dropdown">
                            <button id="acilirButon" class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                Üyeler
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="euyeler.php">E-Bülten Üyeler</a>
                                <a class="dropdown-item" href="uye-admin.php">Yöneticiler</a>
                            </div>
                        </div>
                    </ul>
                </div>
                <div class="col-md-10">