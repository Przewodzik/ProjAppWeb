<?php
function PokazKontakt() {
    ?>
    <div class="box">
        <div class="form-container">
            <h1>Formularz Kontaktowy</h1>
            <form method="post" action="?action=kontakt" name="myForm">
                <input type="text" name="temat" placeholder="Temat: " required>
                <textarea rows="10" name="tresc" placeholder="Treść wiadomości ..." required></textarea>
                <input type="email" name="email" placeholder="Twój e-mail: " required>
                <button type="submit">Wyślij</button>
            </form>
        </div>
    </div>
    <?php
}

function PokazPrzypomnijHaslo() {
    ?>
    <div class="box">
        <div class="form-container">
            <h1>Przypomnij Hasło</h1>
            <form method="post" action="?action=przypomnij_haslo" name="passwordForm">
                <input type="email" name="email" placeholder="Podaj swój e-mail: " required>
                <button type="submit">Przypomnij Hasło</button>
            </form>
        </div>
    </div>
    <?php
}

function wyslijMailKontakt($odbiorca) {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo "Nie wypełniłeś wszystkich pól!";
        return; // Zatrzymanie funkcji w przypadku braku danych
    }

    $mail['subject'] = $_POST['temat'];
    $mail['body'] = $_POST['tresc'];
    $mail['sender'] = $_POST['email'];
    $mail['recipient'] = $odbiorca;

    $header  = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <" . $mail['sender'] . ">\n";

    if (mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
        echo "Wiadomość została wysłana.";
    } else {
        echo "Nie udało się wysłać wiadomości. Spróbuj ponownie.";
    }
}

function PrzypomnijHaslo($odbiorca) {
    $haslo = "pass";

    if (empty($_POST['email'])) {
        echo "Nie podano adresu email!";
        return; // Zatrzymanie funkcji w przypadku braku adresu email
    }

    $mail['subject'] = "Przypomnienie hasła";
    $mail['body'] = "Twoje hasło do panelu administracyjnego to: $haslo";
    $mail['sender'] = "noreply@example.com"; // Nadawca wiadomości
    $mail['recipient'] = $odbiorca;

    $header  = "From: Formularz przypomnienia hasła <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";

    if (mail($mail['recipient'], $mail['subject'], $mail['body'], $header)) {
        echo "Hasło zostało wysłane na adres: " . htmlspecialchars($mail['recipient']);
    } else {
        echo "Nie udało się wysłać wiadomości. Spróbuj ponownie.";
    }
}
?>
