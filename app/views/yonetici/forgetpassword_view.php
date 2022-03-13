<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>YMM || Mükellef Takip Sistemi</title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/images/favicon.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/css/style.css" rel="stylesheet">
    <style>
    html {
          background: url(<?php echo SITE_TEMPLATE_YONETIM; ?>/img/background_ofiserp.jpg) no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
    }
    </style>
</head>

<body class="login-page">
        <div class="card">
            <div class="body">
        <div class="logo">
            <a href="javascript:void(0);"><img height="85" src="<?php echo SITE_TEMPLATE_YONETIM; ?>/img/logo.png"></a>
        </div>                
                <form id="forgot_password" action="<?php echo SITE_URL; ?>/yonetici/resetpassword" method="POST">
                    <h4 class="msg" lang="tr" style="text-transform: uppercase;text-align:center;">Şifre Yenileme Ekranı</h4>
                    <p style="text-align: center;">Kayıt için kullandığınız e-posta adresinizi girin. Size kullanıcı adınızı ve şifrenizi sıfırlamak için bir bağlantı içeren bir e-posta göndereceğiz.</p>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="kullaniciEmail" placeholder="Email Adresi" required autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-block bg-blue waves-effect" type="submit" data-loading-text="Yeni Şifre Talebiniz İletiliyor Lütfen Bekleyiniz..."><i class="material-icons">vpn_key</i> Şifremi Resetle</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6 align-right">
                            <a href="<?php echo SITE_URL; ?>/giris"><i class="material-icons">lock</i> Giriş Yap</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/js/admin.js"></script>
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/js/pages/examples/sign-in.js"></script>

</body>

</html>
