<?php
//git
//oturum başlatma
ob_start();
session::init();
//hata mesajlarını gösterme
error_reporting(0);
//Türkçe Karekter kullanımı
header('Content-Type: text/html; charset=utf-8');

//System dosyalarımı include ediyoruz
/*
 * bu function ile include etmediğimiz classları bu fonksiyonda belittiğimiz
 * adres dizinini de ayırıyor ve kendi include ediyor.
 * yani otomatik olarak bu adrestekileri include edecek kendisi.
 */

// System dosyalarını otomatik include ediyoruz.
function __autoload($className){
    $includeFile =  'system/libs/' . $className . '.php';
if(file_exists($includeFile))
    require_once ($includeFile);
else
    throw new Exception("{$className}.php dosyası yüklenemedi...");
}

// Config dosyasını include ediyoruz.
include_once 'app/config/config.php';
// Bootstrap Bölümü
$boot = new bootstrap();
?>