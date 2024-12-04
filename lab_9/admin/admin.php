<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- Deklaracja kodowania i ustawienia responsywności -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <!-- Podłączenie zewnętrznego pliku stylów -->
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <!-- Nagłówek strony -->
    <header>
        <h1>Panel Administracyjny</h1>
    </header>
    <main>
        <?php
        // Rozpoczęcie sesji
        session_start();
        // Dołączenie pliku konfiguracyjnego z ustawieniami bazy danych
        require_once '../cfg.php';

        // Połączenie z bazą danych
        $conn = new mysqli('localhost', 'root', '', 'moja_strona');
        // Sprawdzenie połączenia
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Funkcja generująca formularz logowania
        function FormularzLogowania() {
            return '
            <div class="logowanie">
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

        // Sprawdzenie, czy użytkownik jest zalogowany
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_email'], $_POST['login_pass'])) {
                // Weryfikacja loginu i hasła
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

        // Funkcja wyświetlająca listę podstron
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
        echo '<h2>Lista podstron</h2>';
        ListaPodstron();
        echo '</section>';

        // Wyświetlenie sekcji z formularzem dodawania nowej podstrony
        echo '<section>';
        echo '<h2>Dodaj nową podstronę</h2>';
        DodajNowaPodstrone();
        echo '</section>';

        // Zamknięcie połączenia z bazą danych
        $conn->close();
        ?>
    </main>
    <!-- Stopka strony -->
    <footer class="footer-container">
        <p>&copy; 2024 Panel Administracyjny</p>
    </footer>
</body>
</html>
