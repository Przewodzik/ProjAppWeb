<?php
include 'cfg.php';
include 'showpage.php';
include 'contact.php';

$title = "Strona główna";
$content = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'kontakt') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_start();
            wyslijMailKontakt("odbiorca@example.com");
            $content = ob_get_clean();
        } else {
            ob_start();
            PokazKontakt();
            $content = ob_get_clean();
        }
        $title = "Kontakt";
    } elseif ($action === 'przypomnij_haslo') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_start();
            PrzypomnijHaslo("admin@example.com");
            $content = ob_get_clean();
        } else {
            ob_start();
            PokazPrzypomnijHaslo();
            $content = ob_get_clean();
        }
        $title = "Przypomnienie hasła";
    } else {
        $content = "<p>Nieznana akcja!</p>";
    }
} elseif (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $pageData = PokazPodstrone($id);

    if ($pageData['content'] && $pageData['content'] !== '[nie_znaleziono_strony]') {
        $title = $pageData['title'];
        $content = $pageData['content'];
    } else {
        $content = "<p>Przepraszamy, strona nie istnieje.</p>";
    }
} else {
    header('Location: index.php?id=1');
    exit();
}

include 'includes/header.php';
include 'includes/menu.php';

if ($content) {
    echo $content;
} else {
    echo "<p>Przepraszamy, strona nie istnieje.</p>";
}

include 'includes/footer.php';
include 'includes/script.php';
?>
