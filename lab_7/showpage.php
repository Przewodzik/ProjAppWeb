<?php
function PokazPodstrone($id) {
    global $link;
    $id_clear = (int) $id;

    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    if (empty($row['id'])) {
        return [
            'content' => '[nie_znaleziono_strony]',
            'title' => 'Strona nie znaleziona'
        ];
    } else {
        return [
            'content' => $row['page_content'],
            'title' => $row['page_title']
        ];
    }
}
?>
