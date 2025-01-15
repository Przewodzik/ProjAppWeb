<?php


require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//Funckja do wyświetlania formularza kontaktowego
function PokazKontakt() {
    //wyświetlenie formularza kontaktowego
    echo '
    <div class="form-container">
        <form action="contact.php" method="post" class="contact-form">
            <h1>Formularz Kontaktowy</h1>
            <label for="temat">Temat:</label>
            <input type="text" id="temat" name="temat" placeholder="Wpisz temat wiadomości" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Wpisz swój e-mail" required>
            
            <label for="tresc">Wiadomość:</label>
            <textarea id="tresc" name="tresc" rows="5" placeholder="Wpisz swoją wiadomość" required></textarea>
            
            <button type="submit" name="contact-submit" >Wyślij</button>
        </form>
    </div>';
}

//Funkcja do wysyłania maila kontaktowego
function wyslijMailKontakt() {
   $mail = new PHPMailer(true);
    try {

         // Konfiguracja serwera SMTP
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'przewodowskil@gmail.com';
         $mail->Password = 'ersw iomg xzrp xmef';
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         $mail->Port = 587;

        // Ustawienie nadawcy i odbiorcy
        $mail->setFrom($_POST['email'], 'Formularz kontaktowy');
        $mail->addAddress('przewodowskil@gmail.com');


    
        //Treść wiadomości
        $mail->isHTML(true);
        $mail->Subject = $_POST['temat'];
        $mail->Body = $_POST['tresc'];

        // Wysłanie wiadomości
        $mail->send();

        echo 'Wiadomość została wysłana';
        echo '<a href="index.php">Powrót do strony głównej</a>';
    } catch (Exception $e) {
        echo 'Wiadomość nie została wysłana. Błąd: ' . $mail->ErrorInfo;
    }
        
}

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact-submit'])) {
    wyslijMailKontakt();
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
    $mail = new PHPMailer(true);

    try {

        // Konfiguracja serwera SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'przewodowskil@gmail.com';
        $mail->Password = 'ersw iomg xzrp xmef';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Ustawienie nadawcy i odbiorcy
        $mail->setFrom('przewodowskil@gmail.com','Przypomnienie hasła');
        $mail->addAddress($_POST['email']);

        // Treść wiadomości
        $mail->isHTML(true);
        $mail->Subject = 'Przypomnienie hasła';
        $mail->Body = 'Twoje hasło to: pass';

        // Wysłanie wiadomości
        $mail->send();
    } catch (Exception $e) {
        echo 'Wiadomość nie została wysłana. Błąd: ' . $mail->ErrorInfo;
    }
}
?>
