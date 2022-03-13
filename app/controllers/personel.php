<?php
/*
* MATGIS personel
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class personel extends controller {
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
//Personel Alanı
    // Personeller   
    public function personeller(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $this->load->view("ustAlan", $data);
        $this->load->view("personel/personeller", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Personel Ekleme    
    public function persekle(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $personel_model                     = $this->load->model("personel_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $this->load->view("ustAlan", $data);
        $this->load->view("personel/persekle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Personel Düzenleme    
    public function persduzenle(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $personel_model                     = $this->load->model("personel_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["persduzenle"]                = $personel_model->persduzenle($CID);
        $this->load->view("ustAlan", $data);
        $this->load->view("personel/persduzenle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);
    }

    // Personel Kaydetme Metodu
    public function perskaydet(){
        $model          = $this->load->model("personel_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('persKodu', true)
                        ->isempty();
        $form           ->post('persAdi', true)
                        ->isempty();
        $form           ->post('persSoyadi', true)
                        ->isempty();
        $form           ->post('persTcNo', true);
        $form           ->post('persTarihi', true);
        $form           ->post('persTel', true)
                        ->isempty();
        $form           ->post('persEPosta', true);
        $form           ->post('persGBT', true);
        $form           ->post('persGAT', true);
        $form           ->post('persGorevi', true);
        $form           ->post('persSifre', true);          
        $vkn            = $form->guvenlik($form->values['persTcNo']);
        $eml            = $form->guvenlik($form->values['persEPosta']);
        $tel            = $form->guvenlik($form->values['persTel']);
        $_SESSION['persKodu']    = $form->guvenlik($form->values['persKodu']);                            
        $_SESSION['persAdi']     = $form->guvenlik($form->values['persAdi']);                            
        $_SESSION['persSoyadi']  = $form->guvenlik($form->values['persSoyadi']);                            
        $_SESSION['persTcNo']    = $form->guvenlik($form->values['persTcNo']);                            
        $_SESSION['persTarihi']  = $form->guvenlik($form->values['persTarihi']);                            
        $_SESSION['persTel']     = $form->guvenlik($form->values['persTel']);                            
        $_SESSION['persEPosta']  = $form->guvenlik($form->values['persEPosta']);                            
        $_SESSION['persGBT']     = $form->guvenlik($form->values['persGBT']);                            
        $_SESSION['persGAT']     = $form->guvenlik($form->values['persGAT']);                            
        $_SESSION['persGorevi']  = $form->guvenlik($form->values['persGorevi']);                            
        $mukerrer                = $model->personelkontrol($vkn,$eml,$tel);
        if(@$mukerrer[0][tc]==$vkn){
            echo @str_repeat(1)."<script type='text/javascript'>alert('DİKKAT!... TC kimlik numarası daha önce kaydedilmiş. Kontrollerinizi yapıp tekrar deneyiniz.')</script>";
        }else 
        if(@$mukerrer[0][gsm]==$tel){
                echo @str_repeat(1)."<script type='text/javascript'>alert('DİKKAT!... Telefon numarası daha önce kaydedilmiş. Kontrollerinizi yapıp tekrar deneyiniz.')</script>";
            }else 
            if(@$mukerrer[0][email]==$eml){
                    echo @str_repeat(1)."<script type='text/javascript'>alert('DİKKAT!... Email adresi daha önce kaydedilmiş. Kontrollerinizi yapıp tekrar deneyiniz.')</script>";
                }else{           
                    // Sözleşme Başlatma Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
                    if(!empty($form->values['persTarihi'])){
                        $pdg         = $form->guvenlik(date("Y-m-d", strtotime($form->values['persTarihi'])));
                    }else{
                        $pdg         = NULL;
                    } // Sözleşme Başlatma Tarihi   
                    // Sözleşme Bitiş Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
                    if(!empty($form->values['persGBT'])){
                        $pgbt        = $form->guvenlik(date("Y-m-d", strtotime($form->values['persGBT'])));
                    }else{
                        $pgbt        = NULL;
                    } // Sözleşme Bitiş Tarihi

                    // Sözleşme Bitiş Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
                    if(!empty($form->values['persGAT'])){
                        $pgba        = $form->guvenlik(date("Y-m-d", strtotime($form->values['persGAT'])));
                    }else{
                        $pgba        = NULL;
                    } // Sözleşme Bitiş Tarihi
                    $salt            = 'W=0d!G__?//34Yt';
                    if(!empty($form->values['persSifre'])){
                    $sifrem          = hash('sha256', $form->values['persSifre'].$salt);
                    }
                    if(!empty($form->guvenlik($form->values['persAdi']))){
                        if(!empty($form->guvenlik($form->values['persSoyadi']))){
                            if(!empty($form->guvenlik($form->values['persTel']))){
                                if(!empty($form->guvenlik($form->values['persKodu']))){
                                                try{
                                                    $data = array(
                                                        'adi'                       => $form->guvenlik($form->values['persAdi']),
                                                        'soyadi'                    => $form->guvenlik($form->values['persSoyadi']),
                                                        'tc'                        => $form->guvenlik($form->values['persTcNo']),
                                                        'gsm'                       => $form->guvenlik($form->values['persTel']),
                                                        'email'                     => $form->guvenlik($form->values['persEPosta']),
                                                        'gorevi'                    => $form->guvenlik($form->values['persGorevi']),
                                                        'dtarihi'                   => $pdg,
                                                        'isbasitarihi'              => $pgbt,
                                                        'iscikistarihi'             => $pgba,
                                                        'perskodu'                  => $form->guvenlik($form->values['persKodu']),
                                                        'perssifresi'               => $sifrem
                                                    );
                                            } catch (PDOException $e) {
                                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                                            }
                                            $result = $model->perskaydet($data);
                                        if($result){ 
                                            unset($_SESSION['persKodu']);
                                            unset($_SESSION['persAdi']);
                                            unset($_SESSION['persSoyadi']);
                                            unset($_SESSION['persTcNo']);
                                            unset($_SESSION['persTarihi']);
                                            unset($_SESSION['persTel']);
                                            unset($_SESSION['persEPosta']);
                                            unset($_SESSION['persGBT']);
                                            unset($_SESSION['persGAT']);
                                            unset($_SESSION['persGorevi']);                                           
                                        echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde güncellendi.</div>';
                                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz güncellenmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Personel soyadını yazınız.</div>';}
                            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Personel adını yazınız.</div>';}
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Personel türü alanını boş bırakmayınız.</div>';}     
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Şube alanını boş bırakmayınız.</div>';}                   
                }
    }


    // Personel Güncelleme Metodu
    public function persguncelle(){
        $model          = $this->load->model("personel_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('persKodu', true)
                        ->isempty();
        $form           ->post('persAdi', true)
                        ->isempty();
        $form           ->post('persSoyadi', true)
                        ->isempty();
        $form           ->post('persTcNo', true);
        $form           ->post('persTarihi', true);
        $form           ->post('persTel', true)
                        ->isempty();
        $form           ->post('persEPosta', true);
        $form           ->post('persGBT', true);
        $form           ->post('persGAT', true);
        $form           ->post('persGorevi', true);
        $form           ->post('persSifre', true);          
        $form           ->post('persSifresi', true);          
        $vkn            = $form->guvenlik($form->values['persTcNo']);
        $eml            = $form->guvenlik($form->values['persEPosta']);
        $tel            = $form->guvenlik($form->values['persTel']);
        $_SESSION['persKodu']    = $form->guvenlik($form->values['persKodu']);                            
        $_SESSION['persAdi']     = $form->guvenlik($form->values['persAdi']);                            
        $_SESSION['persSoyadi']  = $form->guvenlik($form->values['persSoyadi']);                            
        $_SESSION['persTcNo']    = $form->guvenlik($form->values['persTcNo']);                            
        $_SESSION['persTarihi']  = $form->guvenlik($form->values['persTarihi']);                            
        $_SESSION['persTel']     = $form->guvenlik($form->values['persTel']);                            
        $_SESSION['persEPosta']  = $form->guvenlik($form->values['persEPosta']);                            
        $_SESSION['persGBT']     = $form->guvenlik($form->values['persGBT']);                            
        $_SESSION['persGAT']     = $form->guvenlik($form->values['persGAT']);                            
        $_SESSION['persGorevi']  = $form->guvenlik($form->values['persGorevi']);   
        $form           ->post('persid', true)
                        ->isempty();        
        $KID            = $form->guvenlik($form->values['persid']);                                        
                    // Sözleşme Başlatma Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
                    if(!empty($form->values['persTarihi'])){
                        $pdg         = $form->guvenlik(date("Y-m-d", strtotime($form->values['persTarihi'])));
                    }else{
                        $pdg         = NULL;
                    } // Sözleşme Başlatma Tarihi   
                    // Sözleşme Bitiş Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
                    if(!empty($form->values['persGBT'])){
                        $pgbt        = $form->guvenlik(date("Y-m-d", strtotime($form->values['persGBT'])));
                    }else{
                        $pgbt        = NULL;
                    } // Sözleşme Bitiş Tarihi

                    // Sözleşme Bitiş Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
                    if(!empty($form->values['persGAT'])){
                        $pgba        = $form->guvenlik(date("Y-m-d", strtotime($form->values['persGAT'])));
                    }else{
                        $pgba        = NULL;
                    } // Sözleşme Bitiş Tarihi
                    $salt            = 'W=0d!G__?//34Yt';
                    if(!empty($form->values['persSifre'])){
                    $sifrem          = hash('sha256', $form->values['persSifre'].$salt);
                    }elseif(empty($form->values['persSifre'])){
                    $sifrem          = $form->values['persSifresi'];
                    }
                    if(!empty($form->guvenlik($form->values['persAdi']))){
                        if(!empty($form->guvenlik($form->values['persSoyadi']))){
                            if(!empty($form->guvenlik($form->values['persTel']))){
                                if(!empty($form->guvenlik($form->values['persKodu']))){
                                                try{
                                                    $data = array(
                                                        'adi'                       => $form->guvenlik($form->values['persAdi']),
                                                        'soyadi'                    => $form->guvenlik($form->values['persSoyadi']),
                                                        'tc'                        => $form->guvenlik($form->values['persTcNo']),
                                                        'gsm'                       => $form->guvenlik($form->values['persTel']),
                                                        'email'                     => $form->guvenlik($form->values['persEPosta']),
                                                        'gorevi'                    => $form->guvenlik($form->values['persGorevi']),
                                                        'dtarihi'                   => $pdg,
                                                        'isbasitarihi'              => $pgbt,
                                                        'iscikistarihi'             => $pgba,
                                                        'perskodu'                  => $form->guvenlik($form->values['persKodu']),
                                                        'perssifresi'               => $sifrem
                                                    );
                                            } catch (PDOException $e) {
                                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                                            }
                                            $result = $model->persguncelle($data,$KID);
                                            if($result){ 
                                            unset($_SESSION['persKodu']);
                                            unset($_SESSION['persAdi']);
                                            unset($_SESSION['persSoyadi']);
                                            unset($_SESSION['persTcNo']);
                                            unset($_SESSION['persTarihi']);
                                            unset($_SESSION['persTel']);
                                            unset($_SESSION['persEPosta']);
                                            unset($_SESSION['persGBT']);
                                            unset($_SESSION['persGAT']);
                                            unset($_SESSION['persGorevi']);                                           
                                        echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde güncellendi.</div>';
                                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz güncellenmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Personel soyadını yazınız.</div>';}
                            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Personel adını yazınız.</div>';}
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Personel türü alanını boş bırakmayınız.</div>';}     
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Şube alanını boş bırakmayınız.</div>';}                   
    }

    // Personel Silme Alan Metodu
    public function perssil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("personel_model");       
        $KAYITID    = (int)$form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi  
        try{
            $data = array(
                'PERSSIL'                     => 1
            );
            } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
            }            
        $result     = $model->perssil($data,$KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }

    // Personel Listesi Modeli
    public function perslistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("personel_model");
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
                    1   => 'pkodu',
                    2   => 'tc',
                    3   => 'adi',
                    4   => 'sadi',
                    5   => 'gsm',
                    6   => 'email',
                    7   => 'gorevi',
                    8   => 'gbt',
                    9   => 'durum'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->personelsayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->personellistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->personel_arama($limit,$start,$search);
        $totalFiltered      = $model->personel_arama_sayisi($search);
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
                <a class="dropdown-item" href="javascript:void(0);" onclick="getGoruntule('.$post['pid'].')" data-toggle="modal" data-target=".islempersGoster"><i class="mdi mdi-eye"></i> Personel Detayı</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="persYetkiVer('.$post['pid'].')"><i class="mdi mdi-account-settings "></i> Yetki Ver</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="persDuzenle('.$post['pid'].')"><i class="mdi mdi-tooltip-edit"></i> Düzenle</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="persSil('.$post['pid'].')" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>
                </div>
                </div>';               
                $matgisData['pkodu']            = $post['perskodu'];
                $matgisData['tc']               = $post['tc'];
                $matgisData['adi']              = $post['adi'];
                $matgisData['sadi']             = $post['soyadi'];
                $matgisData['gsm']              = $post['gsm'];
                $matgisData['email']            = $post['email'];
                $matgisData['gorevi']           = $post['gorevi'];
                $matgisData['gbt']              = date("d-m-Y",strtotime($post['isbasitarihi']));
                if($post['pdurumu']==1){ 
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

    
    // Personel  Getirme Modeli
    
    public function persgetir(){
        $form                             = $this->load->siniflar('form');
        $personel_model                   = $this->load->model("personel_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $personel_model->persgetir($KAYITID);
        echo json_encode($data);
    }

    // Personel Yetki Verme Metodu    
    public function yetkiver(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $personel_model                     = $this->load->model("personel_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["istasyonlar"]                = $tanim_model->istasyonlar();
        $data["yetkiler"]                   = $tanim_model->persyetkilistesi($CID);
        $data["menulistesi"]                = $index_model->menulistesi();
        $this->load->view("ustAlan", $data);
        $this->load->view("personel/yetkiver", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Personel Yetki Kaydetme Metodu
    public function yetkikaydet(){
        $form           = $this->load->siniflar('form');
        $model          = $this->load->model("personel_model");        
        $form           ->post('persid', true);
        $form           ->post('istasyonid', true);
        $form           ->post('yetkiGor', true);
        $form           ->post('yetkiRed', true);
        $form           ->post('yetkiKabul', true);
        $form           ->post('yetkiDuzenle', true);              

            try{
                $data = array(
                    'persid'              => $form->guvenlik($form->values['persid']),
                    'istasyonid'          => $form->guvenlik($form->values['istasyonid']),
                    'gor'                 => $form->guvenlik($form->values['yetkiGor']),
                    'red'                 => $form->guvenlik($form->values['yetkiRed']),
                    'kabul'               => $form->guvenlik($form->values['yetkiKabul']),
                    'duzenle'             => $form->guvenlik($form->values['yetkiDuzenle'])
                );
            } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
            }
            $result = $model->yetkikaydet($data);
            if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde güncellendi.</div>';
                header('Refresh: 0; url= '.SITE_URL.'/personel/personeller/&ID=18');
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz güncellenmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
    }

    // Personel Yetkisi Silme Alan Metodu
    public function yetkisil(){
        $form       = $this->load->siniflar('form');
        $model      = $this->load->model("personel_model");
        $form       ->post('id', true)
                    ->isempty();
        $KAYITID    = $form->values['id'];
        $result     = $model->yetkisil($KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }
}