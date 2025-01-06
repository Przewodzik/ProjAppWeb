<?php 
function PokazPodstrone($id) {
    global $link;
    $id_clear = htmlspecialchars($id); // Zabezpieczenie przed XSS

    // Sprawdzenie, czy id odpowiada stronie kontaktowej
    if ($id_clear === 'contact') {
        return [
            'content' => PokazKontakt(), // Wywołanie funkcji formularza kontaktowego
            'title' => 'Kontakt'
        ];
    }

    // Pobierz dane strony z bazy danych
    $query = "SELECT * FROM page_list WHERE id = '$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);

    $row = mysqli_fetch_array($result);

    // Sprawdź, czy strona istnieje
    if (empty($row['id'])) {
        return [
            'content' => 'Nie znaleziono strony.',
            'title' => 'Błąd 404'
        ];
    }

    return [
        'content' => $row['page_content'],
        'title' => $row['page_title']
    ];
}


?>