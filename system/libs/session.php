<?php

/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr
*/


class session{
    public static function init(){//başlangıç
    session_start();
        //session oturum idisini tekraradan oluşturuyor.
        //session_regenerate_id();
    }
    
    //get ve set session değişkeni tanımlama ve tanımladığım değişkeni alma şeklinde
    public static function set($key, $val){
        //istediğim her yerden değer atayabiliyorum
        $_SESSION[$key] = $val;
    }
    public static function get($key){
    if(isset($_SESSION[$key])){
            return $_SESSION[$key];
    }else{
            return false;
    }
   }
    
    //kendi uygulamamız için framework oldu
    public static function checksession(){
        self::init();

        if(self::get("giris") == false){

           self::destroy();
           
           header("Location: ". SITE_URL ."/yonetici/giris");
        }
    }


    public static function destroy(){
        session_destroy();
    }
}