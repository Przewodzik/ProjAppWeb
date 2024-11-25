<?php
include 'cfg.php';
include 'showpage.php';

$title = "Strona główna";
$content = '';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $pageData = PokazPodstrone($id);

    if ($pageData['content'] && $pageData['content'] !== '[nie_znaleziono_strony]') {
        $title = $pageData['title'];
        $content = $pageData['content'];
    } else {
        echo "<p>Przepraszamy, strona nie istnieje.</p>";
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
