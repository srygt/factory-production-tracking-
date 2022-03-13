<?php
/*
* MATGIS ymm
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class kabul extends controller {
    function __construct() {
     parent::__construct();
     function private_str($str, $start, $end){
        $after  = mb_substr($str, 0, $start, 'UTF-8');
        $repeat = str_repeat('*', $end);
        $before = mb_substr($str, ($start + $end), strlen($str), 'UTF-8');
        return $after.$repeat.$before;
     }    
     }
 
//Mal Kabül Alanı
    // Mal Kabül   
    public function malkabul(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $this->load->view("ustAlan", $data);
        $this->load->view("kabul/malkabul", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Mal Kabül Ekle 
    public function malkabulekle(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["kabuldurumu"]                = $tanim_model->kabuldurumu();
        $this->load->view("ustAlan", $data);
        $this->load->view("kabul/malkabulekle", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Mal Kabül Detay 
    public function malkabuldetay(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $tanim_model                        = $this->load->model("tanim_model");
        $kabul_model                        = $this->load->model("kabul_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["birimdegeri"]                = $tanim_model->birimdegeri();
        $data["sonmalkabul"]                = $kabul_model->sonmalkabul();
        $this->load->view("ustAlan", $data);
        $this->load->view("kabul/malkabuldetay", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }
    // Mal Kabül Detay 
    public function malkabulbilgi(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $kabul_model                        = $this->load->model("kabul_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $kabulid                            = $form->guvenlik($_REQUEST['kbid']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["malkabulbilgisi"]            = $kabul_model->malkabulbilgisi($kabulid);
        $this->load->view("ustAlan", $data);
        $this->load->view("kabul/malkabulbilgi", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }

    // Mal Kabül Kaydetme Metodu
    public function malkabulkaydet(){
        $model          = $this->load->model("kabul_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('kabulTarihi', true)
                        ->isempty();
        $form           ->post('kabulSorumlusu', true)
                        ->isempty();
        $form           ->post('kabulDurumu', true)
                        ->isempty();
        $form           ->post('kabulKodu', true);
        $form           ->post('kabulOzelKodu', true);
        $form           ->post('kabulAciklama', true);
        $form           ->post('kabulPlaka', true);
        $form           ->post('kabulDorsePlaka', true);
        $form           ->post('kabulSofor', true);
        $form           ->post('kabulSoforTel', true);

        // kabul Alım Tarihi Gün Ay Yıl Olarak Dönüştürülmektedir.        
        if(!empty($form->values['kabulTarihi'])){
            $datar       = $form->guvenlik(date("Y-m-d", strtotime($form->values['kabulTarihi'])));
        }else{
            $datar       = NULL;
        } // kabul Alım Tarihi 
        if(!empty($form->guvenlik($form->values['kabulTarihi']))){
            if(!empty($form->guvenlik($form->values['kabulDurumu']))){                  
                    try{
                        $data = array(
                            'tarih'                 => $datar,
                            'kabulkodu'             => $form->guvenlik($form->values['kabulKodu']),
                            'sorumlusu'             => $form->guvenlik($form->values['kabulSorumlusu']),
                            'durumu'                => html_entity_decode($form->values['kabulDurumu']),
                            'ozelkodu'              => html_entity_decode($form->values['kabulOzelKodu']),
                            'aciklama'              => html_entity_decode($form->values['kabulAciklama']),
                            'plaka'                 => html_entity_decode($form->values['kabulPlaka']),
                            'dplaka'                => html_entity_decode($form->values['kabulDorsePlaka']),
                            'sofor'                 => html_entity_decode($form->values['kabulSofor']),                       
                            'sofortel'              => html_entity_decode($form->values['kabulSoforTel'])                        
                        );
                        } catch (PDOException $e) {
                            die('Baglanti Kurulamadi : ' . $e->getMessage());
                        }
                        $result = $model->malkabulkaydet($data);
                    if($result){ 
                        echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!...Kabul Gerçekleşti. Diğer adıma geçiş yapacaksınız.')</script>";
                        header('Refresh: 0; url= '.SITE_URL.'/kabul/malkabuldetay');                        
                }else{
                    echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Kabul Gerçekleşmedi.')</script>";
                    header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
                }
            }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kabul durumunu seçiniz.</div>';}     
        }else{ echo '<div class="alert alert-danger bg-danger text-white mb-0" role="alert"><strong>HATA!</strong> Kabul tarih alanını boş bırakmayınız.</div>';}                   
    }

    // Mal Kabül Bilgi Kaydetme Metodu
    public function malkabulbilgikaydet(){
        $model          = $this->load->model("kabul_model");        
        $form           = $this->load->siniflar('form');
        $form           ->post('stokSeriNo', true)
                        ->isempty();
        $form           ->post('stokAdi', true)
                        ->isempty();
        $form           ->post('stokEni', true);
        $form           ->post('stokBoyu', true);
        $form           ->post('stokKalinlik', true);
        $form           ->post('stokMiktari', true);         
        $form           ->post('kabulid', true);         
        $form           ->post('stokBirim', true);   
        $bilgisayisi    = count($form->values['stokAdi']);
        for ($i=0; $i < $bilgisayisi; $i++) {     
            $sonbilgikabul =  $model->sonmalkabulbilgiid();
            if(empty($sonbilgikabul)){
                $sacno = 1;
            }else{
                $sacno = @$sonbilgikabul[0][id]+1;
            }            
            $kg = (((html_entity_decode($form->values['stokEni'][$i]*0.01)*html_entity_decode($form->values['stokBoyu'][$i]*0.01))*(html_entity_decode($form->values['stokKalinlik'][$i])))*7.86)/100;
            try{
                $data = array(
                    'malid'                 => $form->guvenlik($form->values['kabulid']),
                    'birimid'               => $form->guvenlik($form->values['stokBirim']),
                    'stokserino'            => $form->guvenlik($form->values['stokSeriNo'][$i]),
                    'stokkodu'              => "SAC".(string)$sacno,
                    'stokadi'               => html_entity_decode($form->values['stokAdi'][$i]),
                    'eni'                   => html_entity_decode($form->values['stokEni'][$i]),
                    'boyu'                  => html_entity_decode($form->values['stokBoyu'][$i]),
                    'kalinlik'              => html_entity_decode($form->values['stokKalinlik'][$i]),
                    'kg'                    => $kg*html_entity_decode($form->values['stokMiktari'][$i]),
                    'miktar'                => html_entity_decode($form->values['stokMiktari'][$i])                       
                );
            } catch (PDOException $e) {
                die('Baglanti Kurulamadi : ' . $e->getMessage());
            }
            $result = $model->malkabulbilgikaydet($data);
        }
        if($result){ 
            echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('TEBRİKLER!...Kabul Gerçekleşti. Diğer adıma geçiş yapacaksınız.')</script>";
            header('Refresh: 0; url= '.SITE_URL.'/kabul/malkabul/&ID=7');                        
        }else{
            echo @str_repeat("<br>", 1)."<script type='text/javascript'>alert('HATA!...Kabul Gerçekleşmedi.')</script>";
            header('Refresh: 0; url= '.$_SERVER['HTTP_REFERER'].'');                       
        }                 
    }

    // Mal Kabül Silme Alan Metodu
    public function malkabulsil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("kabul_model");       
        $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi           
        $result     = $model->malkabulsil($KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! İşlem başarılı şekilde silindi.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }

    // Mal Kabül Bilgi Silme Alan Metodu
    public function malkabulbilgisil(){
        $form       = $this->load->siniflar('form');     
        $model      = $this->load->model("kabul_model");       
        $KAYITID    = $form->guvenlik($_REQUEST['id']); // Gönderilen modül id parametresi           
        $result     = $model->malkabulbilgisil($KAYITID);
        if($result){     
          echo '<div class="alert alert-success bg-success text-white">TEBRİKLER! Silme işlemi başarılı.</div>';
        }else{echo '<div class="alert alert-danger bg-danger text-white mb-0">HATA! Silme işleminiz başarısız.</div>';}
    }

    // Mal Kabül Listesi Modeli
    public function kabullistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("kabul_model");
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
                  1   => 'kodu',
                  2   => 'tarih',
                  3   => 'sorumlu',
                  4   => 'durum',
                  5   => 'plaka',
                  6   => 'sofor',
                  7   => 'miktar'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->kabulsayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->kabullistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->kabul_arama($limit,$start,$search);
        $totalFiltered      = $model->kabul_arama_sayisi($search);
        }
        $data = array();
        if(!empty($kayitlar))
        {   $sn = 0;
            foreach ($kayitlar as $post)
            {
                $sn++;
                $matgisData['islem']           = '             
                <div><a href="'.SITE_URL.'/kabul/malkabulbilgi/&kbid='.$post['id'].'" class="btn-group m-b-10 btn btn-info" title="Kabul Bilgisi"><i style="font-size:21px;" class="mdi mdi-open-in-new"></i> Detay Göster</a> 
                <a href="'.SITE_URL.'/kabul/malkabuldetay/&kabulid='.$post['id'].'" class="btn-group m-b-10 btn btn-success" title="Veri Gir"><i style="font-size:21px;" class="mdi mdi-open-in-new"></i> Veri Gir</a>  
                <a href="javascript:void(0);" class="btn-group m-b-10 btn btn-danger" onclick="kabulSil('.$post['id'].')" title="İşlemi Sil"><i style="font-size:21px;" class="mdi mdi-delete"></i> Sil</a>
                </div>';                
                $matgisData['kodu']             = $post['kabulkodu'];
                $matgisData['tarih']            = date("d-m-Y", strtotime($post['tarih']));
                $matgisData['sorumlu']          = $post['sorumlusu'];
                $matgisData['durum']            = $post['durumadi'];
                $matgisData['plaka']            = $post['plaka'];
                $matgisData['sofor']            = $post['sofor'];
                $matgisData['miktar']           = $post['miktari'];
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