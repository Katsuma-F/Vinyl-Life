<?php
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['card_id'];

    $cards = $db->prepare('SELECT * FROM posts WHERE card_id = ?');
    $cards->execute(array($id));
    $card = $cards->fetch();

    if ($card['user_id'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM posts WHERE card_id = ?');
        $del->execute(array($id));
    }
}

header('Location: mypage.php');
exit();

?>
