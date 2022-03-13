<?php
/*
* MATGIS ymm
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class log extends controller {
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
//Loglar Alanı
    // Loglar   
    public function loglar(){
        $form                               = $this->load->siniflar('form');
        $index_model                        = $this->load->model("index_model");
        $log_model                          = $this->load->model("log_model");
        $ID                                 = $form->guvenlik($_REQUEST['ID']);
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["menuyetkim"]                 = $index_model->menuyetkim($ID);
        $this->load->view("ustAlan", $data);
        $this->load->view("log/loglar", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan", $data);        
    }
    // Log Listesi Modeli
    public function loglistesi(){
        $form                   = $this->load->siniflar('form');
        $model                  = $this->load->model("log_model");
        $form                   ->post('length', true);
        $form                   ->post('start', true);
        $form                   ->post('order', true);
        $form                   ->post('search', true);
        $form                   ->post('column', true);
        $form                   ->post('value', true);
        $form                   ->post('draw', true);
        $form                   ->post('dir', true);
        $kolonlar = array( 
                  2   => 'admin',
                  3   => 'kuladi',
                  4   => 'ituru',
                  5   => 'itarih',
                  6   => 'ip'
              ); // Kolonlar

        $limit              = $form->values['length'];
        $start              = $form->values['start'];
        $order              = $kolonlar[$form->values['order']['0']['column']];
        $dir                = $form->values['order']['0']['dir'];
        $totalData          = $model->logsayisi();
        $totalFiltered      = $totalData; 
        if(empty($form->values["search"]["value"]))
        {            
        $kayitlar           = $model->loglistesi($limit,$start,$order,$dir);
        }else {
        $search             = $form->values['search']['value']; 
        $kayitlar           = $model->log_arama($limit,$start,$search);
        $totalFiltered      = $model->log_arama_sayisi($search);
        }
        $data = array();
        if(!empty($kayitlar))
        {   $sn = 0;
            foreach ($kayitlar as $post)
            {
                $sn++;             
                $matgisData['admin']            = $post['ADISOYADI'];
                $matgisData['kuladi']           = $post['KULLANICIADI'];
                $matgisData['ituru']            = $post['ISLEMTURU'];
                $matgisData['itarih']           = date("d-m-Y",strtotime($post['ISLEMTARIHI']));
                $matgisData['ip']               = $post['IPNO'];
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