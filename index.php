
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THS Ölçüm Formu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="logo-container">
        <img src="tusaşsembol.jpg" alt="TUSAŞ Sembolü" class="logo">
    </div>
        
    <h1>THS Ölçüm Formu</h1>
    <form action="index.php" id="ths-form" method="post">
        <!-- Form elemanları -->
        <label for="proje-kodu">Proje/ Konu Kodu:</label>
        <input type="text" placeholder="Lütfen bir sayı giriniz." id="proje-kodu" name="proje-kodu" required><br><br>

        <label for="proje-adi">Proje/ Konu Adı:</label>
        <input type="text" id="proje-adi" name="proje-adi" required><br><br>

        <label for="konu-sorumlusu">Konu Sorumlusu:</label>
        <input type="text" id="konu-sorumlusu" name="konu-sorumlusu" required><br><br>

        <label for="form-tarihi">Form Doldurma Tarihi:</label>
        <input type="date" id="form-tarihi" name="form-tarihi" required><br><br>

        <label for="hedef-ths">Hedeflenen THS:</label>
        <input type="number" id="hedef-ths" name="hedef-ths" required><br><br>

        <label for="teknoloji-turu">Teknoloji Türü:</label>
        <select id="teknoloji-turu" name="teknoloji-turu" onchange="updateQuestions()" required>
            <option value="" disabled selected>Seçiniz</option>
            <option value="genel-muhendislik">Genel Mühendislik</option>
            <option value="yazilim">Yazılım</option>
        </select><br><br>

        <label for="proje-donemi">Proje Dönemi:</label>
        <select id="proje-donemi"  name="proje-donemi" required>
            <option value="" disabled selected>Seçiniz</option>
            <option value="ara-donem">Ara Dönem</option>
            <option value="kapanis-donemi">Kapanış Dönemi</option>
        </select><br><br>

        <div id="questions-container">
            <!-- Dinamik olarak sorular burada gösterilecek -->
        </div>

        <button type="submit" name="submit">THS Ölçüm Sorularına Devam Et</button>
    </form>

    

    <script src="app.js"></script>
</body>
</html>

<?php
include("baglanti.php");

// JSON dosyası yolu
$jsonFilePath = 'proje_kod.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proje kodunu JSON dosyasına kaydet
    if (!empty($_POST['proje-kodu'])) {
        $projeKodu = $_POST['proje-kodu'];
        $jsonData = array('projeKodu' => $projeKodu);
        file_put_contents($jsonFilePath, json_encode($jsonData));
    }

    $projeKodu = isset($jsonData['projeKodu']) ? $jsonData['projeKodu'] : ''; // JSON dosyasından proje kodunu al
    $projeAdi = $_POST["proje-adi"];
    $konuSorumlusu = $_POST["konu-sorumlusu"];
    $tarih = $_POST["form-tarihi"];
    $hedefThs = $_POST["hedef-ths"];
    $teknolojiTuru = $_POST["teknoloji-turu"];
    $projeDonemi = $_POST["proje-donemi"];

    // Tamamlanma oranını ve THS seviyesini hesapla
    $completion_rate = calculate_completion_rate(); // Gerçek hesaplamayı buraya ekleyin
    $currentLevel = calculate_ths_level($completion_rate);

    // Veritabanına kaydetme
    $ekle = "INSERT INTO sonuctablosu (projeKodu, projeAdi, sorumlu, tarih, hedefThs, teknolojiTuru, projeDonemi, thsLevel) 
             VALUES ('$projeKodu', '$projeAdi', '$konuSorumlusu', '$tarih', '$hedefThs', '$teknolojiTuru', '$projeDonemi', '$currentLevel')";

    if ($baglan->query($ekle) === TRUE) {
        // Başarıyla eklenen kayıt için yönlendirme
        if ($teknolojiTuru == 'genel-muhendislik') {
            header("Location: genel-muhendislik.php?level=$currentLevel");
            exit();
        } elseif ($teknolojiTuru == 'yazilim') {
            header("Location: yazilim.php?level=$currentLevel");
            exit();
        }
    } else {
        echo "Hata: " . $baglan->error;
    }
}

function calculate_completion_rate() {
    // Örnek tamamlanma oranı, buraya gerçek hesaplama eklenmeli
    return 70; // Örnek değer
}

function calculate_ths_level($completion_rate) {
    if ($completion_rate >= 80) {
        return 4;
    } elseif ($completion_rate >= 60) {
        return 3;
    } elseif ($completion_rate >= 40) {
        return 2;
    } else {
        return 1;
    }
}
?>
