<?php
include 'globals.php';  // Global değişkenleri dahil et
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yazılım - THS Soruları</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Buton stili */
        .btn-next-level {
            background-color: gray;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
            opacity: 0.5;
            transition: background-color 0.3s;
        }

        .btn-next-level.active {
            background-color: green;
            cursor: pointer;
            opacity: 1;
        }
    </style>
</head>
<body>
    <h1>Yazılım THS Soruları</h1>
    <div id="ths-steps">
        
        <span class="ths-step">THS-6</span>
        
    </div>

    <table>
        <tr>
            <th rowspan="6">THS-6</th>
            <th>Boyut</th>
            <th>Kriterler</th>
            <th>Tamamlanma Durumu</th>
            <th>Oran (%)</th>
        </tr>
        <tr>
            <td>GM 1.1</td>
            <td>Yazılımın prototip uygulamalarının, tam ölçekteki gerçekçi problemler üzerinde fiziki gösterimleri yapıldı mı? (Demonstration)



            </td>
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
            <td>Yazılım algoritmaları, mevcut donanım/yazılım sistemleri ile entegre edildi mi?



            </td>
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
            <td>Yazılım geliştirme belgeleri(kullanıcı belgeleri, bakım belgeleri, eğitim belgeleri) hazırlanmaya başlandı mı?



            </td>
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
        <tr>
            <td>GM 1.4</td>
            <td>Zamanlama kısıtlarının (timing contraints) ve yazılım prototipinin mühendislik fizibilte analizi tamamlanarak fiziki gösterimi yapıldı mı? (Demonstration)


            </td>
            <td>
                <select onchange="updateOran(this, 4)">
                    <option value="0">Başlanmadı</option>
                    <option value="20">Yeni Başlandı</option>
                    <option value="40">Başlandı, Az İlerletildi</option>
                    <option value="60">Yaklaşık Yarısı Tamamlandı</option>
                    <option value="80">Büyük Bölümü Tamamlandı</option>
                    <option value="100">Tamamlandı</option>
                </select>
            </td>
            <td id="oran-4">0</td>
        </tr>
        
    </table>

    <div class="footer">
        <button onclick="window.location.href='index.html';">Anasayfa</button>
        <button onclick="calculateTotal()">Hesapla</button>
        <span id="total-result">Sonuç: 0</span>
        <button id="btnNextLevel" class="btn-next-level" disabled>Bir Üst Seviyeye Geç</button>
        <button id="btnSonuc" class="btn-next-level" disabled>Sonuç Sayfasına Git</button>
    </div>
    
    <script>
        function updateOran(selectObj, soruNo) {
            const oran = selectObj.value;
            document.getElementById('oran-' + soruNo).innerText = oran;
        }
    
        function calculateTotal() {
            let total = 0;
            let count = 0;
            for (let i = 1; i <= 4; i++) {
                const oran = parseInt(document.getElementById('oran-' + i).innerText);
                if (!isNaN(oran)) {
                    total += oran;
                    count++;
                }
            }
            const result = count > 0 ? total / count : 0;
            document.getElementById('total-result').innerText = 'Sonuç: ' + result.toFixed(2);
    
            const btnNextLevel = document.getElementById('btnNextLevel');
            const btnSonuc = document.getElementById('btnSonuc');
    
            if (result >= 80) {
                // "Bir Üst Seviyeye Geç" butonunu aktif et
                updateTHSLevel(6);
                btnNextLevel.classList.add('active');
                btnNextLevel.disabled = false;
                btnNextLevel.onclick = function() {
                    window.location.href = 'yazilim7.php';  // İkinci seviyeye git
                };
    
                // "Sonuç Sayfasına Git" butonunu pasif tut
                btnSonuc.classList.remove('active');
                btnSonuc.disabled = true;
                btnSonuc.onclick = null;
            } else {
                // "Bir Üst Seviyeye Geç" butonunu pasif et
                btnNextLevel.classList.remove('active');
                btnNextLevel.disabled = true;
                btnNextLevel.onclick = null;
    
                // "Sonuç Sayfasına Git" butonunu aktif et
                btnSonuc.classList.add('active');
                btnSonuc.disabled = false;
                btnSonuc.onclick = function() {
                    window.location.href = 'panel.php';  // Sonuç sayfasına git
                };
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
    
        // Sayfa yüklendiğinde butonların pasif olması için başlangıçta hepsini pasif yap
        window.onload = function() {
            document.getElementById('btnNextLevel').disabled = true;
            document.getElementById('btnSonuc').disabled = true;
        };
    </script>
</body>
</html>
