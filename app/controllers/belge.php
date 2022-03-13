<?php
/*
* MATGIS ymm
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class belge extends controller {
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
//Mükellef Belgeleri Alanı
    // Mükellef Belgeleri   
    public function belgeler(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["tahsilatturu"]               = $tanim_model->tahsilatturu();
        $this->load->view("ustAlan", $data);
        $this->load->view("belge/belgeler", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Mükellef belge Kaydetme Metodu
    public function belkaydet(){
        $model          = $this->load->model("belge_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('belMuk', true)
                        ->isempty();
        $form           ->post('belTipi', true)
                        ->isempty();
        $form           ->post('belDos', true);
        $form           ->post('belKonu', true);
        $form           ->post('belUzanti', true);
        $form           ->post('belNot', true);
        $form           ->post('belTarihi', true);

        // belge Alım Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['belTarihi'])){
            $datar       = $form->guvenlik(date("Y-m-d", strtotime($form->values['belTarihi'])));
        }else{
            $datar       = NULL;
        } // belge Alım Tarihi 
        if(!empty($form->guvenlik($form->values['belMuk']))){
            if(!empty($form->guvenlik($form->values['belTipi']))){
                        // Firma dosya dolu gelirse işlem yap
                        if(!empty($_FILES['belUzanti']['name'])){
                                ini_set('max_execution_time', 0);             
                                $hedefklasor         = SITE_YONETIM_DIZIN; // Hedef klasörümüz
                                $mimetype            = $_FILES['belUzanti']['type'];
                                $filesize            = $_FILES['belUzanti']['size'];
                                $listtype            = array(
                                '.jpg'               =>'image/jpg',
                                '.jpeg'              =>'image/jpeg',
                                '.png'               =>'image/png',
                                '.doc'               =>'application/msword',
                                '.docx'              =>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                '.xls'               =>'application/vnd.ms-excel',
                                '.xlsx'              =>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                '.pdf'               =>'application/pdf'); 
                                if (@is_uploaded_file( $_FILES['belUzanti']['tmp_name']))
                                {
                                    if($key = array_search($_FILES['belUzanti']['type'],$listtype))
                                    {
                                        $belUzantis       =  "belge-".rand(0,99999).$_FILES["belUzanti"]["name"];            
                                        $belUzantiName    = $hedefklasor."belge/".$belUzantis;
                                        @move_uploaded_file($_FILES["belUzanti"]["tmp_name"], $belUzantiName);
                                            switch($mimetype) {
                                                case "image/jpg":
                                                    $resim           = imagecreatefromjpeg($belUzantiName);
                                                    break;         
                                                case "image/jpeg":
                                                    $resim           = imagecreatefromjpeg($belUzantiName);
                                                    break;
                                                case "image/gif":
                                                    $resim           = imagecreatefromgif($belUzantiName);
                                                    break;
                                                case "image/png":
                                                    $resim           = imagecreatefrompng($belUzantiName);
                                                    break;
                                            }
                                    }
                                    $boyutlar            = getimagesize($belUzantiName); // Resmimizin boyutlarını öğreniyoruz
                                    $resimorani          = 1050 / $boyutlar[0];           // Resmi küçültme/büyütme oranımızı hesaplıyoruz..
                                    $yeniyukseklik       = $resimorani*$boyutlar[1];  // Bulduğumuz orandan yeni yüksekliğimizi hesaplıyoruz..
                                    $yeniresim           = imagecreatetruecolor("1050", $yeniyukseklik); // Oluşturulan boş resmi istediğimiz boyutlara getiriyoruz..
                                    imagealphablending($yeniresim, false); // Logo Png olarak eklendiği zaman arka planı transparan yapmaktadır
                                    imagesavealpha($yeniresim,true);
                                    $transparency        = imagecolorallocatealpha($yeniresim, 255, 255, 255, 127);
                                    imagefilledrectangle($yeniresim, 0, 0, $yeniyukseklik, $yeniyukseklik, $transparency);                        
                                    imagecopyresampled($yeniresim, $resim, 0, 0, 0, 0, "1050", $yeniyukseklik, $boyutlar[0], $boyutlar[1]);
                                    switch($mimetype) {
                                        case "image/jpg":
                                            $resim           = imagejpeg($yeniresim, $belUzantiName, 100);
                                            break;
                                        case "image/jpeg":
                                            $resim           = imagejpeg($yeniresim, $belUzantiName, 100);
                                            break;
                                        case "image/gif":
                                            $resim           = imagegif($_FILES["belUzanti"]["tmp_name"][$a]);
                                            break;
                                        case "image/png":
                                            $resim           = imagepng($yeniresim, $belUzantiName, 0);
                                            break;
                                    }                 
                                    //Kaydettiğimiz yeni resimin yolunu $hedefdosya değişkeni taşımaktadır.. 
                                    // Belleği serbest bırakalım
                                    imagedestroy($yeniresim);
                                }else{
                                echo "Dosya Türü Geçersiz";
                            }      
                        }                    
                    try{
                        $data = array(
                            'MUKELLEFID'            => $form->guvenlik($form->values['belMuk']),
                            'DOSYAID'               => $form->guvenlik($form->values['belDos']),
                            'BELTURU'               => html_entity_decode($form->values['belTipi']),
                            'belKonu'               => html_entity_decode($form->values['belKonu']),
                            'belUzanti'             => $belUzantis,
                            'belNot'                => html_entity_decode($form->values['belNot']),
                            'belTarihi'             => $datar,
                            'belEkleyen'            => session::get("AdminID"),
                            'belIP'                 => $_SERVER['REMOTE_ADDR']
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $result = $model->belkaydet($data);
                    if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Belge tipi alanını boş bırakmayınız.</div>';}     
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Mükellef alanını boş bırakmayınız.</div>';}                   
    }

    // Mükellef belge Silme Alan Metodu
    public function belsil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("belge_model");       
        $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi  
        $brv        = $model->belgeal($KAYITID);
        if(!empty(@$brv[0][belUzanti])){
            $resimsil    = @unlink(SITE_YONETIM_DIZIN."belge/".$brv[0][belUzanti]);
        }else{
            $resimsil    = @$brv[0][BELID];
        }            
        $result     = $model->belsil($KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }

    // Mükellef belge Listesi Modeli
    public function bellistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("belge_model");
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
                  1   => 'tipi',
                  2   => 'muk',
                  4   => 'konu',
                  5   => 'dosya',
                  6   => 'tarih'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->belgesayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->belgelistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->belge_arama($limit,$start,$search);
        $totalFiltered      = $model->belge_arama_sayisi($search);
        }
        $data = array();
        if(!empty($kayitlar))
        {   $sn = 0;
            foreach ($kayitlar as $post)
            {
                $sn++;
                $matgisData['islem']           = '             
                <div class="btn-group m-b-10 btn btn-danger"><a href="javascript:void(0);" onclick="belSil('.$post['BELID'].')" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>
                </div>';                
                $matgisData['tipi']             = $post['tbtKonu'];
                $matgisData['muk']              = $post['MUKFADI']." ".$post['MUKSADI']." ".$post['MUKSSOYADI'];
                $matgisData['konu']             = $post['belKonu'];
                if($post['BELTURU']==1){
                $matgisData['dosya']            = '<a href="'.SITE_URL.'/upload/belge/'.$post['belUzanti'].'"><i style="font-size:36px;" class="mdi mdi-briefcase-download"></i></a>';
                }elseif($post['BELTURU']==2){
                $matgisData['dosya']            = '<a href="'.SITE_URL.'/upload/belge/'.$post['belUzanti'].'"><img src="'.SITE_URL.'/upload/belge/'.$post['belUzanti'].'" style="max-height:30px;"></a>';
                }
                $matgisData['tarih']            = date("d-m-Y",strtotime($post['belTarihi']));
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
    public function mukelleflist(){
        $dmodel                     = $this->load->model("belge_model");
        $form                       = $this->load->siniflar('form');
        $mk                         = $form->guvenlik($_REQUEST['mk']);
        $data["mukelleflist"]       = $dmodel->mukelleflist($mk);
        $this->load->view("belge/mukelleflist", $data);
    }
    
    // Mükellef belgesı Getirme Modeli
    public function belgegetir(){
        $form                             = $this->load->siniflar('form');
        $belge_model                      = $this->load->model("belge_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $belge_model->belgegetir($KAYITID);
        echo json_encode($data);
    }
}