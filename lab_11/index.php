<?php

include('includes/head.html');// Plik zawierający nagłówek strony
include('includes/menu.php');// Plik zawierający menu
include('cfg.php'); // Plik zawierający połączenie z bazą danych
include('showpage.php'); // Plik zawierający funkcję PokazPodstrone
include('contact.php'); // Plik zawierający funkcję PokazKontakt

// Pobranie parametru idp z URL
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '1';

// Pobranie zawartości podstrony z bazy danych
$page_data = PokazPodstrone($id);
$page_content = $page_data['content'];
$page_title = $page_data['title'];

?>
    <!-- Dynamiczne ładowanie treści -->
    <?php

        // Wyświetlanie zawartości podstrony
        echo $page_content;

    include('includes/footer.html');
    include('includes/script.html');
    ?>