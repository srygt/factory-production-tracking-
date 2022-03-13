<?php
/*
* MATGIS TETS
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class musteri extends controller {

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
        //$this->anasayfa();
    }
// Müşteri Alanı
        // Müşteri
        public function musteriler(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $musteri_model                    = $this->load->model("musteri_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("musteri/musteriler", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
          }
          // Müşteri Ekle
          public function musteriekle(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("musteri/musteriekle", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
          }        
          // Müşteri kaydetme alan metodları
          public function musterikaydet(){
              $model          = $this->load->model("musteri_model");
              $ymodel         = $this->load->model("yonetici_model");
              $form           = $this->load->siniflar('form');
              $form           ->post('musteriAdi', true)
                              ->isempty();
              $form           ->post('musteriTel', true)
                              ->isempty();
              $form           ->post('musteriAdres', true)
                              ->isempty();
              $form           ->post('musteriSoyadi', true);
              if(!empty($form->values['musteriAdi'])){
                  if(!empty($form->values['musteriTel'])){
                      if(!empty($form->values['musteriAdres'])){
                              try{
                                  $data   = array(
                                  'adi'             => $form->guvenlik($form->values['musteriAdi']),
                                  'soyadi'          => $form->guvenlik($form->values['musteriSoyadi']),
                                  'adres'           => $form->guvenlik($form->values['musteriAdres']),
                                  'telefon'         => $form->guvenlik($form->values['musteriTel'])
                                  );
                              } catch (PDOException $e) {
                              die('Baglanti Kurulamadi : ' . $e->getMessage());
                              }
                              $result = $model->musterikaydet($data);
                              if($result){ // İşlem Durumunu Kontrol Et              
                              echo '<div class="alert bg-green aling-left">Kayıt İşleminiz Başarıyla Gerçekleşti.</div>';
                          }else{echo '<div class="alert bg-red aling-left">HATA! Kayıt İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';}
                  }else{echo '<div class="alert bg-red aling-left">HATA! Adres Zorunludur.</div>';}
              }else{echo '<div class="alert bg-red aling-left">HATA! Telefon Zorunludur.</div>';}
            }else{echo '<div class="alert bg-red aling-left">HATA! Adı Zorunludur.</div>';}
          }
  
          // Müşteri Silme Alan Metodu
          public function musterisil(){
              $form       = $this->load->siniflar('form');
              $model      = $this->load->model("musteri_model");
              $ymodel     = $this->load->model("yonetici_model");
              $form       ->post('id', true)
                          ->isempty();
              $KAYITID    = $form->guvenlik($form->values['id']);
              $result     = $model->musterisil($KAYITID);
              if($result){ // İşlem Durumunu Kontrol Et             
                echo '<div class="alert bg-green aling-left">Silme İşleminiz Başarıyla Gerçekleşti.</div>';
              }else{
                echo '<div class="alert bg-red aling-left">HATA! Silme İşleminiz Gerçekleşmedi. Lütfen tekrar deneyiniz.</div>';
              }
          }
        // Müşteri Listesi Modeli
        public function musterilistesi(){
            $form                   = $this->load->siniflar('form');
            $model                  = $this->load->model("musteri_model");
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
                        1   => 'adi',
                        1   => 'sadi',
                        2   => 'adres',
                        3   => 'tel'
                ); // Kolonlar

            $limit              = $form->values['length'];
            $start              = $form->values['start'];
            $order              = $kolonlar[$form->values['order']['0']['column']];
            $dir                = $form->values['order']['0']['dir'];
            $totalData          = $model->musterisayisi();
            $totalFiltered      = $totalData; 
            if(empty($form->values["search"]["value"]))
            {            
            $kayitlar           = $model->musterilistesi($limit,$start,$order,$dir);
            }else {
            $search             = $form->values['search']['value']; 
            $kayitlar           = $model->musteri_arama($limit,$start,$search);
            $totalFiltered      = $model->musteri_arama_sayisi($search);
            }
            $data = array();
            if(!empty($kayitlar))
            {   $sn = 0;
                foreach ($kayitlar as $post)
                {
                    $sn++;
                    $matgisData['islem']            = '
                    <a href="javascript:void(0);" onclick="musteriSil('.$post['mid'].')" title="İşlemi Sil" class="btn btn-danger"><i class="mdi mdi-delete"></i> Sil</a>';
                    $matgisData['adi']              = $post['adi'];
                    $matgisData['sadi']             = $post['soyadi'];
                    $matgisData['adres']            = $post['adres'];
                    $matgisData['tel']              = $post['telefon'];
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
}