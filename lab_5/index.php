<?php
$title = "Strona główna";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'home':
            $strona = 'html/glowna.html';
            $title = 'Strona Główna';
            break;
        case 'filmy':
            $strona = 'html/filmy.html';
            $title = 'Filmy';
            break;
        case 'filmiki':
            $strona = 'html/filmiki.html';
            $title = 'Filmiki';
            break;
        case 'aktorzy':
            $strona = 'html/aktorzy.html';
            $title = 'Aktorzy';
            break;
        case 'rezyserowie':
            $strona = 'html/rezyserowie.html';
            $title = 'Reżyserowie';
            break;
        case 'kontakt':
            $strona = 'html/kontakt.html';
            $title = 'Kontakt';
            break;
        default:
            echo "<p>Przepraszamy, strona nie istnieje.</p>";
            $strona = null;
            break;
    }
} else {
    $strona = 'html/glowna.html';
}

// Ładowanie nagłówków, menu, zawartości strony i stopki
include 'includes/header.php';
include 'includes/menu.php';

if ($strona && file_exists($strona)) {
    include($strona);  // Załadowanie głównej treści strony
} else {
    echo "<p>Przepraszamy, strona nie istnieje.</p>";
}

include 'includes/footer.php';
include 'includes/script.php';
?>
