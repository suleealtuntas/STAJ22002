<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genel Mühendislik - THS-2 Soruları</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
    <h1>Genel Mühendislik THS-2 Soruları</h1>
    <div id="ths-steps">
        <span class="ths-step">THS-1</span>
        <span class="ths-step">THS-2</span>
        <span class="ths-step">THS-3</span>
        <span class="ths-step">THS-4</span>
        <span class="ths-step">THS-5</span>
        <span class="ths-step">THS-6</span>
        <span class="ths-step">THS-7</span>
        <span class="ths-step">THS-8</span>
        <span class="ths-step">THS-9</span>
    </div>

    <table>
        <!-- THS-2 için sorular ve diğer bilgiler buraya eklenecek... -->
    </table>

    <div class="footer">
        <button onclick="window.location.href='index.html';">Anasayfa</button>
        <button onclick="calculateTotal()">Hesapla</button>
        <span id="total-result">Sonuç: 0</span>
        <button id="btnNextLevel" class="btn-next-level" disabled onclick="goToNextLevel()">Bir Üst Seviyeye Geç</button>
    </div>

    <script>
        function updateOran(selectObj, soruNo) {
            const oran = selectObj.value;
            document.getElementById('oran-' + soruNo).innerText = oran;
        }

        function calculateTotal() {
            let total = 0;
            for (let i = 1; i <= 5; i++) {
                total += parseInt(document.getElementById('oran-' + i).innerText);
            }
            const result = total / 5;
            document.getElementById('total-result').innerText = 'Sonuç: ' + result.toFixed(2);

            const btnNextLevel = document.getElementById('btnNextLevel');
            if (result >= 80) {
                btnNextLevel.classList.add('active');
                btnNextLevel.disabled = false;
            } else {
                btnNextLevel.classList.remove('active');
                btnNextLevel.disabled = true;
            }
        }

        function goToNextLevel() {
            window.location.href = 'ths-3.html';  // Sonraki seviyeye yönlendirme
        }
    </script>
</body>
</html>
