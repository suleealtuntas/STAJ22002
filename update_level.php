<?php
include 'baglanti.php';

// JSON dosyası yolu
$jsonFilePath = 'proje_kod.json';

// JSON dosyasından proje kodunu oku
if (file_exists($jsonFilePath)) {
    $jsonData = json_decode(file_get_contents($jsonFilePath), true);
    if (isset($jsonData['projeKodu'])) {
        $projeKodu = $jsonData['projeKodu']; // JSON dosyasından proje kodunu al
        echo "Proje Kodu: " . htmlspecialchars($projeKodu);

        // POST ile gelen verileri al
        $level = $_POST['level'];

        // Veritabanı sorgusu
        $guncelle = "UPDATE sonuctablosu SET thsLevel = ? WHERE projeKodu = ?";

        $stmt = $baglan->prepare($guncelle);
        $stmt->bind_param("is", $level, $projeKodu);

        if ($stmt->execute()) {
            echo "Başarıyla güncellendi.";
        } else {
            echo "Hata: " . $stmt->error;
        }

        $stmt->close();
        $baglan->close();
    } else {
        echo "Proje kodu JSON dosyasında bulunamadı.";
    }
} else {
    echo "JSON dosyası mevcut değil.";
}
?>