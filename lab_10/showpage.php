<?php
/**
 * Funkcja pobierająca dane podstrony na podstawie jej ID.
 *
 * @param int $id ID podstrony.
 */
function PokazPodstrone($id) {
    global $link; // Użycie globalnej zmiennej połączenia z bazą danych

    // Rzutowanie ID na liczbę całkowitą 
    $id_clear = (int) $id;

    // Przygotowanie zapytania SQL do pobrania danych podstrony
    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";

    // Wykonanie zapytania SQL
    $result = mysqli_query($link, $query);

    // Pobranie wyniku zapytania 
    $row = mysqli_fetch_array($result);

    // Sprawdzenie, czy podstrona istnieje w bazie danych
    if (empty($row['id'])) {
        // Zwrócenie domyślnych wartości, jeśli podstrona nie istnieje
        return [
            'content' => '[nie_znaleziono_strony]', // Komunikat o braku strony
            'title' => 'Strona nie znaleziona' // Tytuł informujący o błędzie
        ];
    } else {
        // Zwrócenie zawartości i tytułu podstrony
        return [
            'content' => $row['page_content'], // Treść podstrony
            'title' => $row['page_title'] // Tytuł podstrony
        ];
    }
}
?>
