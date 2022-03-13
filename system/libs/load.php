<?php
/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr
*/
/*
 * Load sınıfı ile istenilen dosyalara daha rahat ulaşabilmeyi sağlamaktadır.Yani gelen filename adı ile istenilen
 * klasör altındaki istenilen sınıfa $this->load->$filename('') şeklinde ulaşabileceğiz
 */
class load{
    public function __construct() {
        
    }
    
    //view classları için
    public function view($dosyAdi, $data = false){
        if($data == true){
            extract($data);
        }
        include "app/views/" . $dosyAdi . "_view.php";
    }
    
    //model classları için
    public function model($dosyAdi){
        include "app/models/" . $dosyAdi . ".php";
        return new $dosyAdi();
    }
    
    //siniflar classları için
    public function siniflar($dosyAdi){
        include "app/siniflar/" . $dosyAdi . ".php";
        return new $dosyAdi();
    }
}
