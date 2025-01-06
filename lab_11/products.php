
<?php


session_start(); // Inicjalizacja sesji
ob_start(); // Włączenie buforowania wyjścia
include('includes/admin-head.html'); // Wczytanie nagłówka
include('cfg.php'); // Wczytanie pliku konfiguracyjnego

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jeśli użytkownik nie jest zalogowany, przekieruj na stronę logowania
    header('Location: admin.php');
    exit;
}
// Obsługa wylogowania
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: admin.php'); // Przekierowanie na stronę logowania
    exit;
}

// Menu panelu administracyjnego
echo '
    <div class="menu">
        <h1>Panel Administracyjny</h1>
    </div>
    <nav>
         <div class="icon-text">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M620-163 450-333l56-56 114 114 226-226 56 56-282 282Zm220-397h-80v-200h-80v120H280v-120h-80v560h240v80H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v200ZM480-760q17 0 28.5-11.5T520-800q0-17-11.5-28.5T480-840q-17 0-28.5 11.5T440-800q0 17 11.5 28.5T480-760Z"/></svg>
            <button type="button" class="admin-button" onclick="window.location.href=\'products.php\'">Produkty</button>
        </div>
        <div class="icon-text">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z"/></svg>
            <button type="button" class="admin-button" onclick="window.location.href=\'categories.php\'">Kategorie</>
        </div>
        <div class="icon-text">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M640-160v-360H160v360h480Zm80-200v-80h80v-360H320v200h-80v-200q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v360q0 33-23.5 56.5T800-360h-80ZM160-80q-33 0-56.5-23.5T80-160v-360q0-33 23.5-56.5T160-600h480q33 0 56.5 23.5T720-520v360q0 33-23.5 56.5T640-80H160Zm400-603ZM400-340Z"/></svg>
            <button type="button" class="admin-button" onclick="window.location.href=\'pages.php\'">Strony</button>
        </div>
        <div class="icon-text">
            <form method="post">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                <button type="submit" name="logout" class="logout-button">Wyloguj się</button>
            </form>
        </div>
        <button id="theme-switch">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                    <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                    <path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"/>
                </svg>
            </button>
            <div class="icon-text">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M360-840v-80h240v80H360Zm80 440h80v-240h-80v240Zm40 320q-74 0-139.5-28.5T226-186q-49-49-77.5-114.5T120-440q0-74 28.5-139.5T226-694q49-49 114.5-77.5T480-800q62 0 119 20t107 58l56-56 56 56-56 56q38 50 58 107t20 119q0 74-28.5 139.5T734-186q-49 49-114.5 77.5T480-80Zm0-80q116 0 198-82t82-198q0-116-82-198t-198-82q-116 0-198 82t-82 198q0 116 82 198t198 82Zm0-280Z"/></svg>
                <div class="time-box">
                    <div id="zegarek"></div>
                    <div id="data"></div> 
                </div>
            </div>
    </nav>
';

//Edycja produktów

function EdytujProdukt($id){
    global $link;

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result = $stmt->get_result();

    $product = $result->fetch_assoc();

    //Formularz edycji produktu
    echo '
        <h1>Edytuj produkt</h1>
        <div class="edit-form-container">
            <form method="post" class="edit-form">
                <input type="hidden" name="id" value="' . $product['id'] . '">
                
                <label for"item_name">Przedmiot:</label>
                <input type="text" name="item_name" value="' . $product['title'] . '" required>
                
                <label for="description">Opis:</label>
                <textarea name="description" required>' . $product['description'] . '</textarea>

                <label for="expiration_date">Data wygaśnięcia:</label>  
                <input type="date" name="expiration_date" value="' . $product['expiration_date'] . '">

                <label for="price_net">Cena netto:</label>
                <input type="number" name="price_net" value="' . $product['price_net'] . '" step="0.01" required>

                <label for="vat_rate">VAT:</label>
                <input type="number" name="vat_rate" value="' . $product['vat_rate'] . '" step="0.01" required>

                <label for="stock_quantity">Ilość:</label>
                <input type="number" name="stock_quantity" value="' . $product['stock_quantity'] . '" required>

                <label for="availability_status">Dostępność:</label>
                <select name="availability_status" required>
                    <option value="1" ' . ($product['availability_status'] ? 'selected' : '') . '>Dostępny</option>
                    <option value="0" ' . (!$product['availability_status'] ? 'selected' : '') . '>Niedostępny</option>
                </select>

                <label for="category_id">Kategoria:</label>
                <input type="number" name="category_id" value="' . $product['category_id'] . '" required>

                <label for="product_size">Rozmiar:</label>
                <input type="text" name="product_size" value="' . $product['product_size'] . '">


                <button type="submit" name="update">Zapisz Zmiany</button>
            </form>
        </div>
    
    ';
}

//Obsługa edycji produktów
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    EdytujProdukt($_POST['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {

    $id = intval($_POST['id']);
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $expiration_date = $_POST['expiration_date'];
    $price_net = floatval($_POST['price_net']);
    $vat_rate = intval($_POST['vat_rate']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $availability_status = intval($_POST['availability_status']);
    $category_id = intval($_POST['category_id']);
    $product_size = $_POST['product_size'];

    $query = "UPDATE products SET title = ?, description = ?, expiration_date = ?, price_net = ?, vat_rate = ?, stock_quantity = ?, availability_status = ?, category_id = ?, product_size = ? WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('sssdiiiiii',$item_name,$description,$expiration_date,$price_net,$vat_rate,$stock_quantity,$availability_status,$category_id,$product_size,$id);
    $stmt->execute();

    header('Location: products.php');
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
                <th>ID</th>
                <th>Przedmiot</th>
                <th>Opis</th>
                <th>Utworzono</th>
                <th>Edytowano</th>
                <th>Data wygaśnięcia</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Ilość</th>
                <th>Dostępność</th>
                <th>Kategoria</th>
                <th>Rozmiar</th>
                <th>Obraz</th>
                <th>Akcje</th>
              </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . htmlspecialchars($row['title']) . '</td>
                    <td>' . htmlspecialchars($row['description']) . '</td>
                    <td>' . htmlspecialchars($row['created_at']) . '</td>
                    <td>' . htmlspecialchars($row['updated_at']) . '</td>
                    <td>' . ($row['expiration_date'] ? htmlspecialchars($row['expiration_date']) : 'Brak') . '</td>
                    <td>' . number_format($row['price_net'], 2) . ' PLN</td>
                    <td>' . $row['vat_rate'] . ' %</td>
                    <td>' . $row['stock_quantity'] . '</td>
                    <td>' . ($row['availability_status'] ? 'Dostępny' : 'Niedostępny') . '</td>
                    <td>' . $row['category_id'] . '</td>
                    <td>' . htmlspecialchars($row['product_size']) . '</td>
                    <td>';
            if ($row['image']) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Obraz" style="max-width:100px; max-height:100px;">';
            } else {
                echo 'Brak obrazu';
            }
            echo '</td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="' . $row['id'] . '">
                            <button type="submit" name="edit_product" class="save">Edytuj</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="' . $row['id'] . '">
                            <button type="submit" name="delete_product" class="save">Usuń</button>
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

function DodajNowyProdukt(){
    global $link;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
        $item_name = $_POST['item_name'];
        $description = $_POST['description'];
        $expiration_date = $_POST['expiration_date'];
        $price_net = floatval($_POST['price_net']);
        $vat_rate = intval($_POST['vat_rate']);
        $stock_quantity = intval($_POST['stock_quantity']);
        $availability_status = intval($_POST['availability_status']);
        $category_id = intval($_POST['category_id']);
        $product_size = $_POST['product_size'];

        $query = "INSERT INTO products (title, description, expiration_date, price_net, vat_rate, stock_quantity, availability_status, category_id, product_size) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('sssdiiiss',$item_name,$description,$expiration_date,$price_net,$vat_rate,$stock_quantity,$availability_status,$category_id,$product_size);
        $stmt->execute();

        header('Location: products.php');
        exit;
    }
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Wywołanie funkcji
PokazProdukty($page);


// Formularz dodania nowego produkty
echo '
    <div class="edit-form-container">
    <form method="post" class="add-page-form">
        <h2>Dodaj nowy produkt</h2>

        <label for="item_name">Przedmiot:</label>
        <input type="text" name="item_name" required>

        <label for="description">Opis:</label>
        <textarea name="description" required></textarea>

        <label for="expiration_date">Data wygaśnięcia:</label>
        <input type="date" name="expiration_date">

        <label for="price_net">Cena netto:</label>
        <input type="number" name="price_net" step="0.01" required>

        <label for="vat_rate">VAT:</label>
        <input type="number" name="vat_rate" step="0.01" required>

        <label for="stock_quantity">Ilość:</label>
        <input type="number" name="stock_quantity" required>

        <label for="availability_status">Dostępność:</label>
        <select name="availability_status" required>
            <option value="1">Dostępny</option>
            <option value="0">Niedostępny</option>
        </select>

       <label for="category_id">Kategoria:</label>
        <select name="category_id" id="category_id" required>
            <option value="" disabled selected>Wybierz kategorię</option>
            <option value="1">Filmy</option>
            <option value="2">Gadżety</option>
            <option value="3">Akcja</option>
            <option value="4">Komedia</option>
            <option value="5">Dramat</option>
            <option value="6">Odzież</option>
            <option value="7">Akcesoria</option>
            <option value="8">Koszulki</option>
            <option value="9">Bluzy</option>
            <option value="10">Figurki</option>
            <option value="11">Pluszaki</option>
            <option value="12">Kubki</option>
            <option value="13">Breloki</option>
        </select>

        <label for="product_size">Rozmiar:</label>
        <input type="text" name="product_size">

        <button type="submit" name="add_product">Dodaj Produkt</button>
    </form>
    </div>
';

//Funkcja usuwania produktu

function UsunProdukt($id){
    global $link;

    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('i',$id);
    $stmt->execute();

    $stmt->close();

    header('Location: products.php');

    exit;
}

//Obsługa usuwania produktu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    UsunProdukt($_POST['id']);
}

// Wywołanie funkcji DodajNowyProdukt
DodajNowyProdukt();

ob_end_flush(); // Wysłanie bufora wyjścia
?>