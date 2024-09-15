<?php
// updateLevel.php
include("baglanti.php"); // Veritabanı bağlantısını yapın

if (isset($_POST['level'])) {
    $level = $_POST['level'];
    
    // Seviye güncelleme SQL sorgusu
    $sql = "UPDATE sonuctablosu SET thsLevel='$level' WHERE id=1"; // Burada ID'yi dinamik hale getirmeyi unutmayın

    if ($baglan->query($sql) === TRUE) {
        echo "Level updated successfully";
    } else {
        echo "Error updating level: " . $baglan->error;
    }

    $baglan->close();
}
?>
