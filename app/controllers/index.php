<?php
/*
* MATGIS TETS
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/
class index extends controller{  
   public function __construct() {
        parent::__construct();
    }

    public function index(){
            if(session::get("AdminID")!=4){
                $this->anasayfa();
            }else{
                $this->yazdirmalistesi();
            }        
        
    }
// Anasayfa
    public function anasayfa(){
        $index_model                        = $this->load->model("index_model");
        $rapor_model                        = $this->load->model("rapor_model");
        $data["menulistesi"]                = $index_model->menulistesi();
        $data["toplampersonel"]             = $rapor_model->toplampersonel();
        $data["toplamseri"]                 = $rapor_model->toplamseri();
        $data["toplamsevk"]                 = $rapor_model->toplamsevk();
        $data["toplamstok"]                 = $rapor_model->toplamstok();
        $data["toplamuretilen"]             = $rapor_model->toplamuretilen();
        $data["toplamuretilecek"]           = $rapor_model->toplamuretilecek();
        $data["toplamuretimdekiler"]        = $rapor_model->toplamuretimdekiler();
        $data["stoklar"]                    = $rapor_model->stoklar();
        $data["okunanlar"]                  = $rapor_model->okunanlar();
        $this->load->view("ustAlan", $data);
        $this->load->view("anasayfa", $data);
        $this->load->view("solAlan", $data);
        $this->load->view("altAlan");    
    }
    // Yazdırma Listesi
    public function yazdirmalistesi(){
        $form                             = $this->load->siniflar('form');
        $index_model                      = $this->load->model("index_model");
        $tmodel                           = $this->load->model("tanim_model");
        $ID                               = $form->guvenlik($_REQUEST['ID']);
        $yoneticilogu["menulistesi"]      = $index_model->menulistesi();
        $yoneticilogu["menuyetkim"]       = $index_model->menuyetkim($ID);
        $this->load->view("ustAlan", $yoneticilogu);
        $this->load->view("uretim/yazdirmalistesi", $yoneticilogu);
        $this->load->view("altAlan", $yoneticilogu);
    }   
// Hata sayfası    
    public function hata(){
        $this->load->view("hata");  
    }   
    
}
