<?php
include("baglanti.php");

session_start();
$kullanici_id = 1; // Kullanıcı ID'sini buraya koyun (örneğin, oturumdan alınabilir)

$sql = "SELECT mevcut_seviye FROM kullanici_seviyeleri WHERE kullanici_id = ?";
if ($stmt = $baglan->prepare($sql)) {
    $stmt->bind_param("i", $kullanici_id);
    $stmt->execute();
    $stmt->bind_result($currentLevel);
    if ($stmt->fetch()) {
        echo $currentLevel;
    } else {
        echo 0; // Eğer kullanıcı bilgisi yoksa 0 olarak döndür
    }
    $stmt->close();
}

$baglan->close();
?>
