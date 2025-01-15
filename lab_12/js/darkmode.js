// Funkcja wyświetlająca dzisiejszą datę w formacie DD/MM/YYYY
function gettheDate() {
    var Todays = new Date(); // Pobranie bieżącej daty
    var TheDate = "" + Todays.getDate() + "/" + (Todays.getMonth() + 1) + "/" + Todays.getFullYear(); // Formatowanie daty
    document.getElementById("data").innerHTML = TheDate; // Wstawienie daty do elementu o ID "data"
}

var timerID = null; // Przechowuje ID timera
var timerRunning = false; // Flaga wskazująca, czy zegar działa

// Funkcja zatrzymująca zegar
function stopclock() {
    clearTimeout(timerID); // Anulowanie timeoutu
    timerRunning = false; // Aktualizacja flagi
}

// Funkcja uruchamiająca zegar
function startclock() {
    stopclock(); // Upewnij się, że poprzedni zegar został zatrzymany
    gettheDate(); // Wyświetl dzisiejszą datę
    showtime(); // Uruchom funkcję wyświetlającą czas
}

// Funkcja wyświetlająca bieżący czas w formacie 12-godzinnym
function showtime() {
    var now = new Date(); // Pobranie bieżącego czasu
    var hours = now.getHours(); // Pobranie godziny
    var minutes = now.getMinutes(); // Pobranie minut
    var seconds = now.getSeconds(); // Pobranie sekund

    // Formatowanie czasu
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours); // Godziny w formacie 12-godzinnym
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes; // Dodanie minut
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds; // Dodanie sekund
    timeValue += (hours >= 12) ? " P.M." : " A.M."; // Dodanie oznaczenia AM/PM

    // Wyświetlenie czasu w elemencie o ID "zegarek"
    document.getElementById("zegarek").innerHTML = timeValue;

    // Ustawienie timera, aby funkcja uruchamiała się co sekundę
    timerID = setTimeout(showtime, 1000);
    timerRunning = true; // Aktualizacja flagi
}

// Funkcja przełączająca tryb ciemny i jasny
document.addEventListener('DOMContentLoaded', function() {
    const themeSwitch = document.getElementById('theme-switch');
    const currentTheme = localStorage.getItem('theme') || 'light';

    if (currentTheme === 'dark') {
        document.body.classList.add('darkmode');
    }

    themeSwitch.addEventListener('click', function() {
        document.body.classList.toggle('darkmode');
        const theme = document.body.classList.contains('darkmode') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
    });

    // Uruchomienie zegara po załadowaniu dokumentu
    startclock();
});