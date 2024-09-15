<?php
include 'globals.php';  // Global değişkenleri dahil et
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genel Mühendislik - THS Soruları</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Genel Mühendislik THS Soruları</h1>
    <div id="ths-steps">
        <span class="ths-step">THS-9</span>
    </div>

    <table>
        <tr>
            <th rowspan="6">THS-9</th>
            <th>Boyut</th>
            <th>Kriterler</th>
            <th>Tamamlanma Durumu</th>
            <th>Oran (%)</th>
        </tr>
        <tr>
            <td>GM 1.1</td>
            <td>Son ürün operasyonel ortamda kullanıldı mı?</td>
            <td>
                <select onchange="updateOran(this, 1)">
                    <option value="0">Başlanmadı</option>
                    <option value="20">Yeni Başlandı</option>
                    <option value="40">Başlandı, Az İlerletildi</option>
                    <option value="60">Yaklaşık Yarısı Tamamlandı</option>
                    <option value="80">Büyük Bölümü Tamamlandı</option>
                    <option value="100">Tamamlandı</option>
                </select>
            </td>
            <td id="oran-1">0</td>
        </tr>
        <tr>
            <td>GM 1.2</td>
            <td>Son ürünün performansının, operasyonel gereksinimleri karşıladığı doğrulandı mı?</td>
            <td>
                <select onchange="updateOran(this, 2)">
                    <option value="0">Başlanmadı</option>
                    <option value="20">Yeni Başlandı</option>
                    <option value="40">Başlandı, Az İlerletildi</option>
                    <option value="60">Yaklaşık Yarısı Tamamlandı</option>
                    <option value="80">Büyük Bölümü Tamamlandı</option>
                    <option value="100">Tamamlandı</option>
                </select>
            </td>
            <td id="oran-2">0</td>
        </tr>
        <tr>
            <td>GM 1.3</td>
            <td>Operasyonel gereksinimlerin karşılandığını gösteren doğrulama kayıtları dokümante edildi mi?</td>
            <td>
                <select onchange="updateOran(this, 3)">
                    <option value="0">Başlanmadı</option>
                    <option value="20">Yeni Başlandı</option>
                    <option value="40">Başlandı, Az İlerletildi</option>
                    <option value="60">Yaklaşık Yarısı Tamamlandı</option>
                    <option value="80">Büyük Bölümü Tamamlandı</option>
                    <option value="100">Tamamlandı</option>
                </select>
            </td>
            <td id="oran-3">0</td>
        </tr>
    </table>

    <div class="footer">
        <button onclick="window.location.href='index.html';" class="btn-home">Anasayfa</button>
        <button onclick="calculateTotal()" class="btn-action">Hesapla</button>
        <span id="total-result">Sonuç: 0</span>
        <button id="btnSonuc" class="btn-sonuc" disabled>Sonuç Sayfasına Git</button>
    </div>
    
    <script>
        function updateOran(selectObj, soruNo) {
            const oran = selectObj.value;
            document.getElementById('oran-' + soruNo).innerText = oran;
        }
    
        function calculateTotal() {
            let total = 0;
            let count = 0;
            for (let i = 1; i <= 3; i++) {
                const oran = parseInt(document.getElementById('oran-' + i).innerText);
                if (!isNaN(oran)) {
                    total += oran;
                    count++;
                }
            }
            const result = count > 0 ? total / count : 0;
            document.getElementById('total-result').innerText = 'Sonuç: ' + result.toFixed(2);
    
            const btnSonuc = document.getElementById('btnSonuc');
            if(result>=80){
                updateTHSLevel(9);
            }else{
                updateTHSLevel(8);
            }
            if (result >= 0) {
                btnSonuc.classList.add('active');
                btnSonuc.disabled = false;
                btnSonuc.onclick = function() {
                    window.location.href = 'panel.php';  // Sonuç sayfasına git
                };
            } else {
                btnSonuc.classList.remove('active');
                btnSonuc.disabled = true;
                btnSonuc.onclick = null;
            }
        }
        function updateTHSLevel(level) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_level.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log('THS Level updated');
                }
            };
            xhr.send('projeKodu=<?php echo $projeKodu; ?>&level=' + level);
        }
    
        window.onload = function() {
            document.getElementById('btnSonuc').disabled = true;
            
        };
        
    </script>
</body>
</html>
