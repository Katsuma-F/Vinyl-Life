<?php
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id'])) {
    $id = $_REQUEST['post_id'];

    $sql = 'SELECT * FROM posts WHERE post_id = ?';
    $posts = $db->prepare($sql);
    $posts->execute(array($id));
    $post = $posts->fetch();

    if ($post['user_id'] == $_SESSION['id']) {
        $sql = 'DELETE FROM posts WHERE post_id = ?';
        $del = $db->prepare($sql);
        $del->execute(array($id));
    }
}

header('Location: mypage.php');
exit();

?>
