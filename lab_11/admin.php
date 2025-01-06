<?php
session_start(); // Inicjalizacja sesji
ob_start(); // Włączenie buforowania wyjścia
include('includes/admin-head.html'); // Wczytanie nagłówka
include('includes/menu.php'); // Wczytanie menu
include('cfg.php'); // Wczytanie danych logowania
include('contact.php'); // Wczytanie funkcji 


 
// Funkcja generująca formularz logowania
function FormularzLogowania() {
    //Generowania formularza logowania
    $formularz = '
    <main>
        <div class="logowanie">
            <h1 class="heading">Panel CMS:</h1>
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                <div class="form-group">
                    <label for="login_email" class="log_t">Email</label>
                    <input type="text" id="login_email" name="login_email" class="logowanie" />
                </div>
                <div class="form-group">
                    <label for="login_pass" class="log_t">Hasło</label>
                    <input type="password" id="login_pass" name="login_pass" class="logowanie" />
                </div>
                <div class="form-group">
                    <button type="submit" name="x1_submit" class="logowanie">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                            <path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z"/>
                        </svg>
                        Zaloguj
                    </button>
                </div>
            </form>
            <form method="post">
                <div class="icon-text">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M480-160q-75 0-127.5-52.5T300-340q0-75 52.5-127.5T480-520q75 0 127.5 52.5T660-340q0 75-52.5 127.5T480-160ZM480-520q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM480-760q-17 0-28.5-11.5T440-800q0-17 11.5-28.5T480-840q17 0 28.5 11.5T520-800q0 17-11.5 28.5T480-760Z"/>
                    </svg>
                    <button type="submit" name="przypomnij_haslo" class="admin-button">Przypomnij hasło</button>
                </div>
            </form>
        </div>
    </main>';
    return $formularz;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        // Obsługa wylogowywania
        session_unset(); // Czyszczenie danych sesji
        session_destroy(); // Zniszczenie sesji
        header('Location: admin.php'); // Przekierowanie na stronę logowania
        exit;
    }

    $email = $_POST['login_email'] ?? '';
    $password = $_POST['login_pass'] ?? '';

    // Sprawdzenie danych logowania
    if ($email === $login && $password === $pass) {
        $_SESSION['logged_in'] = true; // Zapisanie w sesji informacji o logowaniu
    } else {
        $error_message = 'Nieprawidłowy login lub hasło!';
        echo "<div class='error'>$error_message</div>";
        FormularzLogowania();
    }
}

// Wyświetlanie zawartości po zalogowaniu lub formularza logowania
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo FormularzLogowania();
} else {
    // Wyświetlanie trzech przycisków dla zalogowanego użytkownika
    echo '
    <main>
        <div class="logged-in">
            <h1>Panel administracyjny</h1>
            <div class="admin-buttons">
                <form method="post">
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

                </form>
                <form method="post">
                    <div class="icon-text">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                        <button type="submit" name="logout" class="logout-button">Wyloguj się</button>
                    </div>
                    
                </form>
                <form method="post">
                    <button type="submit" name="przypomnij_haslo" class="admin-button">Przypomnij hasło</button>
                </form>
            </div>
        </div>
    </main>';
}


include('includes/footer.html'); // Wczytanie stopki
include('includes/script.html'); // Wczytanie skryptów
ob_end_flush(); // Wysłanie zawartości bufora
?>
