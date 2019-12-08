<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
}

if (!empty($_POST)) {
    $user = $db->prepare('INSERT INTO users SET name = ?, sns_name = ?, user_id = ?, password = ?, picture_type = ?, picture_content = ?, created_at = NOW()');
    $user->execute(array(
        $_SESSION['join']['name'],
        $_SESSION['join']['sns_name'],
        $_SESSION['join']['user_id'],
        sha1($_SESSION['join']['password']),
        $_SESSION['join']['picture_type'],
        $_SESSION['join']['profile_picture']
    ));

    unset($_SESSION['join']);
    header('Location: thanks.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/styles.css">

    <title>Vinyl-Life</title>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand text-light" href="../index.php">
                <img src="../img/record_player.png" width="40" height="40" class="d-inline-block align-top" alt="Logo">
                Vinyl-Life
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="mx-auto w-75">
            <h1 style="margin-bottom: 35px;">会員登録</h1>
            <form action="" method="post">
                <input type="hidden" name="action" value="submit">
                <dl>
                    <dt>ユーザー名</dt>
                    <dd><?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></dd>
                    <dt>SNSアカウント名</dt>
                    <dd><?php print(htmlspecialchars($_SESSION['join']['sns_name'], ENT_QUOTES)); ?></dd>
                    <dt>ユーザーid</dt>
                    <dd><?php print(htmlspecialchars($_SESSION['join']['user_id'], ENT_QUOTES)); ?></dd>
                    <dt>パスワード</dt>
                    <dd>【表示されません】</dd>
                    <dt>プロフィール写真</dt>
                    <?php if ($_SESSION['join']['profile_picture'] != ''): ?>
                        <dd>【表示されません】</dd>
                    <?php else: ?>
                        <dd style="color: #ff0019; !important">※ファイルが選択されていません</dd>
                    <?php endif; ?>
                </dl>
                <a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
                <button class="btn btn-danger" type="submit" value="登録する">登録する</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-upward">
            <address>© Vinyl-Life</address>
        </div>
        <div class="footer-lower">
            <a href="../index.php">ホーム</a>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
