<?php
/*
* MATGIS Formlar
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class formlar extends controller {
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
//Formlar Alanı
    // Formlar   
    public function uretimhattikontrolformu(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $this->load->view("ustAlan", $data);
        $this->load->view("form/uretimhattikontrolformu", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Üretim Hattı Kontrol Formu Ekleme    
    public function uretimhattikontrolformuekle(){
        $form                               = $this->load->siniflar('form');
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $formlar_model                         = $this->load->model("formlar_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["malimusavirler"]             = $tanim_model->malimusavirler();
        $this->load->view("ustAlan", $data);
        $this->load->view("form/uretimhattikontrolformuekle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Üretim Hattı Kontrol Formu Düzenleme    
    public function formduzenle(){
        $form                               = $this->load->siniflar('form');
        $CID                                = $form->guvenlik($_REQUEST['ID']);
        $formlar_model                         = $this->load->model("formlar_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $index_model                        = $this->load->model("index_model");
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["formduzenle"]                = $formlar_model->uretimhattikontrolformuduzenle($CID);
        $data["malimusavirler"]             = $tanim_model->malimusavirler();
        $this->load->view("ustAlan", $data);
        $this->load->view("form/uretimhattikontrolformuduzenle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);
    }

    // Üretim Hattı Kontrol Formu Kaydetme Metodu
    public function uretimhattikontrolformukaydet(){
        $model          = $this->load->model("formlar_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('formUnvani', true)
                        ->isempty();
        $form           ->post('formYetkili', true);
        $form           ->post('formVN', true)
                        ->isempty();
        $form           ->post('formMM', true);
        $form           ->post('formSM', true);
        $form           ->post('formVD', true);
        $form           ->post('formAdres', true);
        $form           ->post('formEPosta', true);
        $form           ->post('formTel', true);
        $form           ->post('formNot', true);
        $_SESSION['formUnvani']      = $form->guvenlik($form->values['formUnvani']);                            
        $_SESSION['formYetkili']     = $form->guvenlik($form->values['formYetkili']);                            
        $_SESSION['formVN']          = $form->guvenlik($form->values['formVN']);                            
        $_SESSION['formMM']          = $form->guvenlik($form->values['formMM']);                            
        $_SESSION['formSM']          = $form->guvenlik($form->values['formSM']);                            
        $_SESSION['formVD']          = $form->guvenlik($form->values['formVD']);                            
        $_SESSION['formAdres']       = $form->guvenlik($form->values['formAdres']);                            
        $_SESSION['formEPosta']      = $form->guvenlik($form->values['formEPosta']);                            
        $_SESSION['formTel']         = $form->guvenlik($form->values['formTel']);                            
        $_SESSION['formNot']         = $form->guvenlik($form->values['formNot']);          
        $vkn            = $form->guvenlik($form->values['formVN']);
        $eml            = $form->guvenlik($form->values['formEPosta']);
        $tel            = $form->guvenlik($form->values['formTel']);
        $mukerrer       = $model->firmakontrol($vkn,$eml,$tel);
        if(@$mukerrer[0][FIRMAVN]==$vkn){
            echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('DİKKAT!... Vergi kimlik numarası daha önce kaydedilmiş. Kontrollerinizi yapıp tekrar deneyiniz.')</script>";
        }else
            if(@$mukerrer[0][FIRMATEL]==$tel){
                echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('DİKKAT!... Telefon numarası daha önce kaydedilmiş. Kontrollerinizi yapıp tekrar deneyiniz.')</script>";
            }else
                if(@$mukerrer[0][FIRMAEPOSTA]==$eml){
                    echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('DİKKAT!... Email adresi daha önce kaydedilmiş. Kontrollerinizi yapıp tekrar deneyiniz.')</script>";
                }else{                
                    if(!empty($form->guvenlik($form->values['formUnvani']))){
                    if(!empty($form->guvenlik($form->values['formVN']))){
                                    try{
                                        $data = array(
                                            'YMMID'                     => $form->guvenlik($form->values['formMM']),
                                            'SMMID'                     => $form->guvenlik($form->values['formSM']),
                                            'FIRMAUNVANI'               => $form->guvenlik($form->values['formUnvani']),
                                            'FIRMAYETKILI'              => $form->guvenlik($form->values['formYetkili']),
                                            'FIRMAVN'                   => $form->guvenlik($form->values['formVN']),
                                            'FIRMAVD'                   => $form->guvenlik($form->values['formVD']),
                                            'FIRMAADRES'                => $form->guvenlik($form->values['formAdres']),
                                            'FIRMATEL'                  => $form->guvenlik($form->values['formTel']),
                                            'FIRMAEPOSTA'               => $form->guvenlik($form->values['formEPosta']),
                                            'FIRMAKAYTARIHI'            => date("Y-m-d"),
                                            'FIRMANOT'                  => $form->guvenlik($form->values['formNot']),
                                            'FIRMAKAYIT'                => session::get("AdminID"),
                                            'FIRMAIP'                   => $_SERVER['REMOTE_ADDR']
                                        );
                                } catch (PDOException $e) {
                                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                                }
                                $result = $model->formkaydet($data);
                            if($result){                                 
                                unset($_SESSION['formUnvani']);
                                unset($_SESSION['formMM']);
                                unset($_SESSION['formSM']);
                                unset($_SESSION['formYetkili']);
                                unset($_SESSION['formVN']);
                                unset($_SESSION['formVD']);
                                unset($_SESSION['formAdres']);
                                unset($_SESSION['formTel']);
                                unset($_SESSION['formEPosta']);
                                unset($_SESSION['formNot']);
                            echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde güncellendi.</div>';
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz güncellenmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Firma Vergi No ve TC No  yazınız.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Firma Ünvanı alanını boş bırakmayınız.</div>';}     
        }
    }


    // Üretim Hattı Kontrol Formu Güncelleme Metodu
    public function uretimhattikontrolformuguncelle(){
        $model          = $this->load->model("formlar_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('formUnvani', true)
                        ->isempty();
        $form           ->post('formYetkili', true);
        $form           ->post('formVN', true)
                        ->isempty();
        $form           ->post('formVD', true);
        $form           ->post('formAdres', true);
        $form           ->post('formEPosta', true);
        $form           ->post('formTel', true);
        $form           ->post('formNot', true);
        $form           ->post('formDurum', true);
        $form           ->post('formMM', true);
        $form           ->post('formSM', true);
        $form           ->post('FIRMAID', true);
        $KID            = $form->guvenlik($form->values['FIRMAID']);
            if(!empty($form->guvenlik($form->values['formUnvani']))){
                    if(!empty($form->guvenlik($form->values['formVN']))){
                                    try{
                                        $data = array(
                                            'MHVID'                     => $KID,
                                            'YMMID'                     => $form->guvenlik($form->values['formMM']),
                                            'SMMID'                     => $form->guvenlik($form->values['formSM']),
                                            'FIRMAUNVANI'               => $form->guvenlik($form->values['formUnvani']),
                                            'FIRMAYETKILI'              => $form->guvenlik($form->values['formYetkili']),
                                            'FIRMAVN'                   => $form->guvenlik($form->values['formVN']),
                                            'FIRMAVD'                   => $form->guvenlik($form->values['formVD']),
                                            'FIRMAADRES'                => $form->guvenlik($form->values['formAdres']),
                                            'FIRMATEL'                  => $form->guvenlik($form->values['formTel']),
                                            'FIRMAEPOSTA'               => $form->guvenlik($form->values['formEPosta']),
                                            'FIRMADURUM'                => $form->guvenlik($form->values['formDurum']),
                                            'FIRMAKAYTARIHI'            => date("Y-m-d"),
                                            'FIRMANOT'                  => $form->guvenlik($form->values['formNot']),
                                            'FIRMAKAYIT'                => date("Y-m-d H:i:s"),
                                            'FIRMAIP'                   => $_SERVER['REMOTE_ADDR']
                                        );
                                } catch (PDOException $e) {
                                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                                }
                                $result = $model->formguncelle($data,$KID);
                            if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde güncellendi.</div>';
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz güncellenmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Firma Vergi No ve TC No  yazınız.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Firma Ünvanı alanını boş bırakmayınız.</div>';}     
    }  
    // Üretim Hattı Kontrol Formu Silme Alan Metodu
    public function uretimhattikontrolformusil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("formlar_model");       
        $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi           
        $result     = $model->uretimhattikontrolformusil($KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }

    // Üretim Hattı Kontrol Formu Listesi Modeli
    public function uretimhattikontrolformulistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("formlar_model");
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
                    2   => 'unvan',
                    3   => 'yetki',
                    4   => 'vn',
                    5   => 'vd',
                    6   => 'adres',
                    7   => 'tel',
                    8   => 'eposta',
                    9   => 'not',
                    10   => 'durum'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->formsayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->formlistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->form_arama($limit,$start,$search);
        $totalFiltered      = $model->form_arama_sayisi($search);
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
                <a class="dropdown-item" href="javascript:void(0);" onclick="formCezaliYap('.$post['MHVID'].')"><i class="mdi mdi-account-settings "></i> Cezalı Yap</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="formDuzenle('.$post['MHVID'].')"><i class="mdi mdi-tooltip-edit"></i> Düzenle</a>
                <a class="dropdown-item" href="javascript:void(0);" onclick="formSil('.$post['MHVID'].')" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>
                </div>
                </div>';               
                $matgisData['unvan']            = $post['FIRMAUNVANI'];
                $matgisData['yetki']            = $post['FIRMAYETKILI'];
                $matgisData['vn']               = $post['FIRMAVN'];
                $matgisData['vd']               = $post['FIRMAVD'];
                $matgisData['adres']            = $post['FIRMAADRES'];
                $matgisData['tel']              = $post['FIRMATEL'];
                $matgisData['eposta']           = $post['FIRMAEPOSTA'];
                $matgisData['not']              = $post['FIRMANOT'];
                if($post['FIRMADURUM']==1){ 
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
    // Cezalı Firma Listesi Modeli
    public function cezalifirmalistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("formlar_model");
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
                  2   => 'firma',
                  3   => 'yetki',
                  4   => 'vd',
                  5   => 'vn',
                  6   => 'telefon',
                  7   => 'cnot',
                  8   => 'ceztar',
                  9   => 'durum'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->cezalifirmasayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->cezalifirmalistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->cezalifirma_arama($limit,$start,$search);
        $totalFiltered      = $model->cezalifirma_arama_sayisi($search);
        }
        $data = array();
        if(!empty($kayitlar))
        {   $sn = 0;
            foreach ($kayitlar as $post)
            {
                $sn++;
                $matgisData['islem']            = '<a class="dropdown-item" href="javascript:void(0);" onclick="cezaSil('.$post['MCID'].')" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>';                
                $matgisData['sube']             = $post['SUBEADI'];
                $matgisData['firma']            = $post['FIRMAUNVANI'];
                $matgisData['yetki']            = $post['FIRMAYETKILI'];
                $matgisData['vd']               = $post['FIRMAVD'];
                $matgisData['vn']               = $post['FIRMAVN'];
                $matgisData['telefon']          = $post['FIRMATEL'];
                $matgisData['cnot']             = $post['FIRMANOT'];
                $matgisData['ceztar']           = date("d-m-Y",strtotime($post['TARIH']));
                if($post['FIRMADURUM']==1){ 
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

}