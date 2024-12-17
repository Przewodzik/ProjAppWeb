<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <header>
        <h1>Panel Administracyjny</h1>
    </header>
    <main>
        <?php
        session_start();
        require_once '../cfg.php';

        $conn = new mysqli('localhost', 'root', '', 'moja_strona');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        function FormularzLogowania() {
            return '<div class="logowanie">
                <h1 class="heading">Panel CMS</h1>
                <form method="post" action="' . htmlspecialchars($_SERVER['REQUEST_URI']) . '">
                    <label for="login_email">Login:</label>
                    <input type="text" name="login_email" required>
                    <label for="login_pass">Hasło:</label>
                    <input type="password" name="login_pass" required>
                    <button type="submit">Zaloguj</button>
                </form>
            </div>';
        }

        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_email'], $_POST['login_pass'])) {
                if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
                    $_SESSION['logged_in'] = true;
                } else {
                    echo FormularzLogowania();
                    exit;
                }
            } else {
                echo FormularzLogowania();
                exit;
            }
        }

        function PokazKategorie($parent_id = 0) {
            global $conn;
            // Pobierz kategorie, które mają określony parent_id
            $stmt = $conn->prepare("SELECT * FROM kategorie WHERE matka = ? ORDER BY id ASC");
            $stmt->bind_param("i", $parent_id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            // Tworzenie tabeli
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>ID</th><th>Nazwa</th><th>Matka</th><th>Akcje</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . htmlspecialchars($row['nazwa']) . '</td>
                            <td>' . ($row['matka'] == 0 ? 'Brak (Główna kategoria)' : $row['matka']) . '</td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="' . $row['id'] . '">
                                    <button type="submit" name="edit_category" class="save">Edytuj</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="' . $row['id'] . '">
                                    <button type="submit" name="delete_category" class="save">Usuń</button>
                                </form>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="parent_id" value="' . $row['id'] . '">
                                    <button type="submit" name="view_subcategories" class="save">Zobacz podkategorie</button>
                                </form>
                            </td>
                          </tr>';
                }
                echo '</table>';
            } else {
                echo '<p>Brak kategorii do wyświetlenia.</p>';
            }
            $stmt->close();
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['view_subcategories'])) {
            $parent_id = intval($_POST['parent_id']);
            echo '<h2>Podkategorie</h2>';
            PokazKategorie($parent_id);
            echo '<form method="post" style="margin-top: 10px;">
                    <button type="submit" name="back_to_main_categories" class="save">Powrót do głównych kategorii</button>
                  </form>';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['back_to_main_categories'])) {
            echo '<h2>Główne kategorie</h2>';
            PokazKategorie(); // Domyślnie pokaż główne kategorie
        } else {
            echo '<h2>Główne kategorie</h2>';
            PokazKategorie(); // Domyślnie pokaż główne kategorie
        }
        

        function DodajKategorie() {
            echo '<form method="post" class="form-container">
                    <label for="category_name">Nazwa kategorii:</label>
                    <input type="text" name="category_name" required>
                    <label for"category_mother">Matka kategori:</label>
                    <input type="text" name="category_mother" required>
                    <button type="submit" name="add_category" class="save">Dodaj kategorię</button>
                </form>';
        }

        function EdytujKategorie($id) {
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM kategorie WHERE id = ? LIMIT 1");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo '<form method="post" class="form-container">
                    <label for="category_name">Nazwa kategorii:</label>
                    <input type="text" name="category_name" value="' . htmlspecialchars($row['nazwa']) . '" required>
                    <label for="category_mother">Kategoria nadrzędna:</label>
                    <input type="text" name="category_mother" value="' . htmlspecialchars($row['matka']) . '" required>
                    <input type="hidden" name="id" value="' . $id . '">
                    <button type="submit" name="save_category_changes" class="save">Zapisz zmiany</button>
                  </form>
                  <form method="post" style="margin-top: 10px;">
                    <button type="submit" name="back_to_categories" class="save">Wstecz</button>
                  </form>';
            $stmt->close();
        }
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_category']) && isset($_POST['id'])) {
                $id = intval($_POST['id']);
                $stmt = $conn->prepare("DELETE FROM kategorie WHERE id = ? LIMIT 1");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
            }

            if (isset($_POST['edit_category']) && isset($_POST['id'])) {
                $id = intval($_POST['id']);
                EdytujKategorie($id);
                exit;
            }

            if (isset($_POST['save_category_changes']) && isset($_POST['id'])) {
                $id = intval($_POST['id']);
                $category_name = $_POST['category_name'];
                $category_mother = intval($_POST['category_mother']); // Pobierz wartość matki z formularza
            
                $stmt = $conn->prepare("UPDATE kategorie SET nazwa = ?, matka = ? WHERE id = ? LIMIT 1");
                $stmt->bind_param("sii", $category_name, $category_mother, $id); // Zmienione, aby uwzględnić matkę
                $stmt->execute();
                $stmt->close();
            }

            if (isset($_POST['add_category'])) {
                $category_name = $_POST['category_name'];
                $category_mother = isset($_POST['category_mother']) ? intval($_POST['category_mother']) : 0; // Domyślnie 0, jeśli nie podano wartości
                $stmt = $conn->prepare("INSERT INTO kategorie (nazwa, matka) VALUES (?, ?)");
                $stmt->bind_param("si", $category_name, $category_mother);
                $stmt->execute();
                $stmt->close();
            }
            
        }
        function ListaPodstron() {
            global $conn;
            $result = $conn->query("SELECT * FROM page_list ORDER BY id ASC");
            echo '<table>';
            echo '<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>';
            while ($row = $result->fetch_assoc()) {
                // Tabela z listą podstron
                echo '<tr>
                        <td>' . $row['id'] . '</td>
                        <td>' . htmlspecialchars($row['page_title']) . '</td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <button type="submit" name="edit" class="save">Edytuj</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                <button type="submit" name="delete" class="save">Usuń</button>
                            </form>
                        </td>
                    </tr>';
            }
            echo '</table>';
        }

        // Funkcja wyświetlająca formularz edycji podstrony
        function EdytujPodstrone($id) {
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM page_list WHERE id = ? LIMIT 1");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo '<form method="post" class="form-container">
                    <label for="page_title">Tytuł:</label>
                    <input type="text" name="page_title" value="' . htmlspecialchars($row['page_title']) . '" required>
                    <label for="page_content">Treść:</label>
                    <textarea name="page_content" required>' . htmlspecialchars($row['page_content']) . '</textarea>
                    <label for="status">
                        <input type="checkbox" name="status" ' . ($row['status'] ? 'checked' : '') . '> Aktywna
                    </label>
                    <input type="hidden" name="id" value="' . $id . '">
                    <button type="submit" name="save_changes" class="save">Zapisz zmiany</button>
                </form>';
            $stmt->close();
        }

        // Obsługa żądań POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete']) && isset($_POST['id'])) {
                // Usuwanie podstrony
                $id = intval($_POST['id']);
                $stmt = $conn->prepare("DELETE FROM page_list WHERE id = ? LIMIT 1");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();
            }

            if (isset($_POST['edit']) && isset($_POST['id'])) {
                // Wyświetlenie formularza edycji
                $id = intval($_POST['id']);
                EdytujPodstrone($id);
                exit;
            }

            if (isset($_POST['save_changes']) && isset($_POST['id'])) {
                // Zapisanie zmian
                $id = intval($_POST['id']);
                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];
                $status = isset($_POST['status']) ? 1 : 0;
                $stmt = $conn->prepare("UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ? LIMIT 1");
                $stmt->bind_param("ssii", $page_title, $page_content, $status, $id);
                $stmt->execute();
                $stmt->close();
            }

            if (isset($_POST['add_new_page'])) {
                // Dodanie nowej podstrony
                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];
                $status = isset($_POST['status']) ? 1 : 0;
                $stmt = $conn->prepare("INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $page_title, $page_content, $status);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Funkcja wyświetlająca formularz dodawania nowej podstrony
        function DodajNowaPodstrone() {
            echo '<form method="post" class="form-container">
                    <label for="page_title">Tytuł:</label>
                    <input type="text" name="page_title" required>
                    <label for="page_content">Treść:</label>
                    <textarea name="page_content" required></textarea>
                    <label for="status">
                        <input type="checkbox" name="status"> Aktywna
                    </label>
                    <button type="submit" name="add_new_page" class="save">Dodaj podstronę</button>
                </form>';
        }

        // Wyświetlenie sekcji z listą podstron
        echo '<section>';
        echo '<a href="../index.php" class="button">Powrót do strony głównej</a>';
        echo '</section>';
        echo '<section>';
        echo '<h2>Lista podstron</h2>';
        ListaPodstron();
        echo '</section>';

        // Wyświetlenie sekcji z formularzem dodawania nowej podstrony
        echo '<section>';
        echo '<h2>Dodaj nową podstronę</h2>';
        DodajNowaPodstrone();
        echo '</section>';


        echo '<section>';
        echo '<h2>Dodaj nową kategorię</h2>';
        DodajKategorie();
        echo '</section>';

        $conn->close();
        ?>
    </main>
    <footer class="footer-container">
        <p>&copy; 2024 Panel Administracyjny</p>
    </footer>
</body>
</html>