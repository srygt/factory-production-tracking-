<?php
/*
* MATGIS YMM
* Version V.001
* Author Serdar YİĞİT
* Email support@matgis(dot)com(dot)tr
* Web www(dot)matgis(dot)com(dot)tr
*/

class form_model extends model{
    
    public function __construct() {
        parent::__construct();
    }
    // Üretim Hattı Kontrol Formu Güncelleme İşlemi gösterir metod
    public function uretimhattikontrolformuguncelle($data,$KID) {
        try {
            $sql =  $this->db->update("mg_uretim_kontrol_formu", $data, "kfid='{$KID}'");
            $this->db->commit();
            return $sql;
        } catch (Exception $e) {
           echo $e->getMessage();
           $this->db->rollback();
        }
    }
    
    // Üretim Hattı Kontrol Formu Kaydetme
    public function uretimhattikontrolformukaydet($data) {
        try {
            $sql = $this->db->insert("mg_uretim_kontrol_formu", $data);
            $this->db->commit();
            return $sql;
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->db->rollback();
        }
    }
  
    // Üretim Hattı Kontrol Formu düzenlemeyi gösterir metod
    public function uretimhattikontrolformuduzenle($CID) {
        try {
        $sql = $this->db->select("SELECT * FROM mg_uretim_kontrol_formu WHERE kfid='{$CID}' ORDER BY kfid DESC LIMIT 1");
        return $sql;
        if (!is_integer($sql)) {
        throw new Exception('Üretim Hattı Kontrol Formu Düzenlemeyi Gösterir SQL sorgusu başarısız!');
        }
        } catch (Exception $e) {
        echo $e->getMessage();
        }        
    }
    // Üretim Hattı Kontrol Formu Silme İşlemi gösterir metod
    public function uretimhattikontrolformusil($KAYITID) {
        try {
            $sql =  $this->db->delete("mg_uretim_kontrol_formu", "kfid='{$KAYITID}'");
            $this->db->commit();
            return $sql;
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->db->rollback();
        }
    }

    // Üretim Hattı Kontrol Formu Sayısı Metodu
    function uretimhattikontrolformusayisi()
    {   
    $sql = $this->db->select("SELECT * FROM mg_uretim_kontrol_formu 
    ORDER BY kfid DESC");
    return count($sql); 
    }
    // Tüm Üretim Hattı Kontrol Formuler
    function uretimhattikontrolformulistesi($limit,$start,$order,$dir)
    {   
    $sql = $this->db->select("SELECT * FROM mg_uretim_kontrol_formu
    ORDER BY kfid DESC LIMIT $start,$limit");
        if($sql >0)
        {
            return $sql; 
        }
        else
        {
            return null;
        }
        
    }
   // Aranan Üretim Hattı Kontrol Formu
    function uretimhattikontrolformu_arama($limit,$start,$search)
    {
    $sql = $this->db->select("SELECT * FROM mg_uretim_kontrol_formu 
    WHERE FIRMAUNVANI LIKE '%$search%' 
    OR FIRMAYETKILI LIKE '%$search%' 
    OR FIRMAVD LIKE '%$search%' 
    OR FIRMAVN LIKE '%$search%' 
    OR FIRMAADRES LIKE '%$search%' 
    OR FIRMATEL LIKE '%$search%' 
    OR FIRMAEPOSTA LIKE '%$search%' 
    OR FIRMANOT LIKE '%$search%' 
    ORDER BY kfid DESC LIMIT $start,$limit");       
        if($sql>0)
        {
        return $sql;         
        }
        else
        {
            return null;
        }
    }
    // Aranan Üretim Hattı Kontrol Formu Sayısı
    function uretimhattikontrolformu_arama_sayisi($search)
    {
    $sql = $this->db->select("SELECT * FROM mg_uretim_kontrol_formu 
    WHERE FIRMAUNVANI LIKE '%$search%' 
    OR FIRMAYETKILI LIKE '%$search%' 
    OR FIRMAVD LIKE '%$search%' 
    OR FIRMAVN LIKE '%$search%' 
    OR FIRMAADRES LIKE '%$search%' 
    OR FIRMATEL LIKE '%$search%' 
    OR FIRMAEPOSTA LIKE '%$search%' 
    OR FIRMANOT LIKE '%$search%' 
    ORDER BY kfid DESC  
    ");
    return count($sql);            
    } 
    // Üretim Hattı Kontrol Formu getirmeyi gösterir metod
    public function uretimhattikontrolformugetir($KAYITID) {
        try {
        $sql = $this->db->select("SELECT * FROM mg_uretim_kontrol_formu t1 
        INNER JOIN subeler t2 ON (t1.SUBEID=t2.SID) WHERE t1.kfid='{$KAYITID}'
        ORDER BY t1.kfid DESC");
        return json_encode($sql);
        if (!is_integer($sql)) {
        throw new Exception('Üretim Hattı Kontrol Formu SQL sorgusu başarısız!');
        }
        } catch (Exception $e) {
        echo $e->getMessage();
        }
    }
}