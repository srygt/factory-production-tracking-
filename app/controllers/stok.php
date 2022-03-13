<?php
/*
* MATGIS TETS
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class stok extends controller {

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
// Stok Alanı
        // Stok Ürün Listesi
        public function stokurunleri(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $smodel                           = $this->load->model("stok_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $cap                              = $form->guvenlik($_REQUEST['cap']);
            $litre                            = $form->guvenlik($_REQUEST['litre']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["stokurunleri"]     = $smodel->stokurunleri($cap,$litre);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/stokurunleri", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
        // Barkod Listesi
        public function barkodlar(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/barkodlar", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
        // Stok Ekle
        public function stokekle(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $smodel                           = $this->load->model("stok_model");
            $tmodel                           = $this->load->model("tanim_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["stokkategori"]     = $smodel->stokkategori();
            $yoneticilogu["raflar"]           = $tmodel->raflar();
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/stokekle", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
        // Stok Çıkışı Yap
        public function stokcikisiyap(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $stok_model                       = $this->load->model("stok_model");
            $musteri_model                    = $this->load->model("musteri_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $STOKID                           = $form->guvenlik($_REQUEST['SID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["musteriler"]       = $musteri_model->musteriler();
            $yoneticilogu["stokgetir"]        = $stok_model->stokgetir($STOKID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/stokcikisiyap", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
        // Tank Listesi
        public function tanklist(){
            $dmodel                     = $this->load->model("stok_model");
            $mk                         = $_REQUEST['mk'];
            $data["tanklist"]           = $dmodel->tanklist($mk);
            $this->load->view("stok/tanklist", $data);
        }            
        // Stok Kartı
        public function stokkarti(){
            $dmodel                     = $this->load->model("stok_model");
            $mk                         = $_REQUEST['ID'];
            $data["kartbilgisi"]        = $dmodel->kartbilgisi($mk);
            $this->load->view("stok/stokkarti", $data);
        }            
        // Stoktakiler
        public function stoktakiler(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/stoktakiler", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
          // Yapılan Çıkışlar
          public function mustericikislari(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $stok_model                       = $this->load->model("stok_model");
            $musteriid                        = $form->guvenlik($_REQUEST['musteriid']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["mustericikislari"] = $stok_model->mustericikislari($musteriid);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/mustericikislari", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
          } 
          // Yapılan Çıkışlar
          public function cikislar(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("stok/cikislar", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
          }           
        // Stok Çıkışı Silme Alan Metodu
        public function stokcikisisil(){
            $form       = $this->load->siniflar('form');     
            $model      = $this->load->model("stok_model");       
            $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi           
            $result     = $model->stokcikisisil($KAYITID);
            if($result){     
            echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
            }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
        }
        // Toplu Stok Silme Alan Metodu
        public function toplusil(){
            $form           = $this->load->siniflar('form');
            $model          = $this->load->model("stok_model");       
            $form           ->post('toplusec', true);
            $toplusec       = $_POST['toplusec'];
            for ($i=0; $i <count($toplusec); $i++) { 
                $tanksil = $toplusec[$i];
                $result  = $model->stoktanksil($tanksil);
                $results = $model->tanksil($tanksil);
           }
            if($results){     
            echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
            }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
        }        
        // Stok Silme Alan Metodu
        public function stoksil(){
            $form       = $this->load->siniflar('form');     
            $model      = $this->load->model("stok_model");       
            $STOKID     = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi
            $stokgetir  = $model->stokgetir($STOKID);
            $uretimid   = @$stokgetir[0][uretimid];
            $tumtanklar = $model->tumstokgetir($uretimid);
            $stoktoplami= $model->stokgetirtoplami($uretimid);
            for ($i=0; $i <$stoktoplami; $i++) { 
                $tanksil = @$tumtanklar[$i][tkid];
                $result  = $model->stoktanksil($tanksil);
                if($result){
                $results  = $model->tanksil($tanksil);
                }
            }
            if($result){     
            echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
            }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
        }
        // Stok Silme Alan Metodu
        public function stokusil(){
            $form       = $this->load->siniflar('form');     
            $model      = $this->load->model("stok_model");       
            $tanksil    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi
            $result     = $model->stoktanksil($tanksil);
            if($result){     
                echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
            }else{
                echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';
            }
        }          
        // Stoktakiler Modeli
        public function stoktakilerlistesi(){
            $form                   = $this->load->siniflar('form');
            $model                  = $this->load->model("stok_model");
            $form                   ->post('length', true);
            $form                   ->post('start', true);
            $form                   ->post('order', true);
            $form                   ->post('search', true);
            $form                   ->post('column', true);
            $form                   ->post('value', true);
            $form                   ->post('draw', true);
            $form                   ->post('dir', true);
            $kolonlar = array( 
                        1   => 'sn',
                        2   => 'depo',
                        3   => 'kategori',
                        5   => 'cap',
                        4   => 'adi',
                        5   => 'tarih',
                        7  => 'miktar',
                        8  => 'islem'
                ); // Kolonlar

            $limit              = $form->values['length'];
            $start              = $form->values['start'];
            $order              = $kolonlar[$form->values['order']['0']['column']];
            $dir                = $form->values['order']['0']['dir'];
            $totalData          = $model->stoktakilersayisi();
            $totalFiltered      = $totalData; 
            if(empty($form->values["search"]["value"]))
            {            
            $kayitlar           = $model->stoktakilerlistesi($limit,$start,$order,$dir);
            }else {
            $search             = $form->values['search']['value']; 
            $kayitlar           = $model->stoktakiler_arama($limit,$start,$search);
            $totalFiltered      = $model->stoktakiler_arama_sayisi($search);
            }
            $data = array();
            if(!empty($kayitlar))
            {   $sn = 0;
                foreach ($kayitlar as $post)
                {
                    $sn++;
                    $matgisData['sn']               = '<label class="bg-primary text-white">'.$sn.'</label>';
                    $matgisData['depo']             = $post['firmaadi'];
                    $matgisData['kategori']         = $post['katadi'];
                    if(!empty($post['cap'])){
                    $matgisData['cap']              = $post['cap'].'/'.$post['litre'].'';
                    }else{
                    $matgisData['cap']              = '';
                    }
                    $matgisData['adi']              = $post['stokadi'];
                    $matgisData['tarih']            = date("d-m-Y H:i:s", strtotime($post['tarih']));
                    $matgisData['miktar']           = '<button class="btn btn-info"><h5>'.(($post['girismiktari']-$post['cikismiktari'])).'</h5> Çıkış Miktarı '.$post['cikismiktari'].'</button>';
                    if(($post['girismiktari']-$post['cikismiktari'])>0){
                    $matgisData['islem']            = '             
                    <div class="btn-group m-b-10">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">İşlem Seç</button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                    <a class="dropdown-item" href="javascript:void(0);" onclick="stokkarti('.$post['skid'].')" data-toggle="modal" data-target=".islemTahsilatYap"><i class="mdi mdi-credit-card "></i> Ürün Kartı</a>
                    <a class="dropdown-item" href="'.SITE_URL.'/stok/stokcikisiyap/&SID='.$post['skid'].'&SM='.($post['girismiktari']-$post['cikismiktari']).'&BNO='.$post['skodu'].'"><i class="mdi mdi-tooltip-edit"></i> Çıkış Yap</a>
                    <a class="dropdown-item" href="'.SITE_URL.'/stok/stokurunleri/&cap='.$post['cap'].'&litre='.$post['litre'].'"><i class="mdi mdi-file"></i> Listele</a>
                    <a class="dropdown-item" href="javascript:void(0);" onclick="stoksil('.$post['skid'].')" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>
                    </div>
                    </div>'; 
                    }else{
                        $matgisData['islem']           = '';
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
          
        // Barkod Listesi Modeli
        public function barkodlistesi(){
            $form                   = $this->load->siniflar('form');
            $model                  = $this->load->model("stok_model");
            $form                   ->post('length', true);
            $form                   ->post('start', true);
            $form                   ->post('order', true);
            $form                   ->post('search', true);
            $form                   ->post('column', true);
            $form                   ->post('value', true);
            $form                   ->post('draw', true);
            $form                   ->post('dir', true);
            $kolonlar = array( 
                        1   => 'sn',
                        2   => 'barkod',
                        7   => 'tarih',
                        9   => 'islem'
                ); // Kolonlar

            $limit              = $form->values['length'];
            $start              = $form->values['start'];
            $order              = $kolonlar[$form->values['order']['0']['column']];
            $dir                = $form->values['order']['0']['dir'];
            $totalData          = $model->barkodlarsayisi();
            $totalFiltered      = $totalData; 
            if(empty($form->values["search"]["value"]))
            {            
            $kayitlar           = $model->barkodlarlistesi($limit,$start,$order,$dir);
            }else {
            $search             = $form->values['search']['value']; 
            $kayitlar           = $model->barkodlar_arama($limit,$start,$search);
            $totalFiltered      = $model->barkodlar_arama_sayisi($search);
            }
            $data = array();
            if(!empty($kayitlar))
            {   $sn = 0;
                foreach ($kayitlar as $post)
                {
                    $sn++;
                    $matgisData['sn']               = '<label class="bg-primary text-white">'.$sn.'</label>';
                    $matgisData['barkod']           = $post['barkodnom'];
                    $matgisData['tarih']            = date("d-m-Y H:i:s", strtotime($post['tarihi']));
                    $matgisData['islem']            = '<a class="btn btn-primary" href="'.SITE_URL.'/stok/toplustokcikisikaydet/&barkodNo='.$post['barkodnom'].'"><i class="mdi mdi-credit-card "></i> Soktan Düşür</a>
                    <a href="javascript:void(0);" onclick="stoksil('.$post['skid'].')" class="btn btn-danger" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>';                      
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

        // Çıkışı Yapılan Ürünler Modeli
        public function cikislarlistesi(){
            $form                   = $this->load->siniflar('form');
            $model                  = $this->load->model("stok_model");
            $form                   ->post('length', true);
            $form                   ->post('start', true);
            $form                   ->post('order', true);
            $form                   ->post('search', true);
            $form                   ->post('column', true);
            $form                   ->post('value', true);
            $form                   ->post('draw', true);
            $form                   ->post('dir', true);
            $kolonlar = array( 
                        1   => 'sn',
                        2   => 'musteri',
                        3   => 'miktar',
                        4   => 'tarih',
                        6   => 'islem'
                ); // Kolonlar

            $limit              = $form->values['length'];
            $start              = $form->values['start'];
            $order              = $kolonlar[$form->values['order']['0']['column']];
            $dir                = $form->values['order']['0']['dir'];
            $totalData          = $model->cikislarsayisi();
            $totalFiltered      = $totalData; 
            if(empty($form->values["search"]["value"]))
            {            
            $kayitlar           = $model->cikislarlistesi($limit,$start,$order,$dir);
            }else {
            $search             = $form->values['search']['value']; 
            $kayitlar           = $model->cikislar_arama($limit,$start,$search);
            $totalFiltered      = $model->cikislar_arama_sayisi($search);
            }
            $data = array();
            if(!empty($kayitlar))
            {   $sn = 0;
                foreach ($kayitlar as $post)
                {
                    $sn++;
                    $matgisData['sn']               = '<label class="bg-primary text-white">'.$sn.'</label>';
                    $matgisData['musteri']          = $post['adi'].' '.$post['soyadi'];
                    $matgisData['miktar']           = '<button class="btn btn-warning"><h5>'.$post['miktari'].'</h5></button>';
                    $matgisData['tarih']            = $post['tarih'];
                    $matgisData['islem']            = '<a class="btn btn-primary" href="'.SITE_URL.'/stok/mustericikislari/&musteriid='.$post['mid'].'"><i class="mdi mdi-file"></i> Listele</a> 
                    <a href="javascript:void(0);" onclick="stokcikisisil('.$post['skcid'].')" class="btn btn-danger" title="İşlemi Sil"><i class="mdi mdi-delete"></i> Sil</a>';                      

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
        // Stok Kaydetme Metodu
        public function stokkaydet(){
            $model          = $this->load->model("stok_model");      
            $form           = $this->load->siniflar('form');
            $form           ->post('tankSec', true);
            $form           ->post('depoSec', true);
            $form           ->post('katSec', true)
                            ->isempty();
            $form           ->post('stokAdi', true);
            $form           ->post('barkodNo', true);
            $form           ->post('tankAdet', true);
            $form           ->post('girisTarihi', true);
            $form           ->post('tankNot', true);
            // Stok Giriş Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
            if(!empty($form->values['girisTarihi'])){
                $datar       = $form->guvenlik(date("Y-m-d", strtotime($form->values['girisTarihi'])));
            }else{
                $datar       = NULL;
            } 
            if(!empty($form->guvenlik($form->values['katSec']))){
                        try{
                            $data = array(
                                'katid'             => $form->guvenlik($form->values['katSec']),
                                'tankid'            => 0,
                                'depoid'            => 1,
                                'stokadi'           => $form->values['stokAdi'],
                                'miktar'            => html_entity_decode($form->values['tankAdet']),
                                'barkodno'          => $form->values['barkodNo'],
                                'stokdurumu'        => 1,
                                'giristarihi'       => $datar,
                                'aciklama'          => $form->guvenlik($form->values['tankNot'])
                            );
                            } catch (PDOException $e) {
                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $result = $model->stokkaydet($data);                    
                            if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kategori alanını boş bırakmayınız.</div>';}                   
        }
        // Stok Çıkışı Kaydetme Metodu
        public function stokcikisikaydet(){
            $model          = $this->load->model("stok_model");      
            $form           = $this->load->siniflar('form');
            $form           ->post('barkodNo', true)
                            ->isempty();
            $form           ->post('cikisAdeti', true)
                            ->isempty();
            $form           ->post('cikisTarihi', true);
            $form           ->post('musteriid', true);
            $form           ->post('cikisNotu', true);
            $form           ->post('stokMiktari', true);
            $form           ->post('teslimEden', true);
            $form           ->post('teslimAlan', true);
            // Stok Giriş Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
            if(!empty($form->values['cikisTarihi'])){
                $datar       = $form->guvenlik(date("Y-m-d", strtotime($form->values['cikisTarihi'])));
            }else{
                $datar       = NULL;
            } 
            if(($form->values['cikisAdeti'])){
                if(!empty($form->guvenlik($form->values['barkodNo']))){
                    if(!empty($form->guvenlik($form->values['cikisAdeti']))){
                        try{
                            $data = array(
                                'barkodno'          => $form->guvenlik($form->values['barkodNo']),
                                'musteriid'         => $form->guvenlik($form->values['musteriid']),
                                'miktari'           => html_entity_decode($form->values['cikisAdeti']),
                                'cikistarihi'       => $datar,
                                'aciklamasi'        => $form->guvenlik($form->values['cikisNotu']),
                                'teslimEden'        => $form->guvenlik($form->values['teslimEden']),
                                'teslimAlan'        => $form->guvenlik($form->values['teslimAlan'])
                            );
                            } catch (PDOException $e) {
                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $result = $model->stokcikisikaydet($data);                    
                            if($result){ echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Barkod Numaraası alanını boş bırakmayınız.</div>';}     
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Tank alanını boş bırakmayınız.</div>';}                   
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Çıkış adeti stok adetinden fazla olamaz.</div>';}                   
    }    
        // Stok Çıkışı Kaydetme Metodu
        public function toplustokcikisikaydet(){
            $model          = $this->load->model("stok_model");      
            $form           = $this->load->siniflar('form');
            $barkodno       = $_REQUEST['barkodNo'];
            $barkodlar      = $model->barkodlarigetir($barkodno);
            $stoksayisi     = $model->stoklarigetir($barkodno);
                        try{
                            $data = array(
                                'barkodno'          => $barkodno,
                                'miktari'           => $barkodlar,
                                'cikistarihi'       => date("Y-m-d H:i:s"),
                                'aciklamasi'        => $barkodno.' Barkod Numaralı ürün stoktan düşürüldü.'
                            );
                            } catch (PDOException $e) {
                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $result = $model->stokcikisikaydet($data);                    
                            if($result){ 
                                try{
                                    $data = array(
                                        'bdurumu'           => 1
                                    );
                                } catch (PDOException $e) {
                                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                                    }
                                    $result = $model->okunanbarkoddus($data,$barkodno);                                  
                                echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
    }           
}