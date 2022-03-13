<?php
/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr
*/

class model{
    protected $db   = array();
    public function __construct() {
        try {
        $dsn1        = 'mysql:dbname=test;host=localhost';
        $user1       = 'root';
        $password1   = '';
        $this->db    = new database($dsn1, $user1, $password1,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ));
        $this->db->beginTransaction();
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        }
        catch (PDOException $e) {
        echo "HATA: ".$e->getMessage();
        }
    }
}
