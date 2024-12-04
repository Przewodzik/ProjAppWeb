<?php
// Funkcja wyświetlająca formularz kontaktowy
function PokazKontakt() {
    ?>
    <div class="box">
        <div class="form-container">
            <h1>Formularz Kontaktowy</h1>
            <!-- Formularz kontaktowy -->
            <form method="post" action="?action=kontakt" name="myForm">
                <!-- Pole tekstowe do wpisania tematu -->
                <input type="text" name="temat" placeholder="Temat: " required>
                <!-- Pole tekstowe do wpisania treści wiadomości -->
                <textarea rows="10" name="tresc" placeholder="Treść wiadomości ..." required></textarea>
                <!-- Pole tekstowe do wpisania adresu e-mail -->
                <input type="email" name="email" placeholder="Twój e-mail: " required>
                <!-- Przycisk wysyłający formularz -->
                <button type="submit">Wyślij</button>
            </form>
        </div>
    </div>
    <?php
}

// Funkcja wyświetlająca formularz przypominania hasła
function PokazPrzypomnijHaslo() {
    ?>
    <div class="box">
        <div class="form-container">
            <h1>Przypomnij Hasło</h1>
            <!-- Formularz do przypominania hasła -->
            <form method="post" action="?action=przypomnij_haslo" name="passwordForm">
                <!-- Pole tekstowe do wpisania adresu e-mail -->
                <input type="email" name="email" placeholder="Podaj swój e-mail: " required>
                <!-- Przycisk wysyłający formularz -->
                <button type="submit">Przypomnij Hasło</button>
            </form>
        </div>
    </div>
    <?php
}

// Funkcja do wysyłania wiadomości kontaktowej na podany adres e-mail
function wyslijMailKontakt($odbiorca) {
    // Sprawdzenie, czy wszystkie wymagane pola zostały wypełnione
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo "Nie wypełniłeś wszystkich pól!";
        return; // Zatrzymanie funkcji, jeśli dane są niekompletne
    }

    // Tworzenie wiadomości e-mail na podstawie danych z formularza
    $mail['subject'] = $_POST['temat'];
    $mail['body'] = $_POST['tresc'];
    $mail['sender'] = $_POST['email'];
    $mail['recipient'] = $odbiorca;

    // Ustawienie nagłówków e-maila
    $header  = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <" . $mail['sender'] . ">\n";

    // Wysłanie wiadomości e-mail
    if (mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
        echo "Wiadomość została wysłana.";
    } else {
        echo "Nie udało się wysłać wiadomości. Spróbuj ponownie.";
    }
}

// Funkcja do wysyłania przypomnienia hasła na podany adres e-mail
function PrzypomnijHaslo($odbiorca) {
    // Ustawienie domyślnego hasła do przypomnienia
    $haslo = "pass";

    // Sprawdzenie, czy adres e-mail został podany
    if (empty($_POST['email'])) {
        echo "Nie podano adresu email!";
        return; // Zatrzymanie funkcji, jeśli e-mail nie został wypełniony
    }

    // Tworzenie wiadomości e-mail z przypomnieniem hasła
    $mail['subject'] = "Przypomnienie hasła";
    $mail['body'] = "Twoje hasło do panelu administracyjnego to: $haslo";
    $mail['sender'] = "noreply@example.com"; // Nadawca wiadomości
    $mail['recipient'] = $odbiorca;

    // Ustawienie nagłówków e-maila
    $header  = "From: Formularz przypomnienia hasła <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";

    // Wysłanie wiadomości e-mail z hasłem
    if (mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
        echo "Hasło zostało wysłane na adres: " . htmlspecialchars($mail['recipient']);
    } else {
        echo "Nie udało się wysłać wiadomości. Spróbuj ponownie.";
    }
}
?>
