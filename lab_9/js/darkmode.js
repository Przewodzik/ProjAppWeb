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

// Funkcja uruchamiana po załadowaniu strony
window.onload = () => {
    startclock(); // Uruchom zegar

    // Obsługa trybu ciemnego
    let darkmode = localStorage.getItem('darkmode'); // Pobranie ustawienia trybu ciemnego z localStorage
    const themeSwitch = document.getElementById('theme-switch'); // Pobranie elementu przełącznika trybu

    // Sprawdzenie, czy przełącznik trybu istnieje
    if (themeSwitch) {
        // Funkcja włączająca tryb ciemny
        const enableDarkmode = () => {
            document.body.classList.add('darkmode'); // Dodanie klasy "darkmode" do elementu <body>
            localStorage.setItem('darkmode', 'active'); // Zapisanie stanu do localStorage
        };

        // Funkcja wyłączająca tryb ciemny
        const disableDarkmode = () => {
            document.body.classList.remove('darkmode'); // Usunięcie klasy "darkmode" z elementu <body>
            localStorage.setItem('darkmode', 'inactive'); // Zapisanie stanu do localStorage
        };

        // Jeśli tryb ciemny jest aktywny, włącz go po załadowaniu strony
        if (darkmode === 'active') enableDarkmode();

        // Obsługa kliknięcia na przełącznik trybu
        themeSwitch.addEventListener('click', () => {
            darkmode = localStorage.getItem('darkmode'); // Pobranie aktualnego stanu
            darkmode !== 'active' ? enableDarkmode() : disableDarkmode(); // Przełącz tryb
        });
    } else {
        // Wyświetlenie błędu, jeśli przycisk przełącznika nie istnieje
        console.error("Nie znaleziono przycisku o ID 'theme-switch'");
    }
};
