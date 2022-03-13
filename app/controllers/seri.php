<?php
/*
* MATGIS TETS
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class seri extends controller {

   function __construct() {
      parent::__construct();
      function private_str($str, $start, $end){
        $after  = mb_substr($str, 0, $start, 'UTF-8');
        $repeat = str_repeat('*', $end);
        $before = mb_substr($str, ($start + $end), strlen($str), 'UTF-8');
        return $after.$repeat.$before;
      }
    }

    function index() {
        $this->anasayfa();
    }
// Seri No Üretme Alanı
        // Seri No Üretme
        public function seriler(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $seri_model                       = $this->load->model("seri_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("seri/seriler", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
          }
          // Seri No Üretme Ekle
          public function seriekle(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $tanim_model                      = $this->load->model("tanim_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["tankturu"]         = $tanim_model->tankturu();
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("seri/seriekle", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
          }        
          // Seri kaydetme alan metodları
          public function serikaydet(){
              $model          = $this->load->model("seri_model");
              $ymodel         = $this->load->model("yonetici_model");
              $form           = $this->load->siniflar('form');
              $form           ->post('seriYili', true)
                              ->isempty();
              $form           ->post('seriTipOnay', true)
                              ->isempty();
              $form           ->post('seriLitre', true)
                              ->isempty();
              $form           ->post('seriTankTuru', true)
                              ->isempty();
              if(!empty($form->values['seriYili'])){
                  if(!empty($form->values['seriTipOnay'])){
                      if(!empty($form->values['seriLitre'])){
                          if(!empty($form->values['seriTankTuru'])){
                              try{
                                  $data   = array(
                                  'yili'             => $form->guvenlik($form->values['seriYili']),
                                  'tiponay'          => $form->guvenlik($form->values['seriTipOnay']),
                                  'litretanimi'      => $form->guvenlik($form->values['seriLitre']),
                                  'tankturu'         => $form->guvenlik($form->values['seriTankTuru'])
                                  );
                              } catch (PDOException $e) {
                              die('Baglanti Kurulamadi : ' . $e->getMessage());
                              }
                              $result = $model->serikaydet($data);
                              if($result){ // İşlem Durumunu Kontrol Et
                              // Notification İşlemi Başlangıç
                              try{
                              $yoneticilogu   = array(
                                  'ADISOYADI'     => session::get("adminName"),
                                  'KULLANICIADI'  => session::get("adminUName"),
                                  'ISLEMTURU'     => "Seri Eklendi",                
                                  'ADMINID'       => session::get("AdminID"),
                                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                              );
                              } catch (PDOException $e) {
                              die('Baglanti Kurulamadi : ' . $e->getMessage());
                              }
                              $sn = $ymodel->yoneticilogu($yoneticilogu);
                              // Notification İşlemi Bitiş                
                              echo '<div class="alert bg-green aling-left">Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
                          }else{echo '<div class="alert bg-red aling-left">HATA! Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
                      }else{echo '<div class="alert bg-red aling-left">HATA! Tank Türü Zorunludur.</div>';}
                  }else{echo '<div class="alert bg-red aling-left">HATA! Litre Tanımı Zorunludur.</div>';}
              }else{echo '<div class="alert bg-red aling-left">HATA! Tip Onay Zorunludur.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! Seri Yılı Zorunludur.</div>';}
          }
  
          // Seri Silme Alan Metodu
          public function serisil(){
              $form       = $this->load->siniflar('form');
              $model      = $this->load->model("seri_model");
              $ymodel     = $this->load->model("yonetici_model");
              $form       ->post('id', true)
                          ->isempty();
              $KAYITID    = $form->guvenlik($form->values['id']);
              $result     = $model->serisil($KAYITID);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "Seri Numarası Silindi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $ymodel->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">Silme İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{
                echo '<div class="alert bg-red aling-left">HATA! Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
              }
          }
        // Seri Listesi Modeli
        public function serilistesi(){
            $form                   = $this->load->siniflar('form');
            $model                  = $this->load->model("seri_model");
            $form                   ->post('length', true);
            $form                   ->post('start', true);
            $form                   ->post('order', true);
            $form                   ->post('search', true);
            $form                   ->post('column', true);
            $form                   ->post('value', true);
            $form                   ->post('draw', true);
            $form                   ->post('dir', true);
            $kolonlar = array( 
                        0   => 'islem', 
                        1   => 'barno',
                        1   => 'sn',
                        2   => 'yili',
                        3   => 'tip',
                        4   => 'litre',
                        5   => 'tank',
                        6   => 'cap',
                        6   => 'yukseklik',
                        8   => 'litresi',
                        9   => 'tipi',
                        10   => 'kg',
                        11   => 'govde',
                        12   => 'kapak'
                ); // Kolonlar

            $limit              = $form->values['length'];
            $start              = $form->values['start'];
            $order              = $kolonlar[$form->values['order']['0']['column']];
            $dir                = $form->values['order']['0']['dir'];
            $totalData          = $model->serisayisi();
            $totalFiltered      = $totalData; 
            if(empty($form->values["search"]["value"]))
            {            
            $kayitlar           = $model->serilistesi($limit,$start,$order,$dir);
            }else {
            $search             = $form->values['search']['value']; 
            $kayitlar           = $model->seri_arama($limit,$start,$search);
            $totalFiltered      = $model->seri_arama_sayisi($search);
            }
            $data = array();
            if(!empty($kayitlar))
            {   $sn = 0;
                foreach ($kayitlar as $post)
                {
                    $sn++;
                    $matgisData['islem']            = '
                    <a href="javascript:void(0);" onclick="seriSil('.$post['tsnid'].')" title="İşlemi Sil" class="btn btn-danger"><i class="mdi mdi-delete"></i> Sil</a>';
                    $matgisData['barno']            = $post['barkodno'];
                    $matgisData['sn']               = '<a class="dropdown-item" href="javascript:void(0);" onclick="seribilgiekle('.$post['tsnid'].')" data-toggle="modal" data-target=".seribilgiekle"><label class="bg-primary text-white">'.$post['yili']."".$post['tiponay']."".$post['litretanimi'].'</label></a>';
                    $matgisData['yili']             = $post['yili'];
                    $matgisData['tip']              = $post['tiponay'];
                    $matgisData['litre']            = $post['litretanimi'];
                    $matgisData['tank']             = $post['turadi'];
                    $matgisData['cap']              = '<a class="dropdown-item" href="javascript:void(0);" onclick="seribilgiguncelle('.$post['tsnid'].')" data-toggle="modal" data-target=".seribilgiguncelle">'.$post['cap'].'</a>';
                    $matgisData['yukseklik']        = $post['yukseklik'];
                    $matgisData['litresi']          = $post['litre'];
                    $matgisData['tipi']             = $post['tip'];
                    $matgisData['kg']               = $post['kg'];
                    $matgisData['govde']            = $post['g1'].'x'.$post['g2'];
                    $matgisData['kapak']            = $post['k1'].'x'.$post['k2'];
                    $data[] = $matgisData;
                }
            }
            
            $json_data = array(
                        "draw"            => intval($form->values["draw"]),  
                        "recordsTotal"    => intval($totalData),  
                        "recordsFiltered" => intval($totalFiltered), 
                        "data"            => $data   
                        );            
            echo json_encode($json_data); 
        }
          // Seri Bilgi kaydetme alan metodları
          public function seribilgikaydet(){
            $model          = $this->load->model("seri_model");
            $ymodel         = $this->load->model("yonetici_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('seriCap', true)
                            ->isempty();
            $form           ->post('seriBarkod', true)
                            ->isempty();
            $form           ->post('seriLitre', true)
                            ->isempty();
            $form           ->post('seriKg', true)
                            ->isempty();
            $form           ->post('seriid', true)
                            ->isempty();                            
            $form           ->post('yili', true)
                            ->isempty();             
            $form           ->post('tipi', true)
                            ->isempty();             
            $form           ->post('litresi', true)
                            ->isempty();
            $form           ->post('seriGovdeEni', true)
                            ->isempty();
            $form           ->post('seriGovdeBoyu', true)
                            ->isempty();
            $form           ->post('seriKapakEni', true)
                            ->isempty();
            $form           ->post('seriKapakBoyu', true)
                            ->isempty();
            $form           ->post('seriYukseklik', true);
            $serinom        = $form->values['yili'].$form->values['tipi'].$form->values['litresi'];             
            $sertip         = $form->values['tipi'].$form->values['litresi'];             
            if(!empty($form->values['seriCap'])){
                if(!empty($sertip)){
                    if(!empty($form->values['seriLitre'])){
                        if(!empty($form->values['seriid'])){
                            try{
                                $data   = array(
                                'serinoid'          => $form->guvenlik($form->values['seriid']),
                                'serino'            => $serinom,
                                'cap'               => $form->guvenlik($form->values['seriCap']),
                                'yukseklik'         => $form->guvenlik($form->values['seriYukseklik']),
                                'barkodno'          => $form->guvenlik($form->values['seriBarkod']),
                                'tip'               => $sertip,
                                'litre'             => $form->guvenlik($form->values['seriLitre']),
                                'kg'                => $form->guvenlik($form->values['seriKg']),
                                'g1'                => $form->guvenlik($form->values['seriGovdeEni']),
                                'g2'                => $form->guvenlik($form->values['seriGovdeBoyu']),
                                'k1'                => $form->guvenlik($form->values['seriKapakEni']),
                                'k2'                => $form->guvenlik($form->values['seriKapakBoyu'])
                                );
                            } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $result = $model->seribilgikaydet($data);
                            if($result){ // İşlem Durumunu Kontrol Et
                            // Notification İşlemi Başlangıç
                            try{
                            $yoneticilogu   = array(
                                'ADISOYADI'     => session::get("adminName"),
                                'KULLANICIADI'  => session::get("adminUName"),
                                'ISLEMTURU'     => "Seri Bilgi Eklendi",                
                                'ADMINID'       => session::get("AdminID"),
                                'IPNO'          => $_SERVER['REMOTE_ADDR']
                            );
                            } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $sn = $ymodel->yoneticilogu($yoneticilogu);
                            // Notification İşlemi Bitiş                
                            echo '<div class="alert bg-green aling-left">Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
                        }else{echo '<div class="alert bg-red aling-left">HATA! Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
                    }else{echo '<div class="alert bg-red aling-left">HATA! Seri ID Zorunludur.</div>';}
                }else{echo '<div class="alert bg-red aling-left">HATA! Litre Zorunludur.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! Tip Zorunludur.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Çap Zorunludur.</div>';}
        }
          // Tank Üretimi Başlatma alan metodları
          public function uretimibaslat(){
            $model          = $this->load->model("seri_model");
            $ymodel         = $this->load->model("yonetici_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('id', true)
                            ->isempty();
            $KAYITID        = $form->guvenlik($form->values['id']);            
            if(!empty($KAYITID)){
                try{
                    $data   = array(
                        'seritanimid'      => $form->guvenlik($form->values['id'])
                    );
                } catch (PDOException $e) {
                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $result = $model->uretimibaslat($data);
                if($result){ // İşlem Durumunu Kontrol Et
                    // Notification İşlemi Başlangıç
                    try{
                        $yoneticilogu   = array(
                            'ADISOYADI'     => session::get("adminName"),
                            'KULLANICIADI'  => session::get("adminUName"),
                            'ISLEMTURU'     => "Tank Üretimi Başlatıldı",                
                            'ADMINID'       => session::get("AdminID"),
                            'IPNO'          => $_SERVER['REMOTE_ADDR']
                        );
                    } catch (PDOException $e) {
                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                    }
                    $sn = $ymodel->yoneticilogu($yoneticilogu);
                    // Notification İşlemi Bitiş                
                    echo '<div class="alert bg-green aling-left">Tank Üretimi Başlatıldı.</div>';
                }else{echo '<div class="alert bg-red aling-left">HATA! Tank Üretimi Başlatılamadı. Lütfen tekrar deneyiniz.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Üretim Başlatılamadı.</div>';}
        }      
          // Tank Üretimi Başlatma alan metodları
          public function uretimekapat(){
            $model          = $this->load->model("seri_model");
            $ymodel         = $this->load->model("yonetici_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('id', true)
                            ->isempty();
            $KAYITID        = $form->guvenlik($form->values['id']);            
            if(!empty($KAYITID)){
                try{
                    $data   = array(
                        'uretimdurumu'      => 0
                    );
                } catch (PDOException $e) {
                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $result = $model->uretimekapat($data,$KAYITID);
                if($result){ // İşlem Durumunu Kontrol Et
                    // Notification İşlemi Başlangıç
                    try{
                        $yoneticilogu   = array(
                            'ADISOYADI'     => session::get("adminName"),
                            'KULLANICIADI'  => session::get("adminUName"),
                            'ISLEMTURU'     => $KAYITID." Nolu seri üretime kapatıldı.",                
                            'ADMINID'       => session::get("AdminID"),
                            'IPNO'          => $_SERVER['REMOTE_ADDR']
                        );
                    } catch (PDOException $e) {
                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                    }
                    $sn = $ymodel->yoneticilogu($yoneticilogu);
                    // Notification İşlemi Bitiş                
                    echo '<div class="alert bg-green aling-left">Tank Üretimi Başlatıldı.</div>';
                }else{echo '<div class="alert bg-red aling-left">HATA! Tank Üretimi Başlatılamadı. Lütfen tekrar deneyiniz.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Üretim Başlatılamadı.</div>';}
        }               
    // Seri  Getirme Modeli
    
    public function serigetir(){
        $form                             = $this->load->siniflar('form');
        $seri_model                       = $this->load->model("seri_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $seri_model->serigetir($KAYITID);
        echo json_encode($data);
    }   
    // Seri  Getirme Modeli
    
    public function serinogetir(){
        $form                             = $this->load->siniflar('form');
        $seri_model                       = $this->load->model("seri_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $seri_model->serinogetir($KAYITID);
        echo json_encode($data);
    }         
    // Tank Üretimi İşlemini Geri Al
    public function islemigerial(){
        $model          = $this->load->model("seri_model");
        $form           = $this->load->siniflar('form');
        $KAYITID        = $form->guvenlik($_GET['id']);
        $sacgetir       = $model->sacgetir($KAYITID);
        $sacustid       = @$sacgetir[0][sacustid];
        $istasyonid     = @$sacgetir[0][istasyonid];
        if(!empty($KAYITID)){
            try{
                $data   = array(
                    'onaydurum'      => 0
                );
            } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
            }
            $result = $model->islemigerial($data,$sacustid,$istasyonid);
            if($result){ // İşlem Durumunu Kontrol Et
                echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!...İşlem başarılı.')</script>";
                header('Refresh: 0; url= '.SITE_URL.'/uretim/aktarilamayan/&ID=29'); 
            }else{
                echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...İşlem başarısız.Tekrar deneyiniz.')</script>";
                header('Refresh: 0; url= '.SITE_URL.'/uretim/aktarilamayan/&ID=29'); 
            }
      }else{echo '<div class="alert bg-red aling-left">HATA! İşlem Başarısız.</div>';}
     
    }  
          // Seri kaydetme alan metodları
          public function seribilgiguncelle(){
              $model          = $this->load->model("seri_model");
              $ymodel         = $this->load->model("yonetici_model");
              $form           = $this->load->siniflar('form');
              $form           ->post('seriBarkodg', true);
              $form           ->post('seriCapg', true);
              $form           ->post('seriLitreg', true);
              $form           ->post('seriYukseklikg', true);
              $form           ->post('seriKgg', true);
              $form           ->post('seriGovdeEnig', true);
              $form           ->post('seriGovdeBoyug', true);
              $form           ->post('seriKapakEnig', true);
              $form           ->post('seriKapakBoyug', true);
              $form           ->post('serinoid', true);
              $serinoid       = $form->values['serinoid'];
                try{
                    $data   = array(
                        'cap'         => $form->guvenlik($form->values['seriCapg']),
                        'yukseklik'   => $form->guvenlik($form->values['seriYukseklikg']),
                        'barkodno'    => $form->guvenlik($form->values['seriBarkodg']),
                        'litre'       => $form->guvenlik($form->values['seriLitreg']),
                        'kg'          => $form->guvenlik($form->values['seriKgg']),
                        'g1'          => $form->guvenlik($form->values['seriGovdeEnig']),
                        'g2'          => $form->guvenlik($form->values['seriGovdeBoyug']),
                        'k1'          => $form->guvenlik($form->values['seriKapakEnig']),
                        'k2'          => $form->guvenlik($form->values['seriKapakBoyug'])
                    );
                } catch (PDOException $e) {
                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
            $result = $model->seribilgiguncelle($data,$serinoid);
            if($result){ // İşlem Durumunu Kontrol Et
             echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('İşlem Başarıyla Gerçekleşti.')</script>";
             header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');
            }else{
             echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('İşlem Gerçekleşmedi.')</script>";
             header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                
            }
          }
    
}