<?php
/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr
*/
/* bu da load ta ilk index.php de include halde yani birbirini görebilmekterler
 * tabi ana controller yani burası üstte ve sistem altındakileri
 * include ettikçe görebilecek.sonrada ana bi değişken tanımladık load diye artık bununla 
 * ilgili sayfadaki Load klasörü altındaki tüm metodlara ulaşabiliriz.
 */
class controller {    
    protected $load = array();
    
    public function __construct() {
    	
        //echo "ana kontroller";
       $this->load = new load();
    }

}

