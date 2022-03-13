<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Fesa - LPG Tankı Üretim Takip Programı</title>
        <meta content="Matgis Bilişim" name="author" />
        <link rel="shortcut icon" href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/images/favicon.png">
        <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background-image:url(<?php echo SITE_URL; ?>/themes/assets/images/bg_ymm.jpg);">
        <!-- Begin page -->
        <div class="wrapper-page">
            <div class="card" style="background-color: transparent;border:2px solid #c4ebfc;">
                <div class="card-body" style="border:none;">
                    <h3 class="text-center m-0">
                        <a href="<?php echo SITE_URL; ?>" class="logo logo-admin"><img src="<?=SITE_URL?>/upload/images/logo.png" height="70" alt="logo"></a>
                    </h3>
                    <div class="p-3">
                        <h4 class="text-white font-18 m-b-5 text-center">Fesa Giriş Alanı</h4>
                        <form class="form-horizontal m-t-30" action="<?php echo SITE_URL; ?>/yonetici/giriskontrolu" method="POST">
                            <div class="form-group" style="background:#fff;">
                                <label for="username">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="kullaniciAdi" placeholder="Kullanıcı Adı" required autofocus>
                            </div>
                            <div class="form-group" style="background:#fff;">
                                <label for="userpassword">Şifre</label>
                                <input type="password" class="form-control" id="userpassword" name="kullaniciSifre" placeholder="Şifre Alanı" required>
                            </div>
                            <div class="form-group row m-t-20" style="background:transparent;">
                                <div class="col-6">
                                <a href="<?php echo SITE_URL; ?>/user/resetpassword/" class="text-white-50"><i class="mdi mdi-lock"></i> Şifremi Unuttum</a>
                                </div>
                                <div class="col-6 text-right">
                                    <button class="btn btn-success w-md" type="submit">Giriş Yap</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery  -->
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/jquery.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/metisMenu.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/waves.min.js"></script>
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
        <!-- App js -->
        <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/app.js"></script>
        <script>
            $(document).ready(function(){
                document.getElementById('username').addEventListener('input', function (e) {
                var x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,3})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
            });
            }); 
        </script>
    </body>
</html>