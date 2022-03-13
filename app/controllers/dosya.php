<?php
/*
* MATGIS ymm
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class dosya extends controller {
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
//Mükellef Dosya Dosya Alanı
    // Mükellef Dosya Dosyası   
    public function dosyalar(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["tahsilatturu"]               = $tanim_model->tahsilatturu();
        $this->load->view("ustAlan", $data);
        $this->load->view("dosya/dosyalar", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Mükellef Dosya Ekleme    
    public function dosekle(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $dosya_model                        = $this->load->model("dosya_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["mukellefler"]                = $dosya_model->mukellefler();
        $data["vergidonemleri"]             = $tanim_model->vergidonemleri();
        $data["kdviadeturu"]                = $tanim_model->kdviadeturu();
        $data["personeller"]                = $tanim_model->personeller();
        $data["vergidairesidurumu"]         = $tanim_model->vergidairesidurumu();
        $data["menulistesi"]                = $index_model->menulistesi();
        $this->load->view("ustAlan", $data);
        $this->load->view("dosya/dosekle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Mükellef Dosya Düzenleme    
    public function dosduzenle(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $dosya_model                        = $this->load->model("dosya_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["mukellefler"]                = $dosya_model->mukellefler();
        $data["vergidonemleri"]             = $tanim_model->vergidonemleri();
        $data["kdviadeturu"]                = $tanim_model->kdviadeturu();
        $data["personeller"]                = $tanim_model->personeller();
        $data["vergidairesidurumu"]         = $tanim_model->vergidairesidurumu();
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["dosduzenle"]                 = $dosya_model->dosduzenle($CID);
        $this->load->view("ustAlan", $data);
        $this->load->view("dosya/dosduzenle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);
    }

    // Mükellef Dosya Kaydetme Metodu
    public function doskaydet(){
        $model          = $this->load->model("dosya_model");        
        $tmodel         = $this->load->model("takvim_model");        
        $ymodel         = $this->load->model("ymm_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('dosSoz', true)
                        ->isempty();
        $form           ->post('dosDonem', true)
                        ->isempty();
        $form           ->post('dosKdvi', true);
        $form           ->post('dosVergi', true);
        $form           ->post('dosITutar', true);
        $form           ->post('dosTTutar', true);
        $form           ->post('dosDATarihi', true);
        $form           ->post('dosRYTarihi', true);
        $form           ->post('dosTETarihi', true);
        $form           ->post('dosIGTarihi', true);
        $form           ->post('dosNot', true);
        $CID            = $form->values['dosSoz']; // Sözleşme Numarası
        $sozgetir       = $ymodel->sozgetir($CID);  
        if(!empty($sozgetir)){ // Eğer sözleşme eklenmiş ve personele görev atama yapılmışsa dosya eklenir
        $sonkayit       = $model->sondosya();        
        if(!empty($sonkayit)){
            $mno        = "DN".str_pad(@$sonkayit[0][MDID]+1,8,0,STR_PAD_LEFT);
        }else{
            $mno        = "DN".str_pad(1,8,0,STR_PAD_LEFT);
        }
        // Dosya Alım Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosDATarihi'])){
            $datar       = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosDATarihi'])));
        }else{
            $datar       = NULL;
        } // Dosya Alım Tarihi   
        // Rapor Yazma Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosRYTarihi'])){
            $rytar        = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosRYTarihi'])));
        }else{
            $rytar        = NULL;
        } // Rapor Yazma Tarihi
        // Teslim Edildiği Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosTETarihi'])){
            $tetar        = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosTETarihi'])));
        }else{
            $tetar        = NULL;
        } // Teslim Edildiği Tarihi
        // İade Gerçekleşme Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosIGTarihi'])){
            $igtar        = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosIGTarihi'])));
        }else{
            $igtar        = NULL;
        } // İade Gerçekleşme Tarihi

        if(!empty($form->guvenlik($form->values['dosSoz']))){
            if(!empty($form->guvenlik($form->values['dosDonem']))){
                if(!empty($form->guvenlik(@$sozgetir[0][ADMINID]))){
                    try{
                        $data = array(
                            'DOSNO'                 => $mno,
                            'SOZLESMEID'            => $form->guvenlik($form->values['dosSoz']),
                            'DONEMID'               => $form->guvenlik($form->values['dosDonem']),
                            'KDVIADETURID'          => html_entity_decode($form->values['dosKdvi']),
                            'ADMINID'               => @$sozgetir[0][ADMINID],
                            'VERGIDIADEDURUMID'     => $form->guvenlik($form->values['dosVergi']),
                            'IADETUTARI'            => $form->temizle($form->guvenlik($form->values['dosITutar'])),
                            'TAHAKKUKTUTARI'        => $form->temizle($form->guvenlik($form->values['dosTTutar'])),
                            'DOSYAALINMATARIHI'     => $datar,
                            'RAPORYAZILMATARIHI'    => $rytar,
                            'TESLIMEDILDIGITARIH'   => $tetar,
                            'IADEGERCEKTARIHI'      => $igtar,
                            'DOSYANOT'              => $form->guvenlik($form->values['dosNot']),
                            'DOSYAEKLEYEN'          => session::get("AdminID"),
                            'EKLEME_TARIHI'         => date("Y-m-d H:i:s"),
                            'DOSYAIP'               => $_SERVER['REMOTE_ADDR']
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $result = $model->doskaydet($data);
                        if($result){
                            try {
                                $data = array(
                                    'ADMINID'                   => $form->guvenlik($form->values['dosAdmin']),
                                    'KONU'                      => $mno." Nolu dosya tanımlaması",
                                    'ACIKLAMA'                  => @$sonkayit[0][MUKNO]." Nolu ".@$sonkayit[0][MUKSADI]." ".@$sonkayit[0][MUKSSOYADI]." ".@$sonkayit[0][MUKFADI]." Mükellefin ".$mno." nolu dosyası atandı.",
                                    'ISLEMTARIHI'               => date("Y-m-d"),
                                    'HATIRTARIHI'               => $dktar,
                                    'EKLEME_TARIHI'             => date("Y-m-d H:i:s"),
                                    'IPNO'                      => $_SERVER['REMOTE_ADDR']        
                                );
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                            $resuls = $tmodel->takvimkaydet($data);
                        }                        
                        if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> İlgili personeli seçiniz.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Dosya dönemi alanını boş bırakmayınız.</div>';}     
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Sözleşme alanını boş bırakmayınız.</div>';}                   
        }else{ // Sözleşme ve Personel Atama yapılmamışsa uyarı ver
            echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Lütfen İlgili Personele Mükkelef Ataması Yapınız. Aksi durumda DOSYA açamazsınız.</div>';
        }
    }

    // Mükellef Dosya Güncelleme Metodu
    public function dosguncelle(){
        $model          = $this->load->model("dosya_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('dosSoz', true)
                        ->isempty();
        $form           ->post('dosDonem', true)
                        ->isempty();
        $form           ->post('dosKdvi', true);
        $form           ->post('dosAdmin', true);
        $form           ->post('dosVergi', true);
        $form           ->post('dosITutar', true);
        $form           ->post('dosTTutar', true);
        $form           ->post('dosDATarihi', true);
        $form           ->post('dosRYTarihi', true);
        $form           ->post('dosTETarihi', true);
        $form           ->post('dosIGTarihi', true);
        $form           ->post('dosNot', true);
        $form           ->post('dosDurum', true);
        $form           ->post('dosID', true);
        $DOSID          = $form->values['dosID'];
        // Dosya Alım Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosDATarihi'])){
            $datar       = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosDATarihi'])));
        }else{
            $datar       = NULL;
        } // Dosya Alım Tarihi   
        // Rapor Yazma Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosRYTarihi'])){
            $rytar        = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosRYTarihi'])));
        }else{
            $rytar        = NULL;
        } // Rapor Yazma Tarihi
        // Teslim Edildiği Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosTETarihi'])){
            $tetar        = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosTETarihi'])));
        }else{
            $tetar        = NULL;
        } // Teslim Edildiği Tarihi
        // İade Gerçekleşme Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['dosIGTarihi'])){
            $igtar        = $form->guvenlik(date("Y-m-d", strtotime($form->values['dosIGTarihi'])));
        }else{
            $igtar        = NULL;
        } // İade Gerçekleşme Tarihi

        if(!empty($form->guvenlik($form->values['dosSoz']))){
            if(!empty($form->guvenlik($form->values['dosDonem']))){
                if(!empty($form->guvenlik($form->values['dosAdmin']))){
                    try{
                        $data = array(
                            'SOZLESMEID'            => $form->guvenlik($form->values['dosSoz']),
                            'DONEMID'               => $form->guvenlik($form->values['dosDonem']),
                            'KDVIADETURID'          => html_entity_decode($form->values['dosKdvi']),
                            'ADMINID'               => html_entity_decode($form->values['dosAdmin']),
                            'VERGIDIADEDURUMID'     => $form->guvenlik($form->values['dosVergi']),
                            'IADETUTARI'            => $form->temizle($form->guvenlik($form->values['dosITutar'])),
                            'TAHAKKUKTUTARI'        => $form->temizle($form->guvenlik($form->values['dosTTutar'])),
                            'DOSYAALINMATARIHI'     => $datar,
                            'RAPORYAZILMATARIHI'    => $rytar,
                            'TESLIMEDILDIGITARIH'   => $tetar,
                            'IADEGERCEKTARIHI'      => $igtar,
                            'DOSYANOT'              => $form->guvenlik($form->values['dosNot']),
                            'DOSYADURUM'            => $form->guvenlik($form->values['dosDurum']),
                            'DOSYAEKLEYEN'          => session::get("AdminID"),
                            'GUNCELLEME_TARIHI'     => date("Y-m-d H:i:s"),
                            'DOSYAIP'               => $_SERVER['REMOTE_ADDR']
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $result = $model->dosguncelle($data,$DOSID);
                        if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Güncelleme işleminiz başarılı şekilde gerçekleşti.</div>';
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Güncelleme işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> İlgili personeli seçiniz.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Dosya dönemi alanını boş bırakmayınız.</div>';}     
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Sözleşme alanını boş bırakmayınız.</div>';}                   
    }

    // Mükellef Dosya Silme Alan Metodu
    public function dossil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("dosya_model");       
        $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi  
        try{
            $data = array(
                'DOSYASIL'           => 1
            );
            } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
            }            
        $result     = $model->dossil($data,$KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }

    // Mükellef Dosya Listesi Modeli
    public function doslistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("dosya_model");
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
                  1   => 'sube',
                  2   => 'muk',
                  3   => 'donem',
                  4   => 'kdv',
                  5   => 'vergi',
                  6   => 'gorevli',
                  7   => 'itutar',
                  8   => 'ttutar',
                  9   => 'datarih',
                  10  => 'durum'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->dosyasayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->dosyalistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->dosya_arama($limit,$start,$search);
        $totalFiltered      = $model->dosya_arama_sayisi($search);
        }
        $data = array();
        if(!empty($kayitlar))
        {   $sn = 0;
            foreach ($kayitlar as $post)
            {
                $sn++;
                $matgisData['islem']           = '             
                <div class="btn-group m-b-10">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">İşlem Seç</button>
                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                <a class="dropdown-item" href="javascript:void(0);" onclick="getGoruntule('.$post['MDID'].')" data-toggle="modal" data-target=".islemBilgisiGoster"><i class="mdi mdi-eye"></i> Detay Görüntüle</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="firmaEkle('.$post['MDID'].')" data-toggle="modal" data-target=".islemTahsilatYap"><i class="mdi mdi-file"></i> Firma Ekle</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="getTahsilat('.$post['MDID'].')" data-toggle="modal" data-target=".islemTahsilatYap"><i class="mdi mdi-credit-card "></i> Tahsilat Ekle</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="dosDuzenle('.$post['MDID'].')""><i class="mdi mdi-tooltip-edit"></i> Düzenle</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="dosSil('.$post['MDID'].')" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>
                </div>
                </div>';                
                $matgisData['sube']             = $post['SUBEADI'];
                $matgisData['muk']              = $post['MUKFADI']." ".$post['MUKSADI']." ".$post['MUKSSOYADI'];
                $matgisData['donem']            = $post['YIL']."/".$post['AY'];
                $matgisData['kdv']              = $post['katKonu'];
                $matgisData['vergi']            = $post['tvdKonu'];
                $matgisData['gorevli']          = $post['ADI']." ".$post['SOYADI'];
                $matgisData['itutar']           = number_format($post['IADETUTARI'],2,',','.')." ₺";
                $matgisData['ttutar']           = number_format($post['TAHAKKUKTUTARI'],2,',','.')." ₺";
                $matgisData['datarih']          = date("d-m-Y",strtotime($post['DOSYAALINMATARIHI']));
                if($post['DOSYADURUM']==1){ 
                $matgisData['durum']           ='<span class="badge badge-success" style="padding: 6px;font-size:14px;">Aktif</span>';
                    }else{
                $matgisData['durum']           ='<span class="badge badge-danger" style="padding: 6px;font-size:14px;">Pasif</span>';
                    }                

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
    // Mükellef Listesi    
    public function sozlesmelist(){
        $dmodel                     = $this->load->model("dosya_model");
        $form                       = $this->load->siniflar('form');
        $mk                         = $form->guvenlik($_REQUEST['mk']);
        $data["sozlesmelist"]       = $dmodel->sozlesmelist($mk);
        $this->load->view("dosya/sozlesmelist", $data);
    }
    
    // Mükellef Dosyası Getirme Modeli
    public function dosyagetir(){
        $form                             = $this->load->siniflar('form');
        $dosya_model                      = $this->load->model("dosya_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $dosya_model->dosyagetir($KAYITID);
        echo json_encode($data);
    }
// Hizmet Veren Firmalar 
    // Firma Listesi
    public function firmalist(){
        $dmodel                     = $this->load->model("dosya_model");
        $form                       = $this->load->siniflar('form');
        $mk                         = $form->guvenlik($_REQUEST['mk']);
        $data["firmalist"]          = $dmodel->firmalist($mk);
        $this->load->view("dosya/firmalist", $data);
    }    
    // Seçili Firma Silme Alan Metodu
    public function firmasecsil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("dosya_model");       
        $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi           
        $result     = $model->firmasecsil($KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }
    // Firmaları  Getirme Modeli
    public function firmalarial(){
        $form                             = $this->load->siniflar('form');
        $dosya_model                      = $this->load->model("dosya_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $dosya_model->firmalarial($KAYITID);
        echo json_encode($data);
    }
    // Mükellef Seçili Firma Kaydetme Metodu
    public function firmaseckaydet(){
        $model          = $this->load->model("dosya_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('firmaSec', true)
                        ->isempty();
        $form           ->post('firmaNot', true);       
        $form           ->post('DOSYAID', true);       
        if(!empty($form->guvenlik($form->values['firmaSec']))){ 
            if(!empty($form->guvenlik($form->values['DOSYAID']))){
                try{
                    $data = array(
                        'DOSYAID'                   => $form->guvenlik($form->values['DOSYAID']),
                        'MAHNOT'                    => $form->guvenlik($form->values['firmaNot']),
                        'MAHID'                     => $form->guvenlik($form->values['firmaSec']),
                        'MAHKAYIT'                  => session::get("AdminID"),
                        'MAHIP'                     => $_SERVER['REMOTE_ADDR']
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                $result = $model->firmaseckaydet($data);
                if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Mükellef seçiniz.</div>';}
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Mal ve Hizmet veren firma seçiniz.</div>';}
    }
    // Mal ve Hizmet Veren Firma Ekleme Metodu    
    public function hizmetverenfirmaekle(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $dosya_model                        = $this->load->model("dosya_model");
        $index_model                        = $this->load->model("index_model");
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["dosduzenle"]                 = $dosya_model->dosduzenle($CID);
        $this->load->view("ustAlan", $data);
        $this->load->view("dosya/hizmetverenfirmaekle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);
    }

}