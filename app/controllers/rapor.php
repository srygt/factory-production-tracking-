<?php
/*
* MATGIS sl
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
// Raporlama İşlemleri
class rapor extends controller {
    function __construct() {
     parent::__construct();
     }
 
     function index() {
         $this->anasayfa();
     }
    //Raporlama    
    public function malkabulraporu(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $rmodel                             = $this->load->model("rapor_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["malkabulraporu"]             = $rmodel->malkabulraporu();
        $this->load->view("ustAlan", $data);
        $this->load->view("rapor/malkabulraporu", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);      
    }
    //Raporlama    
    public function planlamadetayi(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $rmodel                             = $this->load->model("rapor_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $planid                             = $form->guvenlik($_REQUEST['pid']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $data["malkabuldetayraporu"]        = $rmodel->malkabuldetayraporu($planid);
        $this->load->view("ustAlan", $data);
        $this->load->view("rapor/planlamadetayi", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);      
    }    
    // Mal Kabul Planlaması Modeli
    public function planlananmalkabullistesi(){
            $form                   = $this->load->siniflar('form');
            $model                  = $this->load->model("rapor_model");
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
                        2   => 'malkodu',
                        4   => 'stokseri',
                        5   => 'stokkodu',
                        6   => 'stokadi',
                        9   => 'miktar',
                        10  => 'menadet',
                        11  => 'kaladet',
                        12  => 'menuskodu',
                        13  => 'itarih',
                        14  => 'turu',
                        15  => 'islem'
                ); // Kolonlar

            $limit              = $form->values['length'];
            $start              = $form->values['start'];
            $order              = $kolonlar[$form->values['order']['0']['column']];
            $dir                = $form->values['order']['0']['dir'];
            $totalData          = $model->malkabulsayisi();
            $totalFiltered      = $totalData; 
            if(empty($form->values["search"]["value"]))
            {            
            $kayitlar           = $model->malkabullistesi($limit,$start,$order,$dir);
            }else {
            $search             = $form->values['search']['value']; 
            $kayitlar           = $model->malkabul_arama($limit,$start,$search);
            $totalFiltered      = $model->malkabul_arama_sayisi($search);
            }
            $data = array();
            if(!empty($kayitlar))
            {   $sn = 0;
                foreach ($kayitlar as $post)
                {
                    $sn++;
                        $matgisData['sn']               = '<label class="bg-primary text-white">'.$sn.'</label>';
                        $matgisData['malkodu']          = $post['kabulkodu'];
                        $matgisData['stokseri']         = $post['stokserino'];
                        $matgisData['stokkodu']         = $post['stokkodu'];
                        $matgisData['stokadi']          = $post['stokadi'];
                        $matgisData['miktar']           = $post['adet'];
                        $matgisData['menadet']          = $post['menuadet'];
                        $matgisData['kaladet']          = $post['kalanadet'];
                        $matgisData['menuskodu']        = $post['menustokkodu'];
                        $matgisData['itarih']           = $post['menukayittarih'];
                        if($post['turu']=="govde"){
                        $matgisData['turu']             = 'Gövde';
                        }else{
                        $matgisData['turu']             = 'Kapak';
                        }                    
                        $matgisData['islem']            = '<a class="dropdown-item" href="'.SITE_URL.'/rapor/planlamadetayi/&pid='.$post['mukid'].'" title="Planlama Detayı"><label class="bg-primary text-white">İNCELE</label></a>';
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