<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function checkScore(score) {
            var currentLevel = 0; // Varsayılan olarak seviye 0

            // Bu seviyeyi MySQL veritabanından al
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "getCurrentLevel.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    currentLevel = parseInt(xhr.responseText);

                    if (score >= 80) {
                        currentLevel += 1; // Kullanıcı bir üst seviyeye geçiyor
                        // Seviye güncelleme
                        var xhrUpdate = new XMLHttpRequest();
                        xhrUpdate.open("POST", "updateLevel.php", true);
                        xhrUpdate.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhrUpdate.send("level=" + currentLevel);
                        
                        xhrUpdate.onreadystatechange = function () {
                            if (xhrUpdate.readyState == 4 && xhrUpdate.status == 200) {
                                window.location.href = ths-${currentLevel}.html; // Bir sonraki seviyeye geçiş
                            }
                        };
                    } else {
                        var xhrInsert = new XMLHttpRequest();
                        xhrInsert.open("POST", "updateLevel.php", true);
                        xhrInsert.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhrInsert.send("level=" + currentLevel);

                        xhrInsert.onreadystatechange = function () {
                            if (xhrInsert.readyState == 4 && xhrInsert.status == 200) {
                                window.location.href = panel.php?level=${currentLevel}; // Sonuç sayfasına seviyeyi gönder
                            }
                        };
                    }
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>

<h1 class="header">SONUÇLAR</h1>

<div class="container">
    <table id="customers">
        <thead>
            <tr>
                <th>Proje/Konu Kodu</th>
                <th>Proje/Konu Adı</th>
                <th>Konu Sorumlusu</th>
                <th>Form Doldurma Tarihi</th>
                <th>Hedeflenen THS</th>
                <th>Teknoloji Türü</th>
                <th>Proje Dönemi</th>
                <th>THS Seviyesi</th>
                <th>Mevcut Durum</th>
                <th>Seç</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include("baglanti.php");

            $sec = "SELECT * FROM sonuctablosu";
            $sonuc = $baglan->query($sec);

            if($sonuc->num_rows > 0){
                while($cek = $sonuc->fetch_assoc()){
                    $thsLevel = $cek['thsLevel'];
                    $currentStatus = ($thsLevel >= 80) ? "Tamamlandı" : "Devam Ediyor";

                    echo "
                    <tr>
                        <td>".$cek['projeKodu']."</td>
                        <td>".$cek['projeAdi']."</td>
                        <td>".$cek['sorumlu']."</td>
                        <td>".$cek['tarih']."</td>
                        <td>".$cek['hedefThs']."</td>
                        <td>".$cek['teknolojiTuru']."</td>
                        <td>".$cek['projeDonemi']."</td>
                        <td>".$thsLevel."</td>
                        <td>".$currentStatus."</td>
                        <td>
                            <form action='panel.php#yonetFormu' method='POST'>
                                <input type='hidden' name='id' value='".$cek['id']."'>
                                <button type='submit' name='sec' class='btn-select'>Seç</button>
                            </form>
                        </td>
                    </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='10'>Veritabanında kayıtlı veri bulunamadı.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Seçilen satırın bilgilerini almak için
    $selectedRow = array(
        "projeKodu" => "",
        "projeAdi" => "",
        "sorumlu" => "",
        "tarih" => "",
        "hedefThs" => "",
        "teknolojiTuru" => "",
        "projeDonemi" => "",
        "thsLevel" => "",
        "id" => ""
    );

    if(isset($_POST['sec'])){
        $id = $_POST['id'];
        $secim = "SELECT * FROM sonuctablosu WHERE id='$id'";
        $seciliVeri = $baglan->query($secim)->fetch_assoc();
        
        if ($seciliVeri) {
            $selectedRow = array(
                "projeKodu" => $seciliVeri['projeKodu'] ?? "",
                "projeAdi" => $seciliVeri['projeAdi'] ?? "",
                "sorumlu" => $seciliVeri['sorumlu'] ?? "",
                "tarih" => $seciliVeri['tarih'] ?? "",
                "hedefThs" => $seciliVeri['hedefThs'] ?? "",
                "teknolojiTuru" => $seciliVeri['teknolojiTuru'] ?? "",
                "projeDonemi" => $seciliVeri['projeDonemi'] ?? "",
                "thsLevel" => $seciliVeri['thsLevel'] ?? "",
                "id" => $seciliVeri['id'] ?? ""
            );
        }
    }
    ?>
    <section class="yonet" id="yonetFormu">
    <div class="form-container">
        <h2>Proje Bilgilerini Yönet</h2>
        <form action="panel.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($selectedRow['id']); ?>">
            <input type="text" name="projeKodu" placeholder="Proje/Konu Kodu" value="<?php echo htmlspecialchars($selectedRow['projeKodu']); ?>" required>
            <input type="text" name="projeAdi" placeholder="Proje/Konu Adı" value="<?php echo htmlspecialchars($selectedRow['projeAdi']); ?>" required>
            <input type="text" name="sorumlu" placeholder="Konu Sorumlusu" value="<?php echo htmlspecialchars($selectedRow['sorumlu']); ?>" required>
            <input type="date" name="tarih" value="<?php echo htmlspecialchars($selectedRow['tarih']); ?>" required>
            <input type="text" name="hedefThs" placeholder="Hedeflenen THS" value="<?php echo htmlspecialchars($selectedRow['hedefThs']); ?>" required>
            <input type="text" name="teknolojiTuru" placeholder="Teknoloji Türü" value="<?php echo htmlspecialchars($selectedRow['teknolojiTuru']); ?>" required>
            <input type="text" name="projeDonemi" placeholder="Proje Dönemi" value="<?php echo htmlspecialchars($selectedRow['projeDonemi']); ?>" required>
            <input type="number" name="thsLevel" placeholder="THS Seviyesi" value="<?php echo htmlspecialchars($selectedRow['thsLevel']); ?>" required>
            
            <button type="submit" name="ekle" class="btn-action">Ekle</button>
            <button type="submit" name="guncelle" class="btn-action">Güncelle</button>
            <button type="submit" name="sil" class="btn-action">Sil</button>
            <a href="index.php" class="btn-home">Ana Sayfaya Dön</a>
        </form>
    </div>
    </section>

    <?php
    // Kayıt ekleme işlemi
    if(isset($_POST['ekle'])){
        $projeKodu = $_POST['projeKodu'];
        $projeAdi = $_POST['projeAdi'];
        $sorumlu = $_POST['sorumlu'];
        $tarih = $_POST['tarih'];
        $hedefThs = $_POST['hedefThs'];
        $teknolojiTuru = $_POST['teknolojiTuru'];
        $projeDonemi = $_POST['projeDonemi'];
        $thsLevel = $_POST['thsLevel'];

        $sql = "INSERT INTO sonuctablosu (projeKodu, projeAdi, sorumlu, tarih, hedefThs, teknolojiTuru, projeDonemi, thsLevel) 
                VALUES ('$projeKodu', '$projeAdi', '$sorumlu', '$tarih', '$hedefThs', '$teknolojiTuru', '$projeDonemi', '$thsLevel')";

        if($baglan->query($sql) === TRUE){
            echo "<p class='message success'>Kayıt başarıyla eklendi.</p>";
        } else {
            echo "<p class='message error'>Hata: " . $sql . "<br>" . $baglan->error."</p>";
        }
    }

    // Kayıt güncelleme işlemi
    if(isset($_POST['guncelle'])){
        $id = $_POST['id'];
        $projeKodu = $_POST['projeKodu'];
        $projeAdi = $_POST['projeAdi'];
        $sorumlu = $_POST['sorumlu'];
        $tarih = $_POST['tarih'];
        $hedefThs = $_POST['hedefThs'];
        $teknolojiTuru = $_POST['teknolojiTuru'];
        $projeDonemi = $_POST['projeDonemi'];
        $thsLevel = $_POST['thsLevel'];

        $sql = "UPDATE sonuctablosu SET projeKodu='$projeKodu', projeAdi='$projeAdi', sorumlu='$sorumlu', tarih='$tarih', 
                hedefThs='$hedefThs', teknolojiTuru='$teknolojiTuru', projeDonemi='$projeDonemi', thsLevel='$thsLevel' 
                WHERE id='$id'";

        if($baglan->query($sql) === TRUE){
            echo "<p class='message success'>Kayıt başarıyla güncellendi.</p>";
        } else {
            echo "<p class='message error'>Hata: " . $sql . "<br>" . $baglan->error."</p>";
        }
    }

    // Kayıt silme işlemi
    if(isset($_POST['sil'])){
        $id = $_POST['id'];
        $sql = "DELETE FROM sonuctablosu WHERE id='$id'";

        if($baglan->query($sql) === TRUE){
            echo "<p class='message success'>Kayıt başarıyla silindi.</p>";
        } else {
            echo "<p class='message error'>Hata: " . $sql . "<br>" . $baglan->error."</p>";
        }
    }

    $baglan->close();
    ?>

</div>

</body>
</html>