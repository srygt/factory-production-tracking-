<?php
/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr 
*/
$siteURL        = "https://test.com/";
$anadizin       = $_SERVER['DOCUMENT_ROOT']."/upload/";
define("SITE_URL", "$siteURL");
define("SITE_TEMPLATE_YONETIM", "$siteURL/themes");
//Anadizin
define("SITE_YONETIM_DIZIN", "$anadizin");
//404
define("SITE_URL404", "$siteURL/index/hata");
//Uyarı Hatası
define("UYARI_MESAJI", '<div class="alert alert-danger" role="alert"><strong>ÜZGÜNÜM!</strong> Bu alanda kayıtlı bilgi bulunmamaktadır.</div>');
define("BUYUK_HARF", "$(document).ready(function() {
            String.prototype.buyukHarf = function () {
                var str = [];
                for (var i = 0; i < this.length; i++) {
                    var ch = this.charCodeAt(i);
                    var c = this.charAt(i);
                    if (ch == 105) str.push('İ');
                    else if (ch == 305) str.push('I');
                    else if (ch == 287) str.push('Ğ');
                    else if (ch == 252) str.push('Ü');
                    else if (ch == 351) str.push('Ş');
                    else if (ch == 246) str.push('Ö');
                    else if (ch == 231) str.push('Ç');
                    else if (ch == 202) str.push('Ê');
                    else if (ch == 206) str.push('Î');
                    else if (ch == 219) str.push('Û');                    
                    else if (ch >= 97 && ch <= 122) str.push(c.toUpperCase());
                    else str.push(c);
                }
                return str.join('');
            }

          });   
          //Sadece Rakam KontrolÃ¼ SaÄŸlar
          $('.onlyNumber').keypress(function (e) {
             // EÄŸer girilen deÄŸer rakam deÄŸilse hiÃ§bir yazmasÄ±n
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                       return false;
            }
           });                 
");

define("FORM_VALIDATION", "$(document).ready(function() { $('form').parsley(); });");
//Çıkış Yap
define("SITE_URL_LOGOUT", "$siteURL/yonetici/cikis");
?>
