<?php
require_once('baglan.php');
session_start();
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

    <title>Admin Giriş</title>
</head>

<body>

    <!-- Login Form Start -->
    <section id="loginForm">
        <div class="container">
            <div class="row" style="height: 70vh;">
                <div class="col-md-4 m-auto text-center">
                    <img src="../assets/img/aribilgi-logo.webp">
                    <form method="post" class="mt-4">
                        <div class="form-group">
                            <input type="text" name="kadi" placeholder="Kullanıcı Adınız" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="sifre" placeholder="Şifreniz" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gönder" class="btn btn-success w-100">
                        </div>
                    </form>

                    <?php
                    if ($_POST) {
                        $kadi = $_POST['kadi'];
                        $sifre = $_POST['sifre'];

                        if ($kadi == 'Admin' && $sifre == '123') {                            
                            echo '<div class="alert alert-success">Kullanıcı Adı ve Şifreniz Doğru.<br>Lütfen Bekleyin</div><meta http-equiv="refresh" content="2; url=dashboard.php">';
                            $_SESSION['user'] = $kadi;
                        } else {
                            echo '<div class="alert alert-danger">Kullanıcı Adı ve/veya Şifreniz Hatalı.</div>';
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>
    <!-- Login Form End -->

    <script src="../assets/js/jquery.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</body>

</html>