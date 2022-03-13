<?php
/*
* WOODIG MVC CMS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)woodig(dot)com 
*/

class view extends controller {

    function __construct() {
        
    }

    public function render($name){
        require 'views/yonetici/ustAlan_view.php';
        require 'views/yonetici/'.$name.'.php';
        require 'views/yonetici/altAlan_view.php';
    }
}