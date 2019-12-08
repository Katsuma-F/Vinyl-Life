<?php
// ログイン中＆セッションタイムアウトでなければ、ログインを継続させる
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    // ログイン中のユーザー情報の取得
    $sql = 'SELECT * FROM users WHERE id = ?';
    $users = $db->prepare($sql);
    $users->execute(array($_SESSION['id']));
    $user = $users->fetch();
} else {
    header('Location: logout.php');
    exit();
}

?>
