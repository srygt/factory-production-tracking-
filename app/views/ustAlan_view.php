<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Fesa || LPG Tank Takip Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Matgis Bilişim">
    <!-- App Favicon -->
    <link rel="shortcut icon" href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/images/favicon.png">
    <link rel="stylesheet" href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/morris/morris.css">
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- C3 charts css -->
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/c3/c3.min.css" rel="stylesheet" type="text/css" />
    <!-- jQuery  -->
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo SITE_TEMPLATE_YONETIM; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <!--calendar css-->
    <!-- Plugins css -->
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo SITE_TEMPLATE_YONETIM; ?>/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />    
    <script>
            // Tank Arama Alanı
            $(document).ready(function(){  
                $('.search-tank input[type="text"]').on("keyup input", function(){
                    /* Input Box'da değişiklik olursa aşağıdaki durumu çalıştırıyoruz. */
                    var inputVal        = $(this).val();
                    var resultDropdown  = $(this).siblings(".liveresulttank");
                    if(inputVal.length){
                        $.get('<?=SITE_URL?>/uretim/tanklist', {lng: inputVal}).done(function(data){
                            /* Gelen sonucu ekrana yazdırıyoruz. */
                            resultDropdown.html(data);
                            //  ret = DetailsView.GetProject($(this).attr("#data-id"), OnComplete, OnTimeOut, OnError);
                        });
                    }else{
                        resultDropdown.empty();
                    }
                });
                /* Sonuç listesinden üzerinde tıklanıp bir öğe seçilirse input box'a yazdırıyoruz. */
                $(document).on("click", ".liveresulttank li", function(){
                    $(this).parents(".search-tank").find('input[type="text"]').val($(this).text());
                    $(this).parent(".liveresulttank").empty();
                    var lng         = $(this).attr("data-id");
                    var kapaken     = $(this).attr("data-price");
                    var kapakboy    = $(this).attr("data-size");
                    var govdeboy    = $(this).attr("data-title");
                    var govdeen     = $(this).attr("data-prefix");
                    var adets       = $('#adet').val();
                    var sacboyu     = $('#boyual').val();
                    var kesimturu   = $("input[name='kesimturu']:checked").val();
                    $('#tankID').val(lng);
                    if(kesimturu=='kapak'){
                    var fire        = sacboyu-(Math.floor(sacboyu/kapakboy)*kapakboy);
                    var bolmesayisi = Math.floor(sacboyu/kapakboy);
                    $('#enimh').val(kapaken);
                    $('#boyumh').val(kapakboy);                        
                    $('#enimhh').val(kapaken);
                    var sacbolmes   = Math.floor(sacboyu/kapakboy)*adets;
                    $('#olculer').text(kapaken+'X'+kapakboy);
                    $('#carpim').text(Math.floor(sacboyu/kapakboy)+'X'+adets);
                    $('#ebatadet').text(sacbolmes);
                    $('#firetoplami').text(fire+' mm Fire Bulunmaktadır.');                    
                    $('#kesilenadet').val(sacbolmes);                    
                    $('#adetimh').val(sacbolmes);
                    $('#enfire').val(fire);
                    $('#bolmesayisi').val(bolmesayisi);
                    $('#boyual').val(kapakboy);
                    $('#tabloen0').text(kapaken);
                    $('#tabloboy0').text(kapakboy);
                    $('#tabloen1').text(kapaken);
                    $('#tabloboy1').text(kapakboy);
                    $('#tabloen2').text(kapaken);
                    $('#tabloboy2').text(kapakboy);                     
                    }else if(kesimturu=='govde'){
                    var fire        = sacboyu-(Math.floor(sacboyu/govdeboy)*govdeboy);
                    var bolmesayisi = Math.floor(sacboyu/govdeboy);
                    $('#enimh').val(govdeen);
                    $('#boyumh').val(govdeboy);                        
                    $('#enimhh').val(govdeen);
                    var sacbolmes   = Math.floor(sacboyu/govdeboy)*adets;
                    $('#olculer').text(govdeen+'X'+govdeboy);
                    $('#carpim').text(Math.floor(sacboyu/govdeboy)+'X'+adets);
                    $('#ebatadet').text(sacbolmes);
                    $('#firetoplami').text(fire+' mm Fire Bulunmaktadır.');                    
                    $('#kesilenadet').val(sacbolmes);                    
                    $('#adetimh').val(sacbolmes);
                    $('#enfire').val(fire);
                    $('#bolmesayisi').val(bolmesayisi);
                    $('#boyual').val(govdeboy);
                    $('#tabloen0').text(govdeen);
                    $('#tabloboy0').text(govdeboy);
                    $('#tabloen1').text(govdeen);
                    $('#tabloboy1').text(govdeboy);
                    $('#tabloen2').text(govdeen);
                    $('#tabloboy2').text(govdeboy);                                        
                    }
                });
            });                   
        </script>  
    </head>
    <body>

