<?php
/*
* MATGIS TETS
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class tanim extends controller {

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

// Tanımlar Alanı    
      // Tanımlar
      public function tanimlar(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $tanim_model                      = $this->load->model("tanim_model");            
            $yoneticilogu["menulistesi"]              = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]               = $index_model->menuyetkim($ID);
            $yoneticilogu["mukellefturu"]             = $tanim_model->mukellefturu();
            $yoneticilogu["subeler"]                  = $tanim_model->subeler();
            $yoneticilogu["personelturu"]             = $tanim_model->personelturu();
            $yoneticilogu["belgetipi"]                = $tanim_model->belgetipi();
            $yoneticilogu["kdviadeturu"]              = $tanim_model->kdviadeturu();
            $yoneticilogu["tahsilatturu"]             = $tanim_model->tahsilatturu();
            $yoneticilogu["vergidairesidurumu"]       = $tanim_model->vergidairesidurumu();
            $yoneticilogu["vergidonemleri"]           = $tanim_model->vergidonemleri();
            $yoneticilogu["sozlesmeturleri"]          = $tanim_model->sozlesmeturleri();
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("tanim/tanimlar", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }

// Depo Tanımlamaları
        // Depo
        public function depolar(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["depolar"]          = $tanim_model->depolar();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/depolar", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // Depo
        public function depoekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/depoekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // Depo kaydetme alan metodları
        public function depokaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('depoKodu', true)
                            ->isempty();
            $form           ->post('depoAdi', true)
                            ->isempty();
            $form           ->post('depoAciklama', true);
            if(!empty($form->values['depoKodu'])){
              if(!empty($form->values['depoAdi'])){
                try{
                    $data   = array(
                      'depokodu'         => $form->guvenlik($form->values['depoKodu']),
                      'depoadi'          => $form->guvenlik($form->values['depoAdi']),
                      'aciklama'         => $form->guvenlik($form->values['depoAciklama'])
                    );
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->depokaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "Depo Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">Depo Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! Depo Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! Depo Adı Zorunludur.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Depo Kodu Zorunludur.</div>';}
        }

        // Depo Silme Alan Metodu
        public function deposil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->deposil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "Depo Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">Depo Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! Depo Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }
// Kategoriler Tanımlamaları
        // Kategoriler
        public function kategoriler(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["kategoriler"]     = $tanim_model->kategoriler();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/kategoriler", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // Kategoriler
        public function kategoriekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/kategoriekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // Kategoriler kaydetme alan metodları
        public function kategorikaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('kategoriAdi', true)
                            ->isempty();
            if(!empty($form->values['kategoriAdi'])){
                try{
                    $data   = array(
                      'katadi'         => $form->guvenlik($form->values['kategoriAdi'])
                    );
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->kategorikaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "Kategoriler Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">Kategoriler Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! Kategoriler Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! kategori Adı Zorunludur.</div>';}
        }

        // Kategoriler Silme Alan Metodu
        public function kategorisil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->kategorisil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "Kategoriler Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">Kategoriler Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! Kategoriler Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }      


// Raf Tanımlamaları
        // Raf
        public function raflar(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["raflar"]           = $tanim_model->raflar();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/raflar", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // Raf
        public function rafekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["depolar"]          = $tanim_model->depolar();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/rafekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // Raf kaydetme alan metodları
        public function rafkaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('rafKodu', true)
                            ->isempty();
            $form           ->post('depoid', true)
                            ->isempty();
            $form           ->post('rafAdi', true)
                            ->isempty();
            if(!empty($form->values['rafKodu'])){
              if(!empty($form->values['rafAdi'])){
                try{
                    $data   = array(
                      'depoid'           => $form->guvenlik($form->values['depoid']),
                      'rafkodu'          => $form->guvenlik($form->values['rafKodu']),
                      'rafadi'           => $form->guvenlik($form->values['rafAdi'])
                    );
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->rafkaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "Raf Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">Raf Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! Raf Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! Raf Adı Zorunludur.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Raf Kodu Zorunludur.</div>';}
        }

        // Raf Silme Alan Metodu
        public function rafsil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->rafsil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "Raf Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">Raf Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! Raf Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }

// İstasyon Tanımlamaları
        // İstasyon
        public function istasyonlar(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["istasyonlar"]      = $tanim_model->istasyonlar();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/istasyonlar", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // İstasyon
        public function istasyonekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/istasyonekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // İstasyon kaydetme alan metodları
        public function istasyonkaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('istasyonKodu', true)
                            ->isempty();
            $form           ->post('istasyonAdi', true)
                            ->isempty();
            $form           ->post('istasyonAciklama', true);
            if(!empty($form->values['istasyonKodu'])){
              if(!empty($form->values['istasyonAdi'])){
                try{
                    $data   = array(
                      'istasyonkodu'         => $form->guvenlik($form->values['istasyonKodu']),
                      'istasyonadi'          => $form->guvenlik($form->values['istasyonAdi']),
                      'aciklama'             => $form->guvenlik($form->values['istasyonAciklama'])
                    );
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->istasyonkaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "İstasyon Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">İstasyon Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! İstasyon Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! İstasyon Adı Zorunludur.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! İstasyon Kodu Zorunludur.</div>';}
        }

        // İstasyon Silme Alan Metodu
        public function istasyonsil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->istasyonsil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "İstasyon Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">İstasyon Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! İstasyon Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }

// Onay Kodları Tanımlamaları
        // Onay Kodları
        public function onaykodlari(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["onaykodlari"]      = $tanim_model->onaykodlari();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/onaykodlari", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // Onay Kodları
        public function onaykoduekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/onaykoduekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // Onay Kodları kaydetme alan metodları
        public function onaykodukaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('onayCapi', true)
                            ->isempty();
            $form           ->post('onayKodu', true)
                            ->isempty();
            if(!empty($form->values['onayCapi'])){
              if(!empty($form->values['onayKodu'])){
                try{
                    $data   = array(
                      'capi'         => $form->guvenlik($form->values['onayCapi']),
                      'kod'          => $form->guvenlik($form->values['onayKodu'])
                    );
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->onaykodukaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "Onay Kodları Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">Onay Kodları Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! Onay Kodları Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! Onay Kodları Adı Zorunludur.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Onay Kodları Kodu Zorunludur.</div>';}
        }

        // Onay Kodları Silme Alan Metodu
        public function onaykodusil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->onaykodusil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "Onay Kodları Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">Onay Kodları Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! Onay Kodları Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }  

// Operasyonlar Tanımlamaları
        // Operasyonlar
        public function operasyonlar(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["operasyonlar"]     = $tanim_model->operasyonlar();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/operasyonlar", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // Operasyonlar
        public function operasyonekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/operasyonekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // Operasyonlar kaydetme alan metodları
        public function operasyonkaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('operasyonAdi', true)
                            ->isempty();
            if(!empty($form->values['operasyonAdi'])){
                try{
                    $data   = array(
                      'konuadi'         => $form->guvenlik($form->values['operasyonAdi'])
                    );
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->operasyonkaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "Operasyonlar Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">Operasyonlar Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! Operasyonlar Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Operasyon Adı Zorunludur.</div>';}
        }

        // Operasyonlar Silme Alan Metodu
        public function operasyonsil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->operasyonsil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "Operasyonlar Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">Operasyonlar Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! Operasyonlar Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }      

// İstasyon Resimleri Tanımlamaları
        // İstasyon Resimleri
        public function istasyonresimleri(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["istasyonresimleri"]= $tanim_model->istasyonresimleri();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/istasyonresimleri", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }
        // İstasyon Resimleri
        public function istasyonresmiekle(){
          $form                             = $this->load->siniflar('form');
          $index_model                      = $this->load->model("index_model");
          $tanim_model                      = $this->load->model("tanim_model");
          $ID                               = $form->guvenlik($_REQUEST['ID']);
          $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
          $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
          $yoneticilogu["istasyonlar"]      = $tanim_model->istasyonlar();
          $this->load->view("ustAlan", $yoneticilogu);
          $this->load->view("tanim/istasyonresmiekle", $yoneticilogu);
          $this->load->view("solAlan", $yoneticilogu);
          $this->load->view("altAlan", $yoneticilogu);
        }        
        // İstasyon Resimleri kaydetme alan metodları
        public function istasyonresmikaydet(){
            $model          = $this->load->model("tanim_model");
            $form           = $this->load->siniflar('form');
            $form           ->post('istasyonResmiAdi', true)
                            ->isempty();
            $form           ->post('istasyonID', true)
                            ->isempty();
            if(!empty($_FILES['istasyonResmiAdi']['name'])){
                  $hedefklasor         = SITE_YONETIM_DIZIN; // Hedef klasörümüz
                  $mimetype            = $_FILES['istasyonResmiAdi']['type'];
                  $filesize            = $_FILES['istasyonResmiAdi']['size'];
                  $listtype            = array(
                  '.jpg'               =>'image/jpg',
                  '.jpeg'              =>'image/jpeg',
                  '.png'               =>'image/png',
                  '.doc'               =>'application/msword',
                  '.docx'              =>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                  '.xls'               =>'application/vnd.ms-excel',
                  '.xlsx'              =>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                  '.pdf'               =>'application/pdf'); 
                  if (@is_uploaded_file($_FILES['istasyonResmiAdi']['tmp_name']))
                      {
                  if($key = array_search($_FILES['istasyonResmiAdi']['type'],$listtype))
                      {
                  $contentImagess       =  $_FILES["istasyonResmiAdi"]["name"];            
                  $contentImagesName    = $hedefklasor."istasyon/".$contentImagess;
                  @move_uploaded_file($_FILES["istasyonResmiAdi"]["tmp_name"], $contentImagesName);
                  switch($mimetype) {
                      case "image/jpg":
                      $resim           = imagecreatefromjpeg($contentImagesName);
                      break;         
                      case "image/jpeg":
                      $resim           = imagecreatefromjpeg($contentImagesName);
                      break;
                      case "image/gif":
                      $resim           = imagecreatefromgif($contentImagesName);
                      break;
                      case "image/png":
                      $resim           = imagecreatefrompng($contentImagesName);
                      break;
                  }
                  }
                  $boyutlar            = getimagesize($contentImagesName); // Resmimizin boyutlarını öğreniyoruz
                  $resimorani          = 200 / $boyutlar[0];           // Resmi küçültme/büyütme oranımızı hesaplıyoruz..
                  $yeniyukseklik       = $resimorani*$boyutlar[1];  // Bulduğumuz orandan yeni yüksekliğimizi hesaplıyoruz..
                  $yeniresim           = imagecreatetruecolor("200", $yeniyukseklik); // Oluşturulan boş resmi istediğimiz boyutlara getiriyoruz..
                  imagealphablending($yeniresim, false); // Logo Png olarak eklendiği zaman arka planı transparan yapmaktadır
                  imagesavealpha($yeniresim,true);
                  $transparency        = imagecolorallocatealpha($yeniresim, 255, 255, 255, 127);
                  imagefilledrectangle($yeniresim, 0, 0, $yeniyukseklik, $yeniyukseklik, $transparency);
                  imagecopyresampled($yeniresim, $resim, 0, 0, 0, 0, "200", $yeniyukseklik, $boyutlar[0], $boyutlar[1]);
                  switch($mimetype) {
                      case "image/jpg":
                      $resim           = imagejpeg($yeniresim, $contentImagesName, 100);
                      break;
                      case "image/jpeg":
                      $resim           = imagejpeg($yeniresim, $contentImagesName, 100);
                      break;
                      case "image/gif":
                      $resim           = imagegif($_FILES["istasyonResmiAdi"]["tmp_name"][$a]);
                      break;
                      case "image/png":
                      $resim           = imagepng($yeniresim, $contentImagesName, 0);
                      break;
                  }                                                   
                  }else{
                      echo "Dosya Türü Geçersiz";
                  }             
                try{
                    $data   = array(
                        'istasyonid'         => $form->guvenlik($form->values['istasyonID']),
                        'reskodu'            => $contentImagess
                    );
                    print_r($data);
                } catch (PDOException $e) {
                  die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
              $result = $model->istasyonresmikaydet($data);
              if($result){ // İşlem Durumunu Kontrol Et
                // Notification İşlemi Başlangıç
                try{
                $yoneticilogu   = array(
                    'ADISOYADI'     => session::get("adminName"),
                    'KULLANICIADI'  => session::get("adminUName"),
                    'ISLEMTURU'     => "İstasyon Resimleri Eklendi",                
                    'ADMINID'       => session::get("AdminID"),
                    'IPNO'          => $_SERVER['REMOTE_ADDR']
                  );
                } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $sn = $model->yoneticilogu($yoneticilogu);
                // Notification İşlemi Bitiş                
                echo '<div class="alert bg-green aling-left">İstasyon Resimleri Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{echo '<div class="alert bg-red aling-left">HATA! İstasyon Resimleri Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
          }else{echo '<div class="alert bg-red aling-left">HATA! Resim Zorunludur.</div>';}
        }

        // İstasyon Resimleri Silme Alan Metodu
        public function istasyonresmisil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("tanim_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($form->values['id']);
            $result     = $model->istasyonresmisil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "İstasyon Resimleri Silindi",                
                  'ADMINID'       => session::get("AdminID"),
                  'IPNO'          => $_SERVER['REMOTE_ADDR']
                );
              } catch (PDOException $e) {
              die('Baglanti Kurulamadi : ' . $e->getMessage());
              }
              $sn = $model->yoneticilogu($yoneticilogu);
              // Notification İşlemi Bitiş                
              echo '<div class="alert bg-green aling-left">İstasyon Resimleri Silme İşleminiz Başarıyla Gerçekleşti.</div>';
            }else{
              echo '<div class="alert bg-red aling-left">HATA! İstasyon Resimleri Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
            }
        }                  
}
