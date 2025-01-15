<?php
session_start();

// Nagłówki i menu
include('includes/head.html');
include('includes/menu.php');
include('cfg.php');

// Wyświetlenie koszyka
function PokazKoszyk() {
    include('cfg.php'); // Połączenie z bazą danych

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<p>Koszyk jest pusty.</p>";
        return;
    }


    echo '<table border="1">';
    echo '<tr><th>Nazwa</th><th>Zdjęcie</th><th>Cena</th><th>Ilość</th><th>Wartość</th><th>Akcje</th></tr>';

    $total = 0;
    foreach ($_SESSION['cart'] as $index => $item) {
        $subtotal = $item['price_brutto'] * $item['quantity'];
        $total += $subtotal;

        // Pobierz maksymalną ilość produktu z bazy danych
        $max_quantity = 1; // Domyślna wartość
        if (isset($item['id'])) { // Upewnij się, że ID produktu jest w koszyku
            global $link;
            $query = "SELECT stock_quantity, image FROM products WHERE id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("i", $item['id']); // Przypisz ID produktu
            $stmt->execute();
            $stmt->bind_result($max_quantity, $image); // Zwiąż kolumny stock_quantity i image
            $stmt->fetch();
            $stmt->close();
        }
        

        echo '<tr>';
        echo '<td>' . htmlspecialchars($item['title']) . '</td>';
        echo '<td>';
        if ($image) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" alt="Obraz" style="max-width:100px; max-height:100px;">';
        } else {
            echo 'Brak obrazu';
        }
        echo '</td>';
        echo '<td>' . number_format($item['price_brutto'], 2) . ' PLN</td>';
        echo '<td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="action" value="update_quantity">
                    <input type="hidden" name="index" value="' . $index . '">
                    <input type="number" name="quantity" value="' . $item['quantity'] . '" min="1" max="' . $max_quantity . '" style="width: 50px;">
                    <button type="submit" class="items-button">Zmień</button>
                </form>
              </td>';
        echo '<td>' . number_format($subtotal, 2) . ' PLN</td>';
        echo '<td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="index" value="' . $index . '">
                    <button type="submit" class="items-button">Usuń</button>
                </form>
              </td>';
        echo '</tr>';
    }

    echo '<tr><td colspan="3"><strong>Łączna wartość:</strong></td><td>' . number_format($total, 2) . ' PLN</td><td></td></tr>';
    echo '</table>';

    $link->close(); // Zamknij połączenie z bazą danych
}

// Obsługa akcji usuwania i zmiany ilości
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'remove') {
        $index = intval($_POST['index']);
        if (isset($_SESSION['cart'][$index])) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            echo "<p style='color: green;'>Produkt został usunięty z koszyka.</p>";
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update_quantity') {
        $index = intval($_POST['index']);
        $quantity = intval($_POST['quantity']);
        if (isset($_SESSION['cart'][$index]) && $quantity > 0) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
            echo "<p style='color: green;'>Ilość produktu została zmieniona.</p>";
        }
    }
}

// Wywołanie funkcji koszyka
PokazKoszyk();

// Stopka i skrypty
include('includes/footer.html');
include('includes/script.html');
?>
