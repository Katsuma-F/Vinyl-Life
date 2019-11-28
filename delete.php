<?php
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['post_id'];

    $posts = $db->prepare('SELECT * FROM posts WHERE post_id = ?');
    $posts->execute(array($id));
    $post = $posts->fetch();

    if ($post['user_id'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM posts WHERE post_id = ?');
        $del->execute(array($id));
    }
}

header('Location: mypage.php');
exit();

?>
