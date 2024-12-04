<?php
// Ustawienia połączenia z bazą danych
$dbhost = 'localhost'; // Adres hosta bazy danych
$dbuser = 'root'; // Nazwa użytkownika bazy danych
$dbpass = ''; // Hasło użytkownika bazy danych
$baza = 'moja_strona'; // Nazwa bazy danych, do której chcemy się połączyć

// Ustawienia domyślnego logowania
$login = 'admin'; // Domyślny login administratora
$pass = 'pass'; // Domyślne hasło administratora

// Tworzenie połączenia z bazą danych
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);

// Sprawdzenie, czy połączenie z bazą danych powiodło się
if (!$link) {
    // Jeśli połączenie się nie udało, wyświetlenie komunikatu o błędzie i zakończenie działania skryptu
    die('<b>Przerwane połączenie: </b>' . mysqli_connect_error());
}

// Połączenie zostało pomyślnie nawiązane
?>
