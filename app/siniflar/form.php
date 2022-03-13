<?php

class form{
    public $currentvalue;
    public $values = array();
    public $errors = array();
    public $count = array();

    public function __construct() {}

    private function adlandir($baslik){
        $bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
        $yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
        $perma = strtolower(str_replace($bul, $yap, $baslik));
        $perma = preg_replace("@[^A-Za-z0-9\\-_]@i", ' ', $perma);
        $perma = trim(preg_replace('/\s+/',' ', $perma));
        $perma = str_replace(' ', '-', $perma);
        return $perma;
    }
    // Gün Farkını Hesaplama
    function gunfarki($a="",$b=""){
        $baslangic = strtotime(''.$a.'');
        $bitis = strtotime(''.$b.''); 
        $sonuc = $bitis - $baslangic; 
        $kalan = ($sonuc/60/60/24);
        if 	($kalan>0){
          $kalan = "".$kalan."";
        }else if ($kalan==0){
         $kalan = "0";
        }else if($kalan<0){
          $kalan = "".$kalan."";
        }
        return $kalan;
        }    
    // Güvenlik Kontrolü Sağla
    public function guvenlik($query){
        $query              = strip_tags($query);
        $query              = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $query);
        $query              = preg_replace('/<!--.+?-->/', '', $query);
        $query              = preg_replace('/{.+?}/', '', $query);
        $query              = preg_replace('/&nbsp;/', '', $query);
        $query              = preg_replace('/&amp;/', '', $query);
        $query              = preg_replace('/&quot;/', '', $query);
        $query              = htmlspecialchars($query);
        $query              = addslashes($query);
        return $query;
    }
    //get metodu almak için
    public function get($key, $st = false) {
        if ($st) {
            $this->values[$key] = htmlspecialchars(addslashes(trim($_GET[$key])));
            $this->currentValue = $key;
            return $this;
        } else {
            return addslashes(trim($_GET[$key]));
        }
    }
    //post metodu almak için
    public function post($key, $st = false) {
        if ($st) {
        $this->values[$key]    = $_POST[$key];
        $this->currentvalue    = $key;
            return $this;
        } else {
            return addslashes(trim($_POST[$key]));
        }
    }

    //dizi post etme burada özel karekterleri silme gibi durumlar sıkıntı çıkardığı için üsttekinden faklı
    public function dizipost($key, $st = false) {
        if ($st) {
            $this->values[$key] = $_POST[$key];
            $this->currentValue = $key;
            return $this;
        } else {
            return $_POST[$key];
        }
    }

    //dizi sayısı
    public function count($array) {
        $deger = count($array);
        return $deger;
    }

    //en son kullanılan değerin boş mu dolu mu olduğuna bakacak
    public function isempty(){
        if(empty($this->values[$this->currentvalue])){
            $this->errors[$this->currentvalue]['empty'] = "Lütfen bu alanı boş bırakmayınız.";
        }
        return $this;
    }

    //başlık alanı kontrolü
    public function istitle(){
        if(empty($this->values[$this->currentvalue])){
            $this->errors[$this->currentvalue]['empty'] = "Lütfen bu alanı boş bırakmayınız.";
        }
        return $this;
    }
    //kullanıcı 5 ile 10 karekter arası girip girmediği gibi
    public function length($min = 0, $max){
        if(strlen($this->values[$this->currentvalue]) < $min OR strlen($this->values[$this->currentvalue]) > $max){
            $this->errors[$this->currentvalue]['length'] = "Lütfen " . $min . " ve " . $max . " karakter arasında bir yazı giriniz.";
        }
        return $this;
    }
    //mail formatında olup olmadığı gösterilmektedir
    public function ismail() {
        if(!filter_var($this->values[$this->currentvalue], FILTER_VALIDATE_EMAIL)){
            $this->errors[$this->currentvalue]['mail'] = "Lütfen geçerli bir mail adresi giriniz.";
        }
    }

    //onaylayıp hata kontrolü
    public function submit(){
        if(empty($this->errors)){
            return true;
        }else{
            return false;
        }
    }

    // Para değeri temizleme
    function temizle($veri) {  
        $veri=str_replace("/","",$veri);
        $veri=str_replace("&","",$veri);
        $veri=str_replace("=","",$veri);
        $veri=str_replace("<","",$veri);
        $veri=str_replace(">","",$veri);
        $veri=str_replace("!","",$veri);
        $veri=str_replace("\\","",$veri);
        $veri=str_replace("*","",$veri);
        $veri=str_replace("#","",$veri);
        $veri=str_replace("\'","",$veri);
        $veri=str_replace("?","",$veri);
        $veri=str_replace("TL","",$veri);
        $veri=str_replace(",","",$veri);
        return ($veri);
    }
    //decimal parayı //1500.00 virgül eçvirme 1,500.00
    function convertdecimal($odemeTutar) {
        $ex = explode(".", $odemeTutar);
        $length = strlen($ex[0]);
        $bas = 1;
        $son = 0;
        for ($l = 0; $l < $length; $l++) {
            if ($son < 3) {
                $odemeValue.=$odemeTutar[$length - $bas];
                $son++;
                $bas++;
            } else {
                $odemeValue.=",";
                $son = 0;
                $l--;
            }
        }
        return strrev($odemeValue) . "." . $ex[1];
    }

    //iki zaman arasıdnaki fark time=12:15
    function get_time_difference($time1, $time2) {
        $time1 = strtotime("1980-01-01 $time1");
        $time2 = strtotime("1980-01-01 $time2");

        if ($time2 < $time1) {
            $time2 += 86400;
        }
        return date("H:i", strtotime("1980-01-01 00:00") + ($time2 - $time1));
    }

    // iki tarih arasındaki fark
    function get_date_difference($tarih1,$tarih2,$ayrac){

    list($y1,$a1,$g1) = explode($ayrac, $tarih1);

    list($y2,$a2,$g2) = explode($ayrac, $tarih2);

    $t1_timestamp = mktime('0','0','0',$g1,$a1,$y1);

    $t2_timestamp = mktime('0','0','0',$g2,$a2,$y2);

    if($t1_timestamp > $t2_timestamp){
        $result = ($t1_timestamp - $t2_timestamp) / 86400;
    }
    else if ($t2_timestamp > $t1_timestamp)
    {
        $result = ($t2_timestamp - $t1_timestamp) / 86400;
    }
    return $result;

    }
    // ip adresim
    function myip() {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    function busimasnotification($target_device = array(), $alert, $title) {
        $appId        = '54K06z74qYiVBTx1DAtHC0xgHWcQ8HcnZlJcS5th';
        $restKey      = 'z7J7f963G4HF3G4Vh2JDJDeFRXCQ2PpHByQ3UUPL';
        $push_payload = json_encode(array(
            "where"   => array(
                "UniqueId" => array(
                    '$in' => $target_device)
            ),
            "data" => array(
                "alert" => $alert,
                "title" => $title
            )
        ));
        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, SITE_NOTIFICATION);
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rest, CURLOPT_PORT, 443);
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_payload);
        curl_setopt($rest, CURLOPT_HTTPHEADER, array("X-Parse-Application-Id: " . $appId,
            "X-Parse-REST-API-Key: " . $restKey,
            "Content-Type: application/json"));
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($rest);
        $result = json_decode($response);
        $sonuc = $result->{"result"};
        curl_close($rest);

        return $sonuc;
    }

    //array key değiştirme js güvenliği için
    function newkeys($oldkeys, $newkeys) {
        if (count($oldkeys) !== count($newkeys))
            return false;

        $data = array();
        $i = 0;
        foreach ($oldkeys as $k => $v) {
            $data[$newkeys[$i]] = $v;  // yeni array oluştur
            $i++;
        }
        return $data;
    }

    //array değer bulma fonksiyonu(count)
    function array_deger_filtreleme($array, $index, $value) {
        if (is_array($array) && count($array) > 0) {
            foreach (array_keys($array) as $key) {
                $temp[$key] = $array[$key][$index];

                if ($temp[$key] == $value) {
                    $newarray[$key] = $array[$key];
                }
            }
        }
        return $newarray;
    }
    //tarih düzenleme, tarih formatı YYYY/MM/DD şeklinde functiona gelmektedir
    function tarihduzenle() {
        if ($this->values[$this->currentValue]) {
            $tarihim = explode('/', $this->values[$this->currentValue]);
            $son = $tarihim[2] . '-' . $tarihim[1] . '-' . $tarihim[0];
        } else {
            $son = "";
        }
        return $son;
    }

    //substr.İstenilen yerden sonrasını kelimede alma
    function substrEnd($statement, $value) {
        $result = substr($statement, $value);
        return $result;
    }

    //substr.İstenilen karekterler arasını alır
    function substrInterval($statement, $start, $end) {
        $result = substr($statement, $start, $end);
        return $result;
    }

    //uzunluğu kısaltma fonksiyonu
    function kisalt($paremetre, $uzunluk = 50) {

        if (strlen($paremetre) > $uzunluk) {
            //bazı sunucularda mb çalışmıyor onun yerine mb silip direkt substr yazılması gerekir
            $paremetre = mb_substr($paremetre, 0, $uzunluk, "UTF8") . "..";
        }
        return $paremetre;
    }

    //başka sayfaya yönlendirme fonksiyonu
    function yonlendir($paremetre, $time = 0) {
        if ($time == 0) {
            header("Location:{$paremetre}");
        } else {
            header("Refresh: {$time}; url={$paremetre}");
        }
    }

    //diziyi istenilen karekter göre bölme
    function implode($divide, $array) {
        if ($this->count($array) > 0) {
            $implodeArray = implode($divide, $array);
            return $implodeArray;
        } else {
            return $array;
        }
    }
    //diziyi istenilen karekter göre bölme

    function date_tr($f, $zt = 'now'){
	$z = date("$f", strtotime($zt));
	$donustur = array(
		'Monday'	=> 'Pazartesi',
		'Tuesday'	=> 'Salı',
		'Wednesday'	=> 'Çarşamba',
		'Thursday'	=> 'Perşembe',
		'Friday'	=> 'Cuma',
		'Saturday'	=> 'Cumartesi',
		'Sunday'	=> 'Pazar',
		'January'	=> 'Ocak',
		'February'	=> 'Şubat',
		'March'		=> 'Mart',
		'April'		=> 'Nisan',
		'May'		=> 'Mayıs',
		'June'		=> 'Haziran',
		'July'		=> 'Temmuz',
		'August'	=> 'Ağustos',
		'September'	=> 'Eylül',
		'October'	=> 'Ekim',
		'November'	=> 'Kasım',
		'December'	=> 'Aralık',
		'Mon'		=> 'Pts',
		'Tue'		=> 'Sal',
		'Wed'		=> 'Çar',
		'Thu'		=> 'Per',
		'Fri'		=> 'Cum',
		'Sat'		=> 'Cts',
		'Sun'		=> 'Paz',
		'Jan'		=> 'Oca',
		'Feb'		=> 'Şub',
		'Mar'		=> 'Mar',
		'Apr'		=> 'Nis',
		'Jun'		=> 'Haz',
		'Jul'		=> 'Tem',
		'Aug'		=> 'Ağu',
		'Sep'		=> 'Eyl',
		'Oct'		=> 'Eki',
		'Nov'		=> 'Kas',
		'Dec'		=> 'Ara',
	);
	foreach($donustur as $en => $tr){
		$z = str_replace($en, $tr, $z);
	}
	if(strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
	return $z;
}

   // Zaman Çevirme Metodu
   function timeConvert ($zaman){
   $zaman =  strtotime($zaman);
   $zaman_farki = time() - $zaman;
   $saniye = $zaman_farki;
   $dakika = round($zaman_farki/60);
   $saat = round($zaman_farki/3600);
   $gun = round($zaman_farki/86400);
   $hafta = round($zaman_farki/604800);
   $ay = round($zaman_farki/2419200);
   $yil = round($zaman_farki/29030400);
   if( $saniye < 60 ){
      if ($saniye == 0){
         return "az önce";
      } else {
         return $saniye .' saniye önce';
      }
   } else if ( $dakika < 60 ){
      return $dakika .' dakika önce';
   } else if ( $saat < 24 ){
      return $saat.' saat önce';
   } else if ( $gun < 7 ){
      return $gun .' gün önce';
   } else if ( $hafta < 4 ){
      return $hafta.' hafta önce';
   } else if ( $ay < 12 ){
      return $ay .' ay önce';
   } else {
      return $yil.' yıl önce';
   }
    }
// Yeni Şifre Üretme    
function uret($uzunluk)
    {
 
     if(!is_numeric($uzunluk) || $uzunluk <= 0)
        {
            $uzunluk = 8;
        }
        if($uzunluk  > 32)
        {
            $uzunluk = 32;
        }
 
  $karakter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
 
  mt_srand(microtime() * 1000000);
 
        for($i = 0; $i < $uzunluk; $i++)
        {
            $key = mt_rand(0,strlen($karakter)-1);
            $pwd = $pwd . $karakter[$key];
        }
 
        for($i = 0; $i < $uzunluk; $i++)
        {
            $key1 = mt_rand(0,strlen($pwd)-1);
            $key2 = mt_rand(0,strlen($pwd)-1);
 
            $tmp = $pwd[$key1];
            $pwd[$key1] = $pwd[$key2];
            $pwd[$key2] = $tmp;
        }
 
        return $pwd;
    }
}
?>
