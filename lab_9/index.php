<?php
// Dołączenie plików konfiguracyjnych i funkcji
include 'cfg.php'; // Plik konfiguracyjny
include 'showpage.php'; // Plik z funkcjami do wyświetlania stron
include 'contact.php'; // Plik z funkcjami obsługi formularzy kontaktowych

// Ustawienie domyślnego tytułu i zawartości strony
$title = "Strona główna";
$content = '';

// Obsługa akcji przesłanej przez parametr GET
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Obsługa akcji 'kontakt'
    if ($action === 'kontakt') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Przetwarzanie formularza kontaktowego (wysyłanie e-maila)
            ob_start(); // Buforowanie wyjścia
            wyslijMailKontakt("odbiorca@example.com");
            $content = ob_get_clean(); // Pobranie zawartości bufora
        } else {
            // Wyświetlenie formularza kontaktowego
            ob_start();
            PokazKontakt();
            $content = ob_get_clean();
        }
        $title = "Kontakt"; // Ustawienie tytułu strony
    }
    // Obsługa akcji 'przypomnij_haslo'
    elseif ($action === 'przypomnij_haslo') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Przetwarzanie formularza przypomnienia hasła
            ob_start();
            PrzypomnijHaslo("admin@example.com");
            $content = ob_get_clean();
        } else {
            // Wyświetlenie formularza przypomnienia hasła
            ob_start();
            PokazPrzypomnijHaslo();
            $content = ob_get_clean();
        }
        $title = "Przypomnienie hasła"; // Ustawienie tytułu strony
    }
    // Obsługa nieznanej akcji
    else {
        $content = "<p>Nieznana akcja!</p>";
    }
}
// Obsługa parametru 'id' do wyświetlenia podstrony
elseif (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // Bezpieczne rzutowanie ID na liczbę całkowitą
    $pageData = PokazPodstrone($id); // Pobranie danych
    // Wyświetlenie treści podstrony, jeśli istnieje
    if ($pageData['content'] && $pageData['content'] !== '[nie_znaleziono_strony]') {
        $title = $pageData['title']; // Ustawienie tytułu podstrony
        $content = $pageData['content']; // Pobranie zawartości podstrony
    } else {
        // Komunikat o błędzie, jeśli podstrona nie istnieje
        $content = "<p>Przepraszamy, strona nie istnieje.</p>";
    }
}
// Przekierowanie na stronę główną w przypadku braku akcji lub ID
else {
    header('Location: index.php?id=1');
    exit(); // Zakończenie skryptu po przekierowaniu
}

// Dołączenie plików nagłówka i menu strony
include 'includes/header.php'; // Plik nagłówka HTML
include 'includes/menu.php'; // Plik z menu nawigacyjnym

// Wyświetlenie zawartości strony
if ($content) {
    echo $content; 
} else {
    echo "<p>Przepraszamy, strona nie istnieje.</p>"; // Domyślny komunikat o błędzie
}

// Dołączenie plików stopki i skryptów JS
include 'includes/footer.php'; // Plik stopki HTML
include 'includes/script.php'; // Plik zewnętrznych skryptów JS
?>
