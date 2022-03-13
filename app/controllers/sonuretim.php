<?php
/*
* MATGIS TETS
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class uretim extends controller {

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
// Aktarılamayanlar
    // Bir Sonraki İstasyona Aktarılamayan Saç veya Tanklarlar
    public function aktarilamayan(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $umodel                           = $this->load->model("uretim_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $this->load->view("ustAlan", $yoneticilogu);
                $this->load->view("uretim/aktarilamayan", $yoneticilogu);
                $this->load->view("solAlan", $yoneticilogu);
                $this->load->view("altAlan", $yoneticilogu);
        }    
// Aktarılmayanlar Modeli
public function aktarilmayanlistesi(){
    $form                   = $this->load->siniflar('form');
    $model                  = $this->load->model("uretim_model");
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
                2   => 'turu',
                3   => 'istasyon',
                4   => 'sac',
                5   => 'durum',
                6   => 'islem'
        ); // Kolonlar

    $limit              = $form->values['length'];
    $start              = $form->values['start'];
    $order              = $kolonlar[$form->values['order']['0']['column']];
    $dir                = $form->values['order']['0']['dir'];
    $totalData          = $model->aktarilmayansayisi();
    $totalFiltered      = $totalData; 
    if(empty($form->values["search"]["value"]))
    {            
    $kayitlar           = $model->aktarilmayanlistesi($limit,$start,$order,$dir);
    }else {
    $search             = $form->values['search']['value']; 
    $kayitlar           = $model->aktarilmayan_arama($limit,$start,$search);
    $totalFiltered      = $model->aktarilmayan_arama_sayisi($search);
    }
    $data = array();
    if(!empty($kayitlar))
    {   $sn = 0;
        foreach ($kayitlar as $post)
        {
            $sn++;
            $matgisData['sn']               = '<label class="bg-primary text-white">'.$sn.'</label>';
            if($post['turu']=="govde"){
            $matgisData['turu']             = 'Gövde';
            }else{
            $matgisData['turu']             = 'Kapak';
            }
            $matgisData['istasyon']         = $post['istasyonadi'];
            $matgisData['sac']              = $post['stokkodu'].$post['serino'];
            if($post['onaydurum']==1){
            $matgisData['durum']            = '<label class="bg-success">1</label>';
            }else{
            $matgisData['durum']            = '<label class="bg-danger">0</label>';
            }            
            $matgisData['islem']            = "<a href='".SITE_URL."/seri/islemigerial/&id=".$post['btid']."'>Geri Al</a>";
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
   
// Üretim Alanı
    // Mal Kabul Listesi    
        public function kabullist(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $umodel                           = $this->load->model("uretim_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $src                              = $form->guvenlik($_REQUEST['src']);
                $data["kabullist"]                = $umodel->kabullist($src);
                $this->load->view("uretim/kabullist", $data);
        }
    // Seri No Listesi    
        public function serilist(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $umodel                           = $this->load->model("uretim_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $src                              = $form->guvenlik($_REQUEST['src']);
                $data["serilist"]                 = $umodel->serilist($src);
                $this->load->view("uretim/serilist", $data);
        }
    // Cari Listesi    
        public function carilist(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $umodel                           = $this->load->model("uretim_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $src                              = $form->guvenlik($_REQUEST['src']);
                $data["carilist"]                 = $umodel->carilist($src);
                $this->load->view("uretim/carilist", $data);
        }
    // Üretilecekler
        public function uretilecekler(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $umodel                           = $this->load->model("uretim_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $yoneticilogu["istasyonlar"]      = $umodel->istasyonlar();
                $this->load->view("ustAlan", $yoneticilogu);
                $this->load->view("uretim/uretilecekler", $yoneticilogu);
                $this->load->view("solAlan", $yoneticilogu);
                $this->load->view("altAlan", $yoneticilogu);
        }
    // Üretimdekiler
        public function uretimdekiler(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $this->load->view("ustAlan", $yoneticilogu);
                $this->load->view("uretim/uretimdekiler", $yoneticilogu);
                $this->load->view("solAlan", $yoneticilogu);
                $this->load->view("altAlan", $yoneticilogu);
        }
    // Planlama gönderilmek üzere hazırlanan mal stok ürünün hazırlanması
        public function planlama(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $kabul_model                      = $this->load->model("kabul_model");
            $seri_model                       = $this->load->model("seri_model");
            $cari_model                       = $this->load->model("cari_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["malstoklistesi"]   = $kabul_model->malstoklistesi(); // Mal kabul stoğunda işlenmemiş ham madde
            $yoneticilogu["malkabullistesi"]  = $kabul_model->malkabullistesi(); // Mal kabul stoğunda işlenmemiş ham madde            
            $yoneticilogu["malkesimmenulist"] = $kabul_model->malkesimmenulist(); // Mal kabul stoğunda işlenmemiş ham madde            
            $yoneticilogu["malkesimmenulistson"] = $kabul_model->malkesimmenulistson(); // Mal kabul stoğunda işlenmemiş ham madde            
            $yoneticilogu["tumcariler"]       = $cari_model->tumcariler(); // Üretim yapılacak cariler listesi
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("uretim/planlama", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
    // Kesimhaneye gönderilmek üzere hazırlanan mal stok ürünün hazırlanması
        public function kesim(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $kabul_model                      = $this->load->model("kabul_model");
                $seri_model                       = $this->load->model("seri_model");
                $cari_model                       = $this->load->model("cari_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $yoneticilogu["malstoklistesi"]   = $kabul_model->malstoklistesi(); // Mal kabul stoğunda işlenmemiş ham madde
                $yoneticilogu["tumseriler"]       = $seri_model->tumseriler(); // Üretim yapılacak ürüne ait seri no ve gövde ile kapak ölçüleri
                $yoneticilogu["tumcariler"]       = $cari_model->tumcariler(); // Üretim yapılacak cariler listesi
                $this->load->view("ustAlan", $yoneticilogu);
                $this->load->view("uretim/kesim", $yoneticilogu);
                $this->load->view("solAlan", $yoneticilogu);
                $this->load->view("altAlan", $yoneticilogu);
        }
    // Üretilenler
        public function uretilenler(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $tmodel                           = $this->load->model("tanim_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["raflar"]           = $tmodel->raflar();
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("uretim/uretilenler", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }   
    // Hatalılar
        public function hatalilar(){
                $form                             = $this->load->siniflar('form');
                $index_model                      = $this->load->model("index_model");
                $ID                               = $form->guvenlik($_REQUEST['ID']);
                $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
                $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
                $this->load->view("ustAlan", $yoneticilogu);
                $this->load->view("uretim/hatalilar", $yoneticilogu);
                $this->load->view("solAlan", $yoneticilogu);
                $this->load->view("altAlan", $yoneticilogu);
        }   
    // Üretimdekiler Modeli
        public function uretimdekilerlistesi(){
                $form                   = $this->load->siniflar('form');
                $model                  = $this->load->model("uretim_model");
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
                            2   => 'turu',
                            3   => 'skodu',
                            4   => 'cap',
                            5   => 'litre',
                            6   => 'eni',
                            7   => 'boyu',
                            10  => 'sorumlu',
                            11  => 'ist',
                            12  => 'toplam',
                            13  => 'firma',
                            14  => 'durum'
                    ); // Kolonlar

                $limit              = $form->values['length'];
                $start              = $form->values['start'];
                $order              = $kolonlar[$form->values['order']['0']['column']];
                $dir                = $form->values['order']['0']['dir'];
                $totalData          = $model->uretimdekilersayisi();
                $totalFiltered      = $totalData; 
                if(empty($form->values["search"]["value"]))
                {            
                $kayitlar           = $model->uretimdekilerlistesi($limit,$start,$order,$dir);
                }else {
                $search             = $form->values['search']['value']; 
                $kayitlar           = $model->uretimdekiler_arama($limit,$start,$search);
                $totalFiltered      = $model->uretimdekiler_arama_sayisi($search);
                }
                $data = array();
                if(!empty($kayitlar))
                {   $sn = 0;
                    foreach ($kayitlar as $post)
                    {
                        $sn++;
                        $matgisData['sn']               = '<label class="bg-primary text-white">'.$sn.'</label>';
                        if($post['turu']=="govde"){
                        $matgisData['turu']             = 'Gövde';
                        }else{
                        $matgisData['turu']             = 'Kapak';
                        }
                        $matgisData['skodu']            = $post['stokkodu'];
                        $matgisData['cap']              = '<strong>'.$post['cap'].'</strong>';
                        $matgisData['litre']            = '<strong>'.$post['litre'].'</strong>';
                        $matgisData['eni']              = $post['stokeni'];
                        $matgisData['boyu']             = $post['stokboyu'];
                        $matgisData['sorumlu']          = $post['adi'].' '.$post['soyadi'];
                        $matgisData['ist']              = $post['istasyonadi'];
                        $matgisData['toplam']           = "<label class='btn btn-warning'>".$post['toplam']."</label>";
                        $matgisData['firma']            = $post['firmaadi'];
                        if($post['udurumu']==1){
                        $matgisData['durum']            = "<button class='btn btn-info'>Üretiliyor</button>";
                        }else{ 
                        $matgisData['durum']            = '';
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
    // Üretilenler Modeli
        public function uretilenlerlistesi(){
                $form                   = $this->load->siniflar('form');
                $model                  = $this->load->model("uretim_model");
                $form                   ->post('length', true);
                $form                   ->post('start', true);
                $form                   ->post('order', true);
                $form                   ->post('search', true);
                $form                   ->post('column', true);
                $form                   ->post('value', true);
                $form                   ->post('draw', true);
                $form                   ->post('dir', true);
                $kolonlar = array( 
                            0   => 'c',
                            1   => 'sn',
                            2   => 'bno',
                            3   => 'cap',
                            4   => 'firma',
                            5   => 'durum'
                    ); // Kolonlar

                $limit              = $form->values['length'];
                $start              = $form->values['start'];
                $order              = $kolonlar[$form->values['order']['0']['column']];
                $dir                = $form->values['order']['0']['dir'];
                $totalData          = $model->uretilenlersayisi();
                $totalFiltered      = $totalData; 
                if(empty($form->values["search"]["value"]))
                {            
                $kayitlar           = $model->uretilenlerlistesi($limit,$start,$order,$dir);
                }else {
                $search             = $form->values['search']['value']; 
                $kayitlar           = $model->uretilenler_arama($limit,$start,$search);
                $totalFiltered      = $model->uretilenler_arama_sayisi($search);
                }
                $data = array();
                if(!empty($kayitlar))
                {   $sn = 0;
                    foreach ($kayitlar as $post)
                    {
                        $sn++;
                        if(session::get('AdminID')==4){
                            $matgisData['c']            = '';    
                        }else{
                            $matgisData['c']            = '<a href="javascript:void(0);" onclick="stokAktar('.$post['uretimid'].')" class="dropdown-item"><label class="bg-warning text-white">STOK AKTAR</label></a>';
                        }                        
                        $matgisData['sn']               = '<label class="bg-primary text-white">'.$post['SeriNom'].'</label>';
                        $matgisData['bno']              = $post['barkodno'];
                        $matgisData['cap']              = $post['cap']."X".$post['litre'];
                        $matgisData['firma']            = $post['firmaadi'];
                        if($post['uretimdurumu']==2){
                        if(session::get('AdminID')==4){
                            $matgisData['durum']        = '<a class="dropdown-item" href="'.SITE_URL.'/uretim/etiketyazdir/&id='.$post['tkid'].'"><label class="bg-info text-white">YAZDIR</label></a>';    
                        }else{
                            $matgisData['durum']        = '<a href="javascript:void(0);" onclick="tankSil('.$post['tkid'].')" title="İşlemi Sil" class="btn btn-danger"><i class="mdi mdi-delete"></i> Sil</a>
                                                           <a  class="btn btn-info" href="'.SITE_URL.'/uretim/etiketyazdir/&id='.$post['tkid'].'"><label class="bg-info">YAZDIR</label></a>';
                        }
                        }else{ 
                            $matgisData['durum']        = '';
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
    // Hatalı Üretimler Modeli
        public function hatalilarlistesi(){
                $form                   = $this->load->siniflar('form');
                $model                  = $this->load->model("uretim_model");
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
                            2   => 'cap',
                            3   => 'yuksek',
                            4   => 'litre',
                            5   => 'kg',
                            6   => 'turu',
                            7   => 'tarih',
                            8   => 'durum'
                    ); // Kolonlar

                $limit              = $form->values['length'];
                $start              = $form->values['start'];
                $order              = $kolonlar[$form->values['order']['0']['column']];
                $dir                = $form->values['order']['0']['dir'];
                $totalData          = $model->hatalilarsayisi();
                $totalFiltered      = $totalData; 
                if(empty($form->values["search"]["value"]))
                {            
                $kayitlar           = $model->hatalilarlistesi($limit,$start,$order,$dir);
                }else {
                $search             = $form->values['search']['value']; 
                $kayitlar           = $model->hatalilar_arama($limit,$start,$search);
                $totalFiltered      = $model->hatalilar_arama_sayisi($search);
                }
                $data = array();
                if(!empty($kayitlar))
                {   $sn = 0;
                    foreach ($kayitlar as $post)
                    {
                        $sn++;
                        $matgisData['sn']               = '<label class="bg-primary text-white">'.$post['serino']."".str_pad($post['tkid'],5,0,STR_PAD_LEFT).'</label>';
                        $matgisData['cap']              = $post['cap'];
                        $matgisData['yuksek']           = $post['yukseklik'];
                        $matgisData['litre']            = $post['litre'];
                        $matgisData['kg']               = $post['kg'];
                        $matgisData['tur']              = $post['turadi'];
                        $matgisData['tarih']            = date("d-m-Y H:i:s", strtotime($post['tarih']));
                        $matgisData['durum']            = '<button class="btn btn-danger">Hatalı Üretim</button>';
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
    // Üretimi Kaydetme Metodu
        public function uretimikaydet(){
                $model          = $this->load->model("uretim_model");        
                $form           = $this->load->siniflar('form');
                $form           ->post('malAdet', true)
                                ->isempty();
                $form           ->post('malKabul', true)
                                ->isempty();
                $form           ->post('malSeri', true)
                                ->isempty();
                $form           ->post('malKabulOlcu', true)
                                ->isempty();
                $form           ->post('malCari', true)
                                ->isempty();
                $form           ->post('malAciklama', true);
                $form           ->post('enfire', true);
                $form           ->post('boyfire', true);
                $form           ->post('feni', true);
                $form           ->post('fboyu', true);
                $form           ->post('fkalinlik', true);
                $form           ->post('fkutle', true);
                $form           ->post('fadet', true);
                $seriid         = $form->values['malSeri'];
                $uadeti         = $form->values['malAdet'];
                if(!empty($form->guvenlik($form->values['malAdet']))){
                    if(!empty($form->guvenlik($form->values['malKabul']))){                  
                        if(!empty($form->guvenlik($form->values['malSeri']))){                  
                            if(!empty($form->guvenlik($form->values['malKabulOlcu']))){                  
                                if(!empty($form->guvenlik($form->values['malCari']))){                  
                                    try{
                                        $data = array(
                                            'malstokid'             => $form->guvenlik($form->values['malKabul']),
                                            'musteriid'             => $form->guvenlik($form->values['malCari']),
                                            'seriid'                => html_entity_decode($form->values['malSeri']),
                                            'miktar'                => html_entity_decode($form->values['malAdet']),
                                            'aciklama'              => html_entity_decode($form->values['malAciklama']),
                                            'utarihi'               => date("Y-m-d H:i:s"),
                                            'turu'                  => html_entity_decode($form->values['malKabulOlcu'])                        
                                        );
                                    } catch (PDOException $e) {
                                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                                    }
                                    $result         = $model->uretimikaydet($data);
                                    if($result){ 
                                        $sonkayit   = $model->sonuretimkaydi();
                                        try{
                                            $dataf   = array(
                                                'uretimid'              => @$sonkayit[0][uid],
                                                'seriid'                => html_entity_decode($form->values['malSeri']),
                                                'fireni'                => html_entity_decode($form->values['enfire']),
                                                'fireboyu'              => html_entity_decode($form->values['boyfire']),
                                                'fadeti'                => html_entity_decode($form->values['fadet']),
                                                'furetilenadet'         => html_entity_decode($form->values['malAdet']),
                                                'feni'                  => html_entity_decode($form->values['feni']),
                                                'fboyu'                 => html_entity_decode($form->values['fboyu']),
                                                'kalinlik'              => html_entity_decode($form->values['fkalinlik']),
                                                'kutle'                 => html_entity_decode($form->values['fkutle'])                        
                                            );
                                        } catch (PDOException $e) {
                                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                                        }
                                        $resultu    = $model->uretimfirekaydet($dataf);
                                        $tankigetir = $model->sontankigetir();
                                        if(!empty($tankigetir)){
                                            $tanksirano = @$tankigetir[0][sirano];
                                        }elseif(empty($tankigetir)){ 
                                            $tanksirano = 0;
                                        }
                                        $serigetir  = $model->serinogetir($seriid);
                                        for ($tanksirano; $i <= $uadeti; $i++) {
                                            try{
                                                $datat   = array(
                                                    'uretimid'              => @$sonkayit[0][uid],
                                                    'serino'                => @$serigetir[0][serino].str_pad($i,6,0,STR_PAD_LEFT),
                                                    'sirano'                => @$i,
                                                    'uretimdurumu'          => 0,
                                                    'uretimesevk'           => 0                      
                                                );
                                            } catch (PDOException $e) {
                                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                                            }
                                            $resultu    = $model->uretimtankikaydet($datat);
                                        }
                                        echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!...Kabul Gerçekleşti. Diğer adıma geçiş yapacaksınız.')</script>";
                                        header('Refresh: 0; url= '.SITE_URL.'/uretim/uretilecekler/&ID=25');                        
                                    }else{
                                        echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Kabul Gerçekleşmedi.')</script>";
                                        header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
                                    }
                                }else{ echo  @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Cari Seçiniz.')</script>";}     
                            }else{ echo  @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Kapak mı Gövde mi ?.')</script>";}     
                        }else{ echo  @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Seri Seçiniz.')</script>";}     
                    }else{ echo  @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Mal Kabul Seçiniz.')</script>";}     
                }else{ echo  @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Adet Giriniz.')</script>";}     
        }
    // Üretime Sevk Et Metodu
        public function istasyonasevket(){
                $model          = $this->load->model("uretim_model");        
                $form           = $this->load->siniflar('form');
                $form           ->post('istasyonSec', true)
                                ->isempty();
                $form           ->post('sevkDurumu', true);        
                $form           ->post('stokid', true); 
                $form           ->post('stokustid', true); 
                $form           ->post('sevkAdet', true); 
                $tankid         = $form->values['stokid'];
                $istasyonid     = $form->values['istasyonSec'];
                $persgetir      = $model->personelgetir($istasyonid);    
                $stoksacgetir   = $model->stoksacgetir($tankid);
                if($form->values['sevkDurumu']==1){
                    try{
                    $data = array(
                            'persid'            => @$persgetir[0][persid],
                            'istasyonid'        => $form->values['istasyonSec'],  
                            'sacustid'          => @$stoksacgetir[0][spid], // Stok id
                            'sacid'             => $form->values['stokid'], // Stok id
                            'tankid'            => 0,                  
                            'islemdurumu'       => 1,                      
                            'onaydurum'         => 0                      
                    );
                    } catch (PDOException $e) {
                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                    }
                    $result         = $model->istasyonasevket($data);
                    if($result){ 
                        try{
                        $data = array(
                            'udurumu'       => $form->values['sevkDurumu']                       
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $results        = $model->uretimetanksevket($data,$tankid);                    
                        echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!..Üretime gönderildi.')</script>";
                        header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
                    }else{
                        echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Üretime Gönderilmedi.')</script>";
                        header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
                    }                 
                }else if($form->values['sevkDurumu']==2){
                    $sn=0;
                    for ($i=0; $i<$form->values['sevkAdet']; $i++) {
                        $sn++;
                        $stokid = @$stoksacgetir[$i][spsid];
                        $stokuid = @$stoksacgetir[$i][spid];
                    try{
                        $data = array(
                                'persid'            => @$persgetir[0][persid],
                                'istasyonid'        => $form->values['istasyonSec'],                       
                                'sacid'             => $stokid,
                                'sacustid'          => $stokuid,
                                'tankid'            => 0,
                                'islemdurumu'       => 1,                      
                                'onaydurum'         => 0                      
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $result         = $model->istasyonasevket($data);
                        if($result){ 
                            try{
                            $data = array(
                                'uretimesevk'   => 1,
                                'udurumu'       => 1                       
                            );
                            } catch (PDOException $e) {
                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $results        = $model->uretimesevket($data,$stokid); 
                            if($sn==1){                   
                            echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!..Üretime gönderildi.')</script>";
                            header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');
                            }else{ echo "";}                
                        }else{
                            echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Üretime Gönderilmedi.')</script>";
                            header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
                        }                    
                    }
                }

        }            
    // Üretilecekler Modeli
        public function uretileceklerlistesi(){
                $form                   = $this->load->siniflar('form');
                $model                  = $this->load->model("uretim_model");
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
                            2   => 'turu',
                            3   => 'bno',
                            6   => 'eni',
                            7   => 'boyu',
                            9   => 'kg',
                            10  => 'sorumlu',
                            11  => 'plaka',
                            12  => 'firma',
                            13  => 'islem'
                    ); // Kolonlar

                $limit              = $form->values['length'];
                $start              = $form->values['start'];
                $order              = $kolonlar[$form->values['order']['0']['column']];
                $dir                = $form->values['order']['0']['dir'];
                $totalData          = $model->uretileceklersayisi();
                $totalFiltered      = $totalData; 
                if(empty($form->values["search"]["value"]))
                {            
                $kayitlar           = $model->uretileceklerlistesi($limit,$start,$order,$dir);
                }else {
                $search             = $form->values['search']['value']; 
                $kayitlar           = $model->uretilecekler_arama($limit,$start,$search);
                $totalFiltered      = $model->uretilecekler_arama_sayisi($search);
                }
                $data = array();
                if(!empty($kayitlar))
                {   $sn = 0;
                    foreach ($kayitlar as $post)
                    {
                        $sn++;
                        $matgisData['sn']               = '<label class="bg-primary text-white">'.$post['SeriNom'].'</label>';
                        if($post['turu']=="govde"){
                        $matgisData['turu']             = 'Gövde';
                        }else{
                        $matgisData['turu']             = 'Kapak';
                        }
                        $matgisData['bno']              = $post['barkodno'];
                        if($post['turu']=="govde"){
                        $matgisData['eni']              = $post['g1'];
                        $matgisData['boyu']             = $post['g2'];
                        }else{
                        $matgisData['eni']              = $post['k1'];
                        $matgisData['boyu']             = $post['k2'];
                        }
                        $matgisData['kg']               = $post['kg'];
                        $matgisData['sorumlu']          = $post['sorumlusu'];
                        $matgisData['plaka']            = $post['plaka'];
                        $matgisData['firma']            = $post['firmaadi'];
                        if($post['uretimesevk']==0){
                        $matgisData['durum']            = '<a class="dropdown-item" href="javascript:void(0);" onclick="sevkEt('.$post['tkid'].')" data-toggle="modal" data-target=".sevkEt"><label class="bg-primary text-white">Sevk Et</label></a>';
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
    // Tank  Getirme Modeli
        public function tankgetir(){
        $form                             = $this->load->siniflar('form');
        $uretim_model                     = $this->load->model("uretim_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $uretim_model->tankgetir($KAYITID);
        echo json_encode($data);
        }     
    // Tank  Getirme Modeli
        public function sacplanstokgetir(){
        $form                             = $this->load->siniflar('form');
        $uretim_model                     = $this->load->model("uretim_model");
        $form                             ->post('id', true)
                                          ->isempty();
        $KAYITID                          = $form->guvenlik($_REQUEST['id']);
        $data                             = array();
        $data                             = $uretim_model->sacplanstokgetir($KAYITID);
        echo json_encode($data);
        }               
    // Stok Kaydetme Metodu
        public function stokkaydet(){
            $model          = $this->load->model("stok_model");      
            $umodel         = $this->load->model("uretim_model");      
            $form           = $this->load->siniflar('form');
            $form           ->post('tankid', true);
            $form           ->post('sevkDurumu', true);
            $form           ->post('depoSec', true)
                            ->isempty();
            $tankid         = $form->guvenlik($form->values['tankid']);
            $tankgetir      = $umodel->uretilentanklar($tankid);
            $sadi           = @$tankgetir[0][SeriNom];
            $bno            = @$tankgetir[0][barkodno];

            if(!empty($form->guvenlik($form->values['tankid']))){
                if(!empty($form->guvenlik($form->values['depoSec']))){
                        try{
                            $data = array(
                                'katid'             => 1,
                                'tankid'            => $tankid,
                                'depoid'            => $form->guvenlik($form->values['depoSec']),
                                'stokadi'           => $sadi,
                                'miktar'            => 1,
                                'barkodno'          => $bno,
                                'stokdurumu'        => 1,
                                'giristarihi'       => date("Y-m-d")
                            );
                            } catch (PDOException $e) {
                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $result = $model->stokkaydet($data);                    
                            if($result){ 
                                try{
                                    $data = array(
                                        'uretimdurumu'       => 4                       
                                    );
                                    } catch (PDOException $e) {
                                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                                    }
                                    $results        = $umodel->uretimetanksevket($data,$tankid);                                  
                                echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
                }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Depo alanını boş bırakmayınız.</div>';}     
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kategori alanını boş bırakmayınız.</div>';}                   
        }
    // Planlama Kaydetme Metodu
        public function planlamakaydet(){
        $umodel         = $this->load->model("uretim_model");      
        $form           = $this->load->siniflar('form');
        $form           ->post('enimh', true);
        $form           ->post('boyumh', true);
        $form           ->post('adetimh', true);
        $form           ->post('eni', true);
        $form           ->post('boyu', true);
        $form           ->post('stokkodu', true);
        $form           ->post('kalinlik', true);
        $form           ->post('adet', true);
        $form           ->post('kesilenadet', true);
        $form           ->post('malkabulid', true);
        $form           ->post('bolumsayisi', true);
        $form           ->post('olcuturu', true);
        $form           ->post('enfire', true);
        $form           ->post('tankID', true);
        $form           ->post('plakaolcusu', true);
        $form           ->post('aciklama', true);
        $form           ->post('kesimturu', true);
        $form           ->post('bolmesayisi', true);
        $form           ->post('kullanilanadet', true);
        $form           ->post('firma', true);
        $form           ->post('planmenuid', true);
        $kullanilanadet  = ceil($form->values['adetimh']/$form->values['bolmesayisi']);
        if(!empty($form->guvenlik($form->values['eni']))){
            if(!empty($form->guvenlik($form->values['boyu']))){
                    try{
                        $data = array(
                            'malbilid'          => $form->guvenlik($form->values['malkabulid']),
                            'planmenuid'        => $form->guvenlik($form->values['planmenuid']),
                            'seriid'            => $form->guvenlik($form->values['tankID']),
                            'kesimturu'         => $form->guvenlik($form->values['kesimturu']),
                            'sackodu'           => $form->guvenlik($form->values['stokkodu']),
                            'sacen'             => $form->guvenlik($form->values['eni']),
                            'sacboy'            => $form->guvenlik($form->values['boyu']),
                            'sacadet'           => $form->guvenlik($form->values['adetimh']),
                            'kullanilanadet'    => $kullanilanadet,
                            'enfire'            => $form->guvenlik($form->values['enfire']),
                            'aciklama'          => $form->guvenlik($form->values['aciklama']),
                            'kullanimtarihi'    => date("Y-m-d H:i:s")
                        );
                    } catch (PDOException $e) {
                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                    }
                    $result = $umodel->planlamakaydet($data);                 
                    if($result){
                        $sonplanlama = $umodel->sonplanlama();
                        try{
                            $data = array(
                                'malstokid'             => $form->guvenlik($form->values['malkabulid']),
                                'musteriid'             => $form->guvenlik($form->values['firma']),
                                'seriid'                => html_entity_decode($form->values['tankID']),
                                'miktar'                => html_entity_decode($form->values['adetimh']),
                                'aciklama'              => html_entity_decode($form->values['stokkodu']).$form->guvenlik($form->values['aciklama']),
                                'utarihi'               => date("Y-m-d H:i:s"),
                                'turu'                  => html_entity_decode($form->values['kesimturu'])                        
                            );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $resultx         = $umodel->uretimikaydet($data);                        
                        for ($i=1; $i <=$form->values['adetimh']; $i++) { 
                            try{
                                $data = array(
                                    'spid'                  => @$sonplanlama[0][mukid],
                                    'stokeni'               => $form->guvenlik($form->values['enimh']),
                                    'stokboyu'              => $form->guvenlik($form->values['boyumh']),
                                    'stokadeti'             => $form->guvenlik($form->values['adetimh']),
                                    'stokkodu'              => $form->guvenlik($form->values['stokkodu'].'/'.$i),
                                    'stoktarihi'            => date("Y-m-d H:i:s")                                    
                                );
                            } catch (PDOException $e) {
                                die('Baglanti Kurulamadi : ' . $e->getMessage());
                            }
                            $resultx = $umodel->planlamastokkaydet($data); 
                        }    
                        echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert(<strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.)</script>";
                        header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                                                                                     
                    }else{
                        echo @str_repeat("<br>", 8)."<script type='text/javascript'>alert(<strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.)</script>";
                        header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Saç Boyu Seçiniz.</div>';}     
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Saç Eni Seçiniz.</div>';}                   
        }  
    // Planlama Ön Kayıt
        public function planlamamenukaydet(){
        $umodel         = $this->load->model("uretim_model");      
        $kmodel         = $this->load->model("kabul_model");      
        $form           = $this->load->siniflar('form');
        $form           ->post('enimh', true);
        $form           ->post('boyumh', true);
        $form           ->post('adetimhs', true);
        $form           ->post('malkabulid', true);
        $form           ->post('kalinlik', true);
        $form           ->post('stokkodu', true);
        $form           ->post('menuaciklama', true);
        $form           ->post('bolumsayisi', true);
        $bsayisi        = $form->guvenlik($form->values['bolumsayisi']);
                $sn = 0;
                for ($i=0; $i <$bsayisi; $i++) {
                    $sn++;
                    if($sn==1){
                        $menustoksayisi = $form->guvenlik($form->values['adetimhs'][0]);
                    }else if($sn==2){
                        $menustoksayisi = $form->guvenlik($form->values['adetimhs'][$sn]);
                    }else if($sn==3){
                        $menustoksayisi = $form->guvenlik($form->values['adetimhs'][$sn]);
                    }else if($sn==4){
                        $menustoksayisi = $form->guvenlik($form->values['adetimhs'][$sn]);
                    }else{
                        $menustoksayisi = 0;
                    }
                    $malkessonid  = $kmodel->malkesimmenulistson();
                    if(empty($malkessonid)){
                        $t = 1+$i;
                    }else{
                        $t = @$malkessonid[0][pmid]+$i+1;
                    }
                    try{
                        $data = array(
                            'malkabulid'        => $form->guvenlik($form->values['malkabulid']),
                            'menuen'            => $form->guvenlik($form->values['enimh'][$i]),
                            'menuboy'           => $form->guvenlik($form->values['boyumh'][$i]),
                            'menuadet'          => $form->guvenlik($form->values['adetimhs'][$i]),
                            'menustokkodu'      => $form->guvenlik($form->values['stokkodu'].'/'.$t),
                            'menukalinlik'      => $form->guvenlik($form->values['kalinlik']),
                            'menustokdus'       => $menustoksayisi,
                            'menukayittarih'    => date("Y-m-d H:i:s")
                        );
                    } catch (PDOException $e) {
                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                    }
                    $result = $umodel->planlamamenukaydet($data);   
                }              
                if($result){                                                              
                    echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert(<strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.)</script>";
                    header('Refresh: 2; url= '.$_SERVER['HTTP_REFERER'].'');    
                }else{ 
                    echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert(<strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.)</script>";
                    header('Refresh: 2; url= '.$_SERVER['HTTP_REFERER'].'');                        
                }                

        }   
    // Tank Listesi    
        public function tanklist(){
            $pmodel                     = $this->load->model("seri_model");
            $form                       = $this->load->siniflar('form');
            $lng                        = $form->guvenlik($_REQUEST['lng']);
            $data["tanklist"]           = $pmodel->tanklist($lng);
            $this->load->view("uretim/tanklist", $data);
        }   
    // Üretime Hazır
        public function uretimehazir(){
            $form                             = $this->load->siniflar('form');
            $index_model                      = $this->load->model("index_model");
            $umodel                           = $this->load->model("uretim_model");
            $ID                               = $form->guvenlik($_REQUEST['ID']);
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["istasyonlar"]      = $umodel->istasyonlar();
            $this->load->view("ustAlan", $yoneticilogu);
            $this->load->view("uretim/uretimehazir", $yoneticilogu);
            $this->load->view("solAlan", $yoneticilogu);
            $this->load->view("altAlan", $yoneticilogu);
        }
    // Üretime Hazır Modeli
    public function uretimehazirlistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("uretim_model");
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
                    2   => 'ist',
                    3   => 'cap',
                    4   => 'firma',
                    5   => 'islem',
                    6   => 'itar'
            ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->uretimehazirsayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->uretimehazirlistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->uretimehazir_arama($limit,$start,$search);
        $totalFiltered      = $model->uretimehazir_arama_sayisi($search);
        }
        $data = array();
        if(!empty($kayitlar))
        {   $sn = 0;
            foreach ($kayitlar as $post)
            {
                $sn++;
                $matgisData['sn']               = '<label class="bg-primary text-white">'.$post['SeriNom'].'</label>';
                $matgisData['ist']              = $post['istasyonadi'];
                $matgisData['cap']              = $post['cap']."X".$post['litre'];
                $matgisData['firma']            = $post['firmaadi'];
                if($post['uretimdurumu']==1){
                $matgisData['durum']            = "<button class='btn btn-info'>Üretiliyor</button>";
                }else{ 
                $matgisData['durum']            = '';
                }
                $matgisData['itar']             = date("d-m-Y", strtotime($post['tarih']));
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
    // Etiket Yazdırmayı gönderilmek üzere hazırlanan mal stok ürünün hazırlanması
        public function etiketyazdir(){
            $form                             = $this->load->siniflar('form');
            $model                            = $this->load->model("stok_model");      
            $index_model                      = $this->load->model("index_model");
            $umodel                           = $this->load->model("uretim_model");
            $etiketid                         = $_REQUEST['id'];
            $tankid                           = $etiketid;
            $ID                               = $etiketid;
            $depoSec                          = 1;
            $tankgetir                        = $umodel->uretilentanklar($tankid);
            $sadi                             = @$tankgetir[0][SeriNom];
            $bno                              = @$tankgetir[0][barkodno];         
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["etiketyazdir"]     = $umodel->etiketyazdir($etiketid); // Mal kabul stoğunda işlenmemiş ham madde
            $this->load->view("uretim/etiketyazdir", $yoneticilogu);
        }
    // Etiket Yazdırmayı gönderilmek üzere hazırlanan mal stok ürünün hazırlanması
        public function stokaktarimiyap(){
            $form                             = $this->load->siniflar('form');
            $model                            = $this->load->model("stok_model");      
            $index_model                      = $this->load->model("index_model");
            $umodel                           = $this->load->model("uretim_model");
            $etiketid                         = $_REQUEST['id'];
            $tankid                           = $etiketid;
            $ID                               = $etiketid;
            $depoSec                          = 1;
            $tankgetir                        = $umodel->uretilentanklar($tankid);
            $sadi                             = @$tankgetir[0][SeriNom];
            $bno                              = @$tankgetir[0][barkodno];
            $aktar                            = $_REQUEST['durum'];
            $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
            $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
            $yoneticilogu["etiketyazdir"]     = $umodel->etiketyazdir($etiketid); // Mal kabul stoğunda işlenmemiş ham madde
            $this->load->view("uretim/stokaktarimiyap", $yoneticilogu);            
            if($aktar==1){
            try{
                $data = array(
                    'katid'             => 3,
                    'tankid'            => $tankid,
                    'depoid'            => $depoSec,
                    'stokadi'           => $sadi,
                    'miktar'            => 1,
                    'barkodno'          => $bno,
                    'stokdurumu'        => 1,
                    'giristarihi'       => date("Y-m-d")
                );
                } catch (PDOException $e) {
                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $result = $model->stokkaydet($data);                    
                if($result){ 
                    try{
                        $data = array(
                            'uretimdurumu'       => 4                       
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $results        = $umodel->uretimetanksevket($data,$tankid);  
                }    
            }
        }
    // Etiket Yazdırmayı gönderilmek üzere hazırlanan mal stok ürünün hazırlanması
        public function stokaktarimiyapsin(){
            $form                             = $this->load->siniflar('form');
            $model                            = $this->load->model("stok_model");      
            $umodel                           = $this->load->model("uretim_model");
            $etiketid                         = $_REQUEST['id'];
            $tankid                           = $etiketid;
            $ID                               = $etiketid;
            $depoSec                          = 1;
            $tankgetir                        = $umodel->uretilentanklar($tankid);
            $sadi                             = @$tankgetir[0][SeriNom];
            $bno                              = @$tankgetir[0][barkodno];

            try{
                $data = array(
                    'katid'             => 1,
                    'tankid'            => $tankid,
                    'depoid'            => $depoSec,
                    'stokadi'           => $sadi,
                    'miktar'            => 1,
                    'barkodno'          => $bno,
                    'stokdurumu'        => 1,
                    'giristarihi'       => date("Y-m-d")
                );
                } catch (PDOException $e) {
                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $result = $model->stokkaydet($data);                    
                if($result){ 
                    try{
                        $data = array(
                            'uretimdurumu'       => 4                       
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $results        = $umodel->uretimetanksevket($data,$tankid);  
                        if($results){
                            header('Refresh: 0; url= '.SITE_URL.'/uretim/uretilenler/&ID=25');                            
                        }
                }    
            
        }        
    // Üretilecekler
    public function manueltankuret(){
        $form                             = $this->load->siniflar('form');
        $index_model                      = $this->load->model("index_model");
        $umodel                           = $this->load->model("uretim_model");
        $tmodel                           = $this->load->model("tanim_model");
        $ID                               = $form->guvenlik($_REQUEST['ID']);
        $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
        $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
        $yoneticilogu["serinumaralari"]   = $umodel->serinumaralari();
        $yoneticilogu["cariler"]          = $umodel->cariler();
        $yoneticilogu["istasyonlar"]      = $tmodel->istasyonlar();
        $this->load->view("ustAlan", $yoneticilogu);
        $this->load->view("uretim/manueltankuret", $yoneticilogu);
        $this->load->view("solAlan", $yoneticilogu);
        $this->load->view("altAlan", $yoneticilogu);
    }        
    // Manuel Tank Üretimi
    public function manueltankuretimi(){
        $umodel         = $this->load->model("uretim_model");      
        $form           = $this->load->siniflar('form');
        $form           ->post('serinoID', true);
        $form           ->post('cariID', true);
        $form           ->post('uretimAdeti', true);
        $form           ->post('uretimBasSeriNo', true);
        $form           ->post('istasyonID', true);
        $form           ->post('tankTuru', true);
        $seriid         = $form->guvenlik($form->values['serinoID']);
        $serigetir      = $umodel->serinumarasigetir($seriid);
        $sadi           = @$serigetir[0][serino];
        $snid           = @$serigetir[0][sntid];
        $sonkayit       = $umodel->sontankkaydi($sadi);
        $uretimadeti    = $form->guvenlik($form->values['uretimAdeti']);
        $serino         = $form->guvenlik($form->values['uretimBasSeriNo']);  
        $istid          = $form->guvenlik($form->values['istasyonID']);  
        if($form->values['tankTuru']==1){
            $udurumu    = 1;
        }elseif($form->values['tankTuru']==2){
            $udurumu    = 2;
        }else{
            $udurumu    = 2;
        } 
        if(!empty($form->guvenlik($form->values['serinoID']))){
            if(!empty($form->guvenlik($form->values['cariID']))){
                    try{
                        $data = array(
                            'malstokid'         => 0,
                            'musteriid'         => $form->guvenlik($form->values['cariID']),
                            'seriid'            => $snid,
                            'miktar'            => $form->guvenlik($form->values['uretimAdeti']),
                            'utarihi'           => date("Y-m-d H:i:s"),
                            'aciklama'          => $sadi,
                            'turu'              => "govde"
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $result = $umodel->stokuretimkaydet($data);                    
                        if($result){ 
                        $sonuretim = $umodel->sonuretimid();                    
                            for ($i=@$serino+1; $i<=$uretimadeti+@$serino+0; $i++) { 
                                try{
                                    $data = array(
                                        'uretimid'          => @$sonuretim[0][uid],
                                        'serino'            => $sadi.str_pad(@$i,5,0,STR_PAD_LEFT),
                                        'sirano'            => $i,
                                        'uretimdurumu'      => $udurumu,
                                        'uretimesevk'       => 1,
                                        'satisdurumu'       => 0
                                    );
                                } catch (PDOException $e) {
                                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                                }
                                $result = $umodel->manueltankkaydet($data);
                                if($udurumu==1){ /// 1 ise Tank Üretime gönderiliyor. Böylece üretilen tüm tanklar ilgili istasyona aktarılıyor.
                                    $sontank = $umodel->sontankigetir();
                                    try{
                                            $data = array(
                                                'persid'            => 1,
                                                'istasyonid'        => $istid,
                                                'tankid'            => @$sontank[0][tkid],
                                                'sacustid'          => 0,
                                                'sacid'             => 0,
                                                'islemdurumu'       => 1,
                                                'onaydurum'         => 0
                                            );
                                        } catch (PDOException $e) {
                                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                                        }
                                        $resultss = $umodel->istasyonasevket($data);
                                        
                                        if($resultss){ // Tank Kaydı olduğunda
                                            $sacplanseriid = $umodel->govdesacplanlamaseriid($seriid);// Saç planlama menü tablosundaki seriid kısmından ilgili saçları çekiyoruz.               
                                            $mukid = @$sacplanseriid[0][mukid];
                                            $sacstokgetir = $umodel->sacstokidgetir($mukid); // Sac Stok Tablosundan sAç planlamaya ait saçları getir. 
                                           if(@$sacplanseriid[0][kesimturu]=="govde"){ // Kesim türü gövde olan sacın 1 adetini getir.
                                                try{
                                                    $data = array(
                                                        'sacstokid'         => @$sacstokgetir[$i][spsid],
                                                        'tankid'            => @$sontank[0][tkid],
                                                        'turu'              => 'govde'
                                                    );
                                                } catch (PDOException $e) {
                                                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                                                }
                                            }
                                            $resultssac = $umodel->tankicinsackaydet($data);//Tank için ilgili gövde sacı kaydet
                                        }
                                }
                            }                               
                            echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> Kayıt işleminiz başarılı şekilde gerçekleşti.</div>';
                    }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kayıt işleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Firma alanını boş bırakmayınız.</div>';}     
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Seri Numarası alanını boş bırakmayınız.</div>';}                   
    } 
    // İşlemi Geri Alma Metodu
    public function tankislemigerial($uretimid=null){
        $form                             = $this->load->siniflar('form');
        $umodel                           = $this->load->model("stok_model");
        $model                            = $this->load->model("uretim_model");
            try{
                $datas = array(
                    'btid'             =>$uretimid,
                    'onaydurumu'       =>0                       
                );
            } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
            }
            $results        = $umodel->tankislemigerial($datas,$uretimid);  
        if($results){ 
            echo '<div class="alert alert-success bg-success text-white" role="alert"><strong>TEBRİKLER</strong> İşleminiz başarılı şekilde gerçekleşti.</div>';
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> İşleminiz gerçekleşmedi. Bilgileri kontrol ederek tekrar deneyiniz.</div>';}
    }    
          // Tank Silme Alan Metodu
          public function tanksil(){
            $form       = $this->load->siniflar('form');
            $model      = $this->load->model("uretim_model");
            $ymodel     = $this->load->model("yonetici_model");
            $form       ->post('id', true)
                        ->isempty();
            $KAYITID    = $form->guvenlik($_REQUEST['id']);
            $result     = $model->tanksil($KAYITID);
            if($result){ // İşlem Durumunu Kontrol Et
              // Notification İşlemi Başlangıç
              try{
              $yoneticilogu   = array(
                  'ADISOYADI'     => session::get("adminName"),
                  'KULLANICIADI'  => session::get("adminUName"),
                  'ISLEMTURU'     => "Tank Numarası Silindi",                
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
    // Üretime Sevk Et Metodu
    public function toplustokaktar(){
        $model          = $this->load->model("uretim_model");        
        $form           = $this->load->siniflar('form');
        $ID             = $form->guvenlik($_REQUEST['id']);
        $uretimdekiler  = $model->uretimdekilerigetir($ID);
        $uretimdekilert = $model->uretimdekileritoplami($ID);
            for ($i=0; $i < $uretimdekilert; $i++) {
                $tankid = @$uretimdekiler[$i][tkid];
                try{
                $data = array(
                        'katid'             => 3,
                        'tankid'            => @$uretimdekiler[$i][tkid],  
                        'depoid'            => 1, // Stok id
                        'stokadi'           => @$uretimdekiler[$i][serino], // Stok id
                        'stokdurumu'        => 1,                  
                        'miktar'            => 1,                      
                        'giristarihi'       => date("Y-m-d"),                      
                        'aciklama'          => @$uretimdekiler[$i][serino].' Tank Aktarımı Yapıldı.'                      
                );
                } catch (PDOException $e) {
                    die('Baglanti Kurulamadi : ' . $e->getMessage());
                }
                $result         = $model->toplustokaktar($data);
                try{
                    $data = array(
                        'uretimdurumu'       => 4                       
                    );
                    } catch (PDOException $e) {
                        die('Baglanti Kurulamadi : ' . $e->getMessage());
                    }
                    $results        = $model->uretimetanksevket($data,$tankid);                
            }
            if($result){                   
                echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!..Üretime gönderildi.')</script>";
                header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
            }else{
                echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Üretime Gönderilmedi.')</script>";
                header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
            }                 
    }             
}