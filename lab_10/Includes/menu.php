a<header>
    <h1><?php echo htmlspecialchars($title); ?></h1>
    <button id='theme-switch'>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z"/>
        </svg>
    </button>
    <nav>
        <img src="Images/oscar_logo.png" alt="logo" class="logo"/>
        <?php
      
      require_once 'cfg.php'; // Wczytanie pliku konfiguracyjnego, w tym zmiennej $link

      $query = "SELECT id, page_title FROM page_list WHERE status = 1 ORDER BY id ASC";
      // Zapytanie SQL do pobrania ID i tytułów aktywnych stron
      
      if ($result = mysqli_query($link, $query)) { 
          // Wykonanie zapytania SQL
          
          while ($row = mysqli_fetch_assoc($result)) { 
              // Iteracja przez wyniki zapytania 
              
              echo '<a href="index.php?id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['page_title']) . '</a>';
              // Generowanie odnośników na podstawie wyników
          }
          // Zwolnienie pamięci wyniku zapytania
          mysqli_free_result($result); 
          
          // Odnośnik do podstrony kontaktowej
          echo '<a href="index.php?action=kontakt">Kontakt</a>';

          // Odnośnik do strony przypominania hasła 
          echo '<a href="index.php?action=przypomnij_haslo">Przypomnij hasło</a>';

          // Odnośnik do panelu administracyjnego
          echo '<a href="admin/admin.php">Panel Administracyjny</a>';


           

      } else {
          echo '<p>Błąd w zapytaniu: ' . htmlspecialchars(mysqli_error($link)) . '</p>';
          // Obsługa błędu zapytania
      }

        
        ?>
        <div class="time-box">
            <div id="zegarek"></div>
            <div id="data"></div> 
        </div>
    </nav>
</header>
