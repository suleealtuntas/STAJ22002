function updateQuestions() {
    const teknolojiTuru = document.getElementById('teknoloji-turu').value;
    const questionsContainer = document.getElementById('questions-container');

    questionsContainer.innerHTML = '';

    if (teknolojiTuru === 'genel-muhendislik.html') {
        questionsContainer.innerHTML = `
            <h3>Genel Mühendislik Soruları:</h3>
            <label for="soru1-genel">Soru 1:</label><br>
            <input type="radio" id="baslanmadi-genel" name="soru1" value="0">
            <label for="baslanmadi-genel">Başlanmadı</label><br>
            <input type="radio" id="yenibaslandi-genel" name="soru1" value="20">
            <label for="yenibaslandi-genel">Yeni Başlandı</label><br>
            <!-- Diğer seçenekler... -->
        `;
    } else if (teknolojiTuru === 'yazilim.html') {
        questionsContainer.innerHTML = `
            <h3>Yazılım Soruları:</h3>
            <label for="soru1-yazilim">Soru 1:</label><br>
            <input type="radio" id="baslanmadi-yazilim" name="soru1" value="0">
            <label for="baslanmadi-yazilim">Başlanmadı</label><br>
            <input type="radio" id="yenibaslandi-yazilim" name="soru1" value="20">
            <label for="yenibaslandi-yazilim">Yeni Başlandı</label><br>
            <!-- Diğer seçenekler... -->
        `;
    }
}

function navigateToNextPage() {
    const teknolojiTuru = document.getElementById('teknoloji-turu').value;
    
    if (teknolojiTuru === 'genel-muhendislik') {
        window.location.href = 'genel-muhendislik.html';
    } else if (teknolojiTuru === 'yazilim') {
        window.location.href = 'yazilim.html';
    } else {
        alert('Lütfen bir teknoloji türü seçin.');
    }
}
