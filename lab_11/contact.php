<?php

//Funckja do wyświetlania formularza kontaktowego
function PokazKontakt() {
    //wyświetlenie formularza kontaktowego
    echo '
    <div class="form-container">
        <form action="contact.php" method="post">
            <h1>Formularz Kontaktowy</h1>
            <label for="temat">Temat:</label>
            <input type="text" id="temat" name="temat" placeholder="Wpisz temat wiadomości" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Wpisz swój e-mail" required>
            
            <label for="tresc">Wiadomość:</label>
            <textarea id="tresc" name="tresc" rows="5" placeholder="Wpisz swoją wiadomość" required></textarea>
            
            <button type="submit">Wyślij</button>
        </form>
    </div>';
}

//Funkcja do wysyłania maila kontaktowego
function wyslijMailKontakt($odbiorca) {
    // Sprawdzenie, czy wszystkie pola zostały wypełnione
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[Nie wypełniłeś wszystkich pól]';
        return;
    }

    // Walidacja e-maila
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo '[Nieprawidłowy adres e-mail]';
        return;
    }

    // Pobieranie danych z formularza
    $temat = htmlspecialchars($_POST['temat']);
    $tresc = htmlspecialchars($_POST['tresc']);
    $nadawca = htmlspecialchars($_POST['email']);

    // Nagłówki wiadomości
    $header = "From: Formularz kontaktowy <$nadawca>\r\n";
    $header .= "Reply-To: $nadawca\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: text/plain; charset=utf-8\r\n";

    // Wysłanie wiadomości
    if (mail($odbiorca, $temat, $tresc, $header)) {
        echo '[Wiadomość została wysłana pomyślnie]';
    } else {
        echo '[Błąd wysyłania wiadomości]';
    }
}

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Podaj adres e-mail odbiorcy, np. Twój e-mail
    wyslijMailKontakt('odbiorca@example.com');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['przypomnij_haslo'])) {
    // Wyświetl formularz wprowadzenia e-maila
    echo '
    <div class="edit-form-container">
    <form method="post" class="password-form">
        <label for="email">Podaj swój adres e-mail:</label>
        <input type="email" id="email" name="email" placeholder="Wpisz swój adres e-mail" required>
        <button type="submit" name="wyslij_haslo">Wyślij przypomnienie hasła</button>
    </form>
    </div>';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wyslij_haslo'])) {
    // Obsługa wysyłki przypomnienia hasła
    PrzypomnijHaslo();
}

// Funkcja do wysyłania przypomnienia hasła
function PrzypomnijHaslo() {
    // Sprawdzenie, czy adres e-mail został podany
    if (empty($_POST['email'])) {
        echo '[Nie podano adresu e-mail]';
        return;
    }

    // Walidacja e-maila
    $email = htmlspecialchars($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '[Nieprawidłowy adres e-mail]';
        return;
    }

    // Uproszczone hasło
    $password = 'pass';

    // Przygotowanie danych e-maila
    $subject = 'Przypomnienie hasła do panelu admina';
    $message = "Twoje hasło do panelu admina to: $password";
    $headers = "From: noreply@twojadomena.pl\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    // Wysłanie wiadomości
    if (mail($email, $subject, $message, $headers)) {
        echo '[Hasło zostało wysłane na podany adres e-mail]';
    } else {
        echo '[Błąd wysyłania wiadomości]';
    }
}
?>
