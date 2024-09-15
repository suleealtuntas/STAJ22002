<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THS Sonuçları</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>THS Sonuçları</h1>
    <?php
    // Veritabanı bağlantısı
    include("baglanti.php");

    // URL'den level parametresini al
    if (isset($_GET['level'])) {
        $level = intval($_GET['level']);
        echo "<p>Şu anda seviyedesiniz: THS-$level</p>";
        
        // THS seviyesini görüntülemek için burada ek bilgiler de gösterebilirsiniz
        // Örneğin:
        if ($level < 9) {
            echo "<p>Bir sonraki seviyeye geçmek için tamamlamanız gereken THS seviyeleri: " . ($level + 1) . "</p>";
        } else {
            echo "<p>En yüksek seviyeye ulaştınız!</p>";
        }
    } else {
        echo "<p>THS seviyesi belirlenemedi.</p>";
    }
    ?>
    <a href="index.php">Ana Sayfaya Dön</a>
</body>
</html>
