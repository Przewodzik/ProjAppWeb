
<?php
    session_start();
    include('includes/head.html');// Plik zawierający nagłówek strony
    include('includes/menu.php');// Plik zawierający menu
    include('cfg.php'); // Plik zawierający połączenie z bazą danych



    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
        // Pobranie ID produktu z formularza
        $product_id = intval($_POST['id']);
        
        // Pobranie danych produktu z bazy danych
        $stmt = mysqli_prepare($link, "SELECT id, title, price_net, vat_rate FROM products WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    
        if ($product) {
            // Jeśli koszyk nie istnieje, inicjalizujemy go
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
    
            // Sprawdzamy, czy produkt jest już w koszyku
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] === $product['id']) {
                    $item['quantity'] += 1; // Zwiększamy ilość, jeśli produkt już istnieje
                    $found = true;
                    break;
                }
            }
    
            // Jeśli produkt nie jest jeszcze w koszyku, dodajemy go
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'price_brutto' => $product['price_net'] * (1 + $product['vat_rate'] / 100),
                    'quantity' => 1,
                ];
            }
    
            
        } 
    }
    

    function PokazProdukty($page_number = 1) {
        global $link; // Użycie globalnej zmiennej $link do połączenia z bazą danych
    
        // Liczba produktów na stronę
        $products_per_page = 8;
    
        // Obliczanie offsetu
        $offset = ($page_number - 1) * $products_per_page;
    
        // Liczenie całkowitej liczby produktów
        $stmt_total = mysqli_prepare($link, "SELECT COUNT(*) AS total FROM products");
        mysqli_stmt_execute($stmt_total);
        $result_total = mysqli_stmt_get_result($stmt_total);
        $total_products = mysqli_fetch_assoc($result_total)['total'];
        mysqli_stmt_close($stmt_total);
    
        // Obliczanie liczby stron
        $total_pages = ceil($total_products / $products_per_page);
    
        // Pobieranie produktów dla bieżącej strony
        $stmt = mysqli_prepare($link, "SELECT * FROM products LIMIT ? OFFSET ?");
        mysqli_stmt_bind_param($stmt, "ii", $products_per_page, $offset);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        // Tworzenie tabeli
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Cena</th>
                    <th>Obraz</th>
                    <th>Akcje</th>
                  </tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['title']) . '</td>
                        <td>' . htmlspecialchars($row['description']) . '</td>
                        <td>' . number_format($row['price_net'] + ($row['price_net'] * $row['vat_rate']/100), 2) . ' PLN</td>
                        <td>';
                if ($row['image']) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Obraz" style="max-width:100px; max-height:100px;">';
                } else {
                    echo 'Brak obrazu';
                }
                echo '</td>
                        <td>
                            <form method="post" style="display:inline; class="add-to-cart">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <div class="icon-text">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M440-600v-120H320v-80h120v-120h80v120h120v80H520v120h-80ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/></svg>
                                <button type="submit" name="add_to_cart" class="items-button">Dodaj do koszyka</button>
                                </div>
                            </form>
                        </td>
                      </tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Brak produktów do wyświetlenia.</p>';
        }
        mysqli_stmt_close($stmt);

        // Wyświetlenie numerów stron
    echo '<div style="margin-top: 10px;">Strony: ';
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<a href="?page=' . $i . '">' . $i . '</a> ';
    }
    echo '</div>';
}





$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Wywołanie funkcji
PokazProdukty($page);


    include('includes/footer.html');
    include('includes/script.html');
?>