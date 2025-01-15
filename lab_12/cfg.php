<?php 
    $dbhost = 'localhost'; //zmienna przechowująca adres serwera
    $dbuser = 'root'; //zmienna przechowująca nazwę użytkownika
    $dbpass = ''; //zmienna przechowująca hasło
    $dbname = 'moja_strona'; //zmienna przechowująca nazwę bazy danych
    $login = 'admin'; //zmienna przechowująca login do panelu administracyjnego
    $pass = 'pass'; // zmienna przechowująca hasło do panelu administracyjnego


    //połączenie z bazą danych
    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


    //sprawdzenie połączenia z bazą danych
    if (!$link) {
        //jeśli nie udało się połączyć z bazą danych wyświetl komunikat
        die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
    }
    //jeśli udało się połączyć z bazą danych wyświetl komunikat
    if (!mysqli_select_db($link, $dbname)) {
        echo 'nie wybrano bazy';
    }
?>