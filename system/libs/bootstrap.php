<?php
/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr
*/
/**
 * Bootstrap Class'ı
 * 
 * Bu class url'e göre yönlendirme yapmaktadır.
 */
class bootstrap{
    /**
     *
     * @var Array URL verilerini tutar.
     */
    public $_url;
    
    /**
     *
     * @var String Çalıştırılacak controller adını tutar.
     */
    public $_controllername = 'index';
    
    /**
     *
     * @var String Çalıştırılacak method adını tutar.
     */
    public $_methodname = 'index';
    
    /**
     *
     * @var String Controller dosyalarının yolunu tutar.
     */
    public $_controllerpath = 'app/controllers/';
    
    /**
     *
     * @var Object Çalıştırılan controller nesnesini/sınıfını tutar.
     */
    public $_controller;
    
    /**
     * İlk burası çalışır.
     */
    public function __construct() {
        $this->geturl();
        $this->loadcontroller();        
        $this->callmethod();
    }
    
    /**
     * Url'i alır, dizi haline getirir. $_url özelliğine atar.
     * $_url[0] -> Controller ismi
     * $_url[1] -> Method ismi
     * $_url[2] -> Parametre
     * 
     * Ya da
     * 
     * Url boş ise $_url özelliğini unset() yapar.
     */
    public function geturl(){
        $this->_url = isset($_GET["url"]) ? $_GET["url"] : null;
        if($this->_url != null){
            $this->_url = rtrim($this->_url, "/");
            $this->_url = explode("/", $this->_url);
        }else{
           unset($this->_url); 
        }
    }
    
    /**
     * Controller dosyasını ve Controller'ı yükler.
     * $_url[0] set edilmişse $_controllername'e atar ve $_controllername'i 
     * yükler.
     * $_url[0] set edilmemişse $_controllername'in default değerini yükler.
     */
    public function loadcontroller(){
        if(!isset($this->_url[0])){
            include  $this->_controllerpath . $this->_controllername . '.php';
            $this->_controller = new $this->_controllername();
        }else{
            $this->_controllername = $this->_url[0];
            $filename = $this->_controllerpath . $this->_controllername . ".php";
            if(file_exists($filename)){
                include $filename;
                if(class_exists($this->_controllername)){
                    $this->_controller = new $this->_controllername();
                }else{                    
                    header("Location:" . SITE_URL404);                    
                }
            }else{}
        }
    }
    
    /**
     * Methodu parametreli ya da parametresiz yükler.
     * $_url[1] set edilmişse $_methodname'e atar ve $_methodname'i 
     * yükler.
     * $_url[1] set edilmemişse $_methodname'in default değerini yükler.
     */
    public function callmethod(){
        //paremetre varsa
         if(isset($this->_url[2])){
            $this->_methodname = $this->_url[1];
            if(method_exists($this->_controller, $this->_methodname)){
                //metod çağırma ve metoda paremetre gönderme
                $this->_controller->{$this->_methodname}($this->_url[2]);
            }else{
                //echo "Controller içinde method bulunamadı ";
                header("Location:" . SITE_URL404);
            }
        }else{
            if(isset($this->_url[1])){
                //method ismini atıyorum
                $this->_methodname = $this->_url[1];
                if(method_exists($this->_controller, $this->_methodname)){
                    //paremetesiz metodu çağırma
                    $this->_controller->{$this->_methodname}();
                }else{
                    //echo "Coontroller içinde bulunmadı";
                    header("Location:" . SITE_URL404);
                }
            }else{
                if(method_exists($this->_controller, $this->_methodname)){
                    //kullanıcı bi metod girmedi ise ilgili kontrolün metodunu çağır yani default gibi
                    //control adını girmişim ama method girmemişim
                    //heryere index metodu girmeliyim ki ayni sınıfa kullanıcı sadece controller girmiş olsa da bu metdo çalışsın
                    $this->_controller->{$this->_methodname}();
                }else{
                    //echo "Controller içinde İndex metodu bulunamadı bulunmadı";
                    //Session::destroy();
                    header("Location:" . SITE_URL404);
                }
            }
        }
    }
}
