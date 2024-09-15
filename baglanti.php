<?php

$vt_sunucu = "localhost"; // Sunucu adı
$vt_kullanici = "root";    // Kullanıcı adı
$vt_sifre = "";            // Şifre (boş bırakılmış)
$vt_adi = "ths_olcum_formu"; // Veritabanı adı

// Veritabanına bağlanma
$baglan = mysqli_connect($vt_sunucu, $vt_kullanici, $vt_sifre, $vt_adi);

// Bağlantıyı kontrol etme
if (!$baglan) {
    die("Veritabanı bağlantı işlemi başarısız: " . mysqli_connect_error());
}

// Bağlantı başarılı ise, bağlantı kurulduğunu belirten bir mesaj göster
echo "Bağlantı başarılı";

// Bağlantıyı kapatma (bu genellikle kullanılmaz ama bağlantı kapatılmalıdır)
// mysqli_close($baglan);

?>
