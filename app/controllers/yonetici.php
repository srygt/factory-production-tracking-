<?php
/*
* MATGIS YMM
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class yonetici extends controller{
    public function __construct() {
    parent::__construct();
    }
    
    public function index(){
        $this->giris();
    }
    
    public function giris(){
        // Oturum Kontrolü
        session::init();
        if(session::get("giris") == true){
        header("Location:". SITE_URL ."/yonetici/kontrol");        
        }else{
        $this->load->view("yonetici/girisalani");  
        }
    }
    
    public function giriskontrolu(){
        $form               = $this->load->siniflar('form');
        $form               ->post("kullaniciAdi", true);
        $form               ->post("kullaniciSifre", true);
        $kullaniciAdi       = $form->values['kullaniciAdi'];
        $kullaniciSifre     = $form->values['kullaniciSifre'];     
        $salt               = 'W=0d!G__?//34Yt';  
        $data               = array(
            ":GSMNO"=> $kullaniciAdi,
            ":SIFRE"=> hash('sha256', $kullaniciSifre.$salt)
        );
        // Veri tabanı işlemleri
        $yonetici_model     = $this->load->model("yonetici_model");
        $result             = $yonetici_model->yoneticikontrolu($data);
        if($result == false){
        // Yanlış bilgiler girildi.
        header("Location:". SITE_URL ."/yonetici/giris");
        }else{
          if($result[0]["DURUMU"]=="1"){
            session::init();
            session::set("giris", true);
            session::set("AdminID",              $result[0]["ADID"]);
            session::set("SUBEID",               $result[0]["SUBEID"]);
            session::set("adminName",            $result[0]["ADI"]." ".$result[0]['SOYADI']);
            session::set("adminUName",           $result[0]["GSMNO"]);
            session::set("adminPass",            $result[0]["SIFRE"]);
            session::set("adminStatus",          $result[0]["DURUMU"]);
            session::set("adminView",            $result[0]["GOR"]);     
            session::set("adminAdd",             $result[0]["EKLE"]);
            session::set("adminEdit",            $result[0]["DUZENLE"]);
            session::set("adminDelete",          $result[0]["SIL"]);
            session::set("adminReport",          $result[0]["ONAYLA"]);     
            session::set("adminAtama",           $result[0]["ATAMA"]);     
            session::set("adminRol",             $result[0]["TURU"]);     
            // Yönetici Girişi İle İlgili Log Kayıtları Tutulmaktadır.
            header("Location:". SITE_URL ."/index");
            try {
            $yoneticilogu                        = array(
                'ADMINID'                        => $result[0]["ADID"],
                'ADISOYADI'                      => $result[0]["ADI"]." ".$result[0]['SOYADI'],
                'KULLANICIADI'                   => $result[0]["GSMNO"],
                'ISLEMTURU'                      => $result[0]["ADI"]." ".$result[0]['SOYADI']." Adlı Kullanıcı Giriş Yaptı",
                'IPNO'                           => $_SERVER['REMOTE_ADDR']
            );
            } catch (PDOException $e) {
            echo "Yönetici Giriş Log Kaydı Yapılırken Hata Oluştu...";
            }  
            $result = $yonetici_model->yoneticilogu($yoneticilogu);
          }else{
            echo "Sisteme Giriş Yetkiniz Bulunmamaktadır. Lütfen yöneticinize danışın.";
        }            
      }  
    }
    
    public function cikis(){
        try {
          $yoneticilogu                        = array(
            'ADMINID'                        => $result[0]["ADID"],
            'ADISOYADI'                      => $result[0]["ADI"]." ".$result[0]['SOYADI'],
            'KULLANICIADI'                   => $result[0]["GSMNO"],
            'ISLEMTURU'                      => $result[0]["ADI"]." ".$result[0]['SOYADI']." Adlı Kullanıcı Giriş Yaptı",
            'IPNO'                           => $_SERVER['REMOTE_ADDR']
        );
        $yonetici_model     = $this->load->model("yonetici_model");
        $result             = $yonetici_model->yoneticicikislogu($yoneticilogu); 
        } catch (PDOException $e) {
        print "Yönetici Çıkış Log Kaydı Yapılırken Hata Oluştu...";
        }
        session::init();
        session::destroy();
        header("Location:". SITE_URL ."/yonetici/giris");              
    }

    public function kontrol(){
        if(session::get("emailAdresi")==session::get("kullaniciAdi")){
          echo "Giriş Başarılı. Lütfen Bekleyiniz.";
        header("Location:". SITE_URL ."/");          
        }else{
          echo "Giriş Başarısız. Lütfen Bilgilerinizi Kontrol Ederek Tekrar Deneyiniz.";
          session::destroy();          
          header('Refresh: 2; url= '.SITE_URL.'/yonetici/giris');
        }    
    }


    public function forgetpassword(){
        $this->load->view("yonetici/forgetpassword");        
    }


    // Talep Gönderme
    public function resetpassword(){
        $model              = $this->load->model("yonetici_model");
        $form               = $this->load->siniflar('form');
        $form               ->post("kullaniciAdi", true);
        $form               ->post("kullaniciSifre", true);
        $kullaniciAdi     = $form->values['kullaniciAdi'];
        $kullaniciSifre     = "123456--";
        $salt               = 'W=0d!G__?//34Yt';  
        $yeniSifre          = hash('sha256', $kullaniciSifre.$salt);
        $uyeget             = $model->kullanicigetir($kullaniciAdi);
        $kulid              = $uyeget[0][ITKID];
        try{
          $data   = array(
            'ITKID'           => $uyeget[0][ITKID],
            'itk_Email'       => $form->values['kullaniciAdi'],
            'itk_Sifre'       => $yeniSifre
            );
          } catch (PDOException $e) {
             die('Baglanti Kurulamadi : ' . $e->getMessage());
          }
          $result     = $model->yoneticisifredegis($data,$kulid);
        // Mail Gönderme İşlemi Yap
        $to       = "$kullaniciAdi";
        $subject  = "Ofis ERP Yeni Sifre Talebi";

        $message    = '<html xmlns="http://www.w3.org/1999/xhtml" style="font-family:Helvetica Neue, Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <head>
                        <meta name="viewport" content="width=device-width" />
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Teklif / Talep Formu</title>
                        <style type="text/css">
                        img {
                        max-width: 100%;
                        }
                        body {
                        -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
                        }
                        body {
                        background-color: #f6f6f6;
                        }
                        @media only screen and (max-width: 640px) {
                          body {
                            padding: 0 !important;
                          }
                          h1 {
                            font-weight: 800 !important; margin: 20px 0 5px !important;
                          }
                          h2 {
                            font-weight: 800 !important; margin: 20px 0 5px !important;
                          }
                          h3 {
                            font-weight: 800 !important; margin: 20px 0 5px !important;
                          }
                          h4 {
                            font-weight: 800 !important; margin: 20px 0 5px !important;
                          }
                          h1 {
                            font-size: 22px !important;
                          }
                          h2 {
                            font-size: 18px !important;
                          }
                          h3 {
                            font-size: 16px !important;
                          }
                          .container {
                            padding: 0 !important; width: 100% !important;
                          }
                          .content {
                            padding: 0 !important;
                          }
                          .content-wrap {
                            padding: 10px !important;
                          }
                          .invoice {
                            width: 100% !important;
                          }
                        }
                        </style>
                        </head>

                        <body itemscope itemtype="http://schema.org/EmailMessage" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

                        <table class="body-wrap" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                            <td class="container" width="600" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                              <div class="content" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                                <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert alert-warning" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 20px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" bgcolor="#fff" valign="top">
                                      <img src="http://www.matgis.com.tr/themes/site/images/logo.png" style="height: 75px;">
                                    </td>
                                  </tr>
                                  <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                  <td class="content-wrap" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 18px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                          Ofis ERP yazılımı için kullanılmakta olan '.$kullaniciAdi.' email hesabına ait yeni şifre talebi oluşturularak yeni şifreniz üretilmiştir. Şifreniz aşağıda belirtilmiştir.
                                          </td></tr>
                                        <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top"><strong>Yeni Şifre</strong> : 
                                          '.$kullaniciSifre.'
                                          </td>
                                        </tr>
                                       <tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">Sisteme giriş yapmak için <a href="http://www.ofiserp.com">TIKLAYIN</a>
                                          </td>
                                        </tr>
                                        </table></td></tr>
                                  </table>
                                  <div class="footer" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                                  <table width="100%" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">Bu sistem <a href="http://www.matgis.com.tr" target="_blank" title="Matgis Bilişim Teknolojileri">MATGIS</a> tarafından geliştirilmiştir.</td>
                                    </tr></table></div></div>
                            </td>
                            <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                          </tr></table></body>
                        </html>';
                        $header   = "From: Ofiserp.com < $kullaniciAdi > \r\n";
                        $header   .= "MIME-Version: 1.0\r\n";
                        $header   .= "Content-type: text/html\r\n";
                        $headers  .= "X-Priority: 3\r\n";
                        $headers  .= "X-Mailer: PHP". phpversion() ."\r\n";
                        $retval   = mail ($to,$subject,$message,$header);
                        if($retval){
                        echo "Yeni Şifreniz $kullaniciAdi adresinize gönderilmiştir. Lütfen email adresinizi kontrol ederek tekrar giriş yapınız.";
                        }else{
                        echo "ÜZGÜNÜM!... Yeni Şifre Talebiniz İletilmedi. Bilgilerinizi kontrol ederek tekrar deneyiniz";
                        }
  }

}