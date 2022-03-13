<?php
/*
* MATGIS MVC SYS
* Version V.001
* Author Serdar YİĞİT
* Email imgeweb@gmail(dot)com
* Web www(dot)matgis(dot)com(dot)tr
*/
class database extends PDO{
    //kurucu metod    
   public function __construct($dsn, $user, $password) {
   parent::__construct($dsn, $user, $password);
   ob_start();
   session::checksession();
    setlocale(LC_TIME, 'tr_TR');                  
    date_default_timezone_set('Europe/Istanbul'); 
    setlocale(LC_TIME, "turkish"); 
    setlocale(LC_ALL,'turkish');     // zaman dili ayarı yapıldı.   
   $this->query("SET NAMES ´utf8´");
   $this->query("SET CHARACTER SET utf8");
   error_reporting(E_ALL ^ E_NOTICE);
   ini_set('error_reporting', E_ALL ^ E_NOTICE);
    }
    
    protected $transactionCount = 0;

    public function beginTransaction()
    {
        if (!$this->transactionCounter++) {
            return parent::beginTransaction();
        }
        $this->exec('SAVEPOINT trans'.$this->transactionCounter);
        return $this->transactionCounter >= 0;
    }

    public function commit()
    {
        if (!--$this->transactionCounter) {
            return parent::commit();
        }
        return $this->transactionCounter >= 0;
    }

    public function rollback()
    {
        if (--$this->transactionCounter) {
            $this->exec('ROLLBACK TO trans'.$this->transactionCounter + 1);
            return true;
        }
        return parent::rollback();
    }

        
    //select fonksiyonu
    public function cek($sql, $array = array(), $fetchMode = PDO::FETCH_NUM){
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindvalue($key, $value);
        }
        $sth->execute();
        return $sth->fetchall($fetchMode);
    }
    
    //select fonksiyonu
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC){
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindvalue($key, $value);
        }
        $sth->execute();
        return $sth->fetchall($fetchMode);
    }
    
    //etkilenen satırları görme fonksiyonu
    public function affectedrows($sql, $array = array()){
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
        $sth->bindvalue($key, $value);
        }
        $sth->execute();
        return $sth->rowcount();
    }
   //Kayıt Ekleme
       public function kayitekle($tablename, $data){
        $fieldkeys = implode(",", array_keys($data));
        $fieldvalues = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $tablename($fieldkeys) VALUES($fieldvalues)";
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindvalue(":$key", $value);
        }
        return $sth->execute();
    }

    //kayıt etme fonksiyonu
    public function insert($tablename, $data){
        $fieldkeys   = implode(",", array_keys($data));
        $fieldvalues = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $tablename($fieldkeys) VALUES($fieldvalues)";
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindvalue(":$key", $value);
        }
        if ($sth->execute()) {
            $donenid = $this->lastInsertId();
           return $donenid;
        } else {
            //unique için hata kodu
            if ($sth->errorcode() == 23000 || $sth->errorcode() == 1062) {
                return 'unique';
            } else {
                return false;
            }
        }
    }
    //çoklu kayıt etme
    function multiinsert($tablename, $data) {
        $rowsSQL = array();

        $tobind = array();

        $columnnames = array_keys($data[0]);

        foreach ($data as $arrayindex => $row) {
            $params = array();
            foreach ($row as $columnname => $columnvalue) {
                $param = ":" . $columnname . $arrayindex;
                $params[] = $param;
                $tobind[$param] = $columnvalue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }
        $sql = "INSERT INTO `$tablename` (" . implode(", ", $columnnames) . ") VALUES " . implode(", ", $rowsSQL);
        $sth = $this->prepare($sql);
        foreach ($tobind as $param => $val) {
            $sth->bindvalue($param, $val);
        }
        if ($sth->execute()) {
            return $this->lastInsertId();
        } else {
            //unique için hata kodu
            if ($sth->errorcode() == 23000 || $sth->errorcode() == 1062) {
                return 'unique';
            } else {
                return false;
            }
        }
    }


    //güncelleme fonksiyonu
    public function update($tablename, $data, $where){
        $updatekeys = null;
        foreach ($data as $key => $value) {
        $updatekeys .= "$key=:$key,";
        }
        $updatekeys = rtrim($updatekeys, ",");
        $sql = "UPDATE $tablename SET $updatekeys WHERE $where";
        
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindvalue(":$key", $value);
        }
        if ($sth->execute()) {
            return true;
        } else {
            return false;
        }
     }
    
    //silme işlemi
    public function delete($tablename, $where) {
        return($this->exec("DELETE FROM $tablename WHERE $where"));
    }

    //limite göre silme işlemi
    public function deletelimit($tablename, $where, $limit = 1) {
        $this->exec("DELETE FROM $tablename WHERE $where LIMIT $limit");
    }

    //count işlemi
    public function count($sql) {
        $result = $this->prepare($sql);
        $result->execute();
        $number_of_rows = $result->fetchColumn();
        return $number_of_rows;
    }
    
}
