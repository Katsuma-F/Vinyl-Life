<?php
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    // ログイン中のユーザー情報の取得
    $users = $db->prepare('SELECT * FROM users WHERE id=?');
    $users->execute(array($_SESSION['id']));
    $user = $users->fetch();
} else {
    header('Location: logout.php');
    exit();
}

?>