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
// Funkcja wyświetlająca listę podstron
function ListaPodstron() {
    global $link;
    $result = $link->query("SELECT * FROM page_list ORDER BY id ASC");
    echo '<table>';
    echo '<tr><th>ID</th><th>Tytuł</th><th>Status</th><th>Akcje</th></tr>';
    while ($row = $result->fetch_assoc()) {
        // Wyświetlenie wiersza tabeli z danymi podstrony
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . htmlspecialchars($row['page_title']) . '</td>
                <td>' . htmlspecialchars($row['status']) . '</td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <div class="icon-text">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                        <button type="submit" name="edit" class="save">Edytuj</button>
                        </div>
                    </form>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <div class="icon-text">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                        <button type="submit" name="delete" class="save">Usuń</button>
                        </div>
                    </form>
                </td>
            </tr>';
    }
    echo '</table>';
}


// Funkcja edycji podstrony
function EdytujPodstrone($id) {
    global $link;

    // Pobranie danych podstrony z bazy
    $query = "SELECT * FROM page_list WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Sprawdzenie, czy podstrona o podanym ID istnieje
    if ($result->num_rows === 0) {
        echo '<p>Nie znaleziono podstrony o podanym ID.</p>';
        return;
    }

    // Pobranie danych podstrony
    $page = $result->fetch_assoc();

    // Formularz edycji
    echo '
    <h1>Edytuj podstronę</h1>
    <div class="edit-form-container">
        <form method="post" class="edit-form">
            <input type="hidden" name="id" value="' . htmlspecialchars($page['id']) . '">
            <label for="page_title">Tytuł podstrony:</label>
            <input type="text" id="page_title" name="page_title" value="' . htmlspecialchars($page['page_title']) . '" required>

            <label for="page_content">Treść podstrony:</label>
            <textarea id="page_content" name="page_content" rows="10" required>' . htmlspecialchars($page['page_content']) . '</textarea>

            <label for="status">Aktywna:</label>
            <input type="checkbox" id="status" name="status" ' . ($page['status'] == 1 ? 'checked' : '') . '>

            <button type="submit" name="update">Zapisz zmiany</button>
        </form>
    </div>
    ';
}


// Funkcja dodawania nowej podstrony
function DodajNowaPodstrone() {
    global $link;

    // Obsługa formularza
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_page'])) {
        $page_title = $_POST['page_title'] ?? '';
        $page_content = $_POST['page_content'] ?? '';
        $status = isset($_POST['status']) ? 1 : 0;

        // Walidacja pól formularza
        if (!empty($page_title) && !empty($page_content)) {
            $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ssi", $page_title, $page_content, $status);

            if ($stmt->execute()) {
                // Przekierowanie po pomyślnym dodaniu podstrony
                header('Location: pages.php?success=1');
                exit; // Zakończenie skryptu po przekierowaniu
            } else {
                echo '<p class="error">Wystąpił błąd podczas dodawania podstrony.</p>';
            }
        } else {
            echo '<p class="error">Wypełnij wszystkie pola formularza!</p>';
        }
    }
    

    // Sprawdzenie komunikatu sukcesu
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<p class="success">Podstrona została dodana pomyślnie!</p>';
    }

    // Formularz dodawania nowej podstrony
    echo '
    <div class="edit-form-container">
    <form method="post" class="add-page-form">
        <h2>Dodaj nową podstronę</h2>
        <label for="page_title">Tytuł podstrony:</label>
        <input type="text" id="page_title" name="page_title" required>

        <label for="page_content">Treść podstrony:</label>
        <textarea id="page_content" name="page_content" rows="5" required></textarea>

        <label for="status">Aktywna:</label>
        <input type="checkbox" id="status" name="status" value="1">

        <button type="submit" name="add_page" class="submit-button">Dodaj podstronę</button>
    </form>
    </div>
    ';
}

// Funkcja usuwania podstrony
function UsunPodstrone($id) {
    global $link; // Połączenie do bazy danych

    // Przygotowanie zapytania SQL do usunięcia podstrony
    $query = "DELETE FROM page_list WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);

    // Wykonanie zapytania
    if ($stmt->execute()) {
        echo '<p class="success-message">Podstrona została usunięta.</p>';
    } else {
        echo '<p class="error-message">Wystąpił błąd podczas usuwania podstrony: ' . $stmt->error . '</p>';
    }

    $stmt->close();

    // Przekierowanie, aby zapobiec ponownemu wysyłaniu formularza po odświeżeniu
    header('Location: pages.php');
    exit;
}



// Obsługa edycji i usuwania podstrony
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obsługa edycji
    if (isset($_POST['edit'])) {
        $edit_id = intval($_POST['id']); // Pobranie ID podstrony
        EdytujPodstrone($edit_id); // Wywołanie metody EdytujPodstrone()
    }

    // Obsługa usuwania
    if (isset($_POST['delete'])) {
        $delete_id = intval($_POST['id']); // Pobranie ID podstrony
        UsunPodstrone($delete_id); // Wywołanie funkcji usuwania z ID
    }
}


// Obsługa zapisu zmian
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $page_title = $_POST['page_title'];
    $page_content = $_POST['page_content'];
    $status = isset($_POST['status']) ? 1 : 0;

    $query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ssii", $page_title, $page_content, $status, $id);

    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
}

echo '<h1>Lista podstron</h1>';
ListaPodstron(); // Wywołanie funkcji wyświetlającej listę podstron
DodajNowaPodstrone(); // Wywołanie funkcji dodającej nową podstronę


include('includes/footer.html'); // Wczytanie stopki
include('includes/script.html'); // Wczytanie skryptów
ob_end_flush(); // Opuść bufor wyjścia i wyświetl zawartość strony
?>
