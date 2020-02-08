<?php
session_start();
require('./dbconnect.php');
include('./getlog/AlwaysGetLog.php');

if (empty($_REQUEST['post_id'])) {
    header('Location: index.php');
    exit();
}

$sql = 'SELECT u.id, u.name, u.sns_name, p.* FROM users u, posts p WHERE u.id = p.user_id AND p.post_id = ?';
$posts = $db->prepare($sql);
$posts->execute(array($_REQUEST['post_id']));

?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/styles.css">

    <link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="./folder/all.css">

    <title>Vinyl-Life</title>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand text-light" href="./index.php">
                <img src="./img/music_chikuonki.png" width="40" height="40" class="d-inline-block align-top" alt="Logo">
                Vinyl-Life
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false"
            aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <li class="nav-item">
                            <a class="nav-link" href="./mypage.php">マイページ</a>
                        </li>
                    </li>
                </ul>
                <ul class="navbar-nav justify-content-end my-2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="UserImgLoad.php?id=<?php print(htmlspecialchars($user['id'], ENT_QUOTES)); ?>" class="rounded"
                            alt="プロフィール画像" style="width: 30px; height: 30px; margin-right: 10px">
                            <span><?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userMenu">
                            <a class="dropdown-item" href="./mypage.php">マイページ</a>
                            <a class="dropdown-item" href="./logout.php">ログアウト</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main -->
    <div class="container">
        <!-- Card-Items -->
        <div class="row justify-content-center">
            <?php if ($post = $posts->fetch()): ?>
                <div class="col-12 col-sm-12 col-md-10 col-lg-8">
                    <div class="card">
                        <div class="row no-gutters card-area" style="height: 470px !important;">
                            <img src="PostImgLoad.php?post_id=<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>" class="card-img-top" alt="投稿画像">
                        </div>
                        <div class="title-area" style="height: 60px !important;">
                            <p class="title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="profile-area">
                            <div class="profile-thum">
                                <img src="UserImgLoad.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像">
                            </div>
                            <div class="profile-username">
                                <p class="profile-username"><?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></p>
                            </div>
                            <div class="sns-username">
                                <p class="sns-username"><?php print(htmlspecialchars($post['sns_name'], ENT_QUOTES)); ?></p>
                            </div>
                        </div>
                        <div class="record-player-area">
                            <p class="record-player">レコードプレーヤー（ターンテーブル）：<?php print(htmlspecialchars($post['record_player'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="speaker-area">
                            <p class="speaker">スピーカー：<?php print(htmlspecialchars($post['speaker'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="phono-equalizer-area">
                            <p class="phono-equalizer">フォノイコライザー：<?php print(htmlspecialchars($post['phono_equalizer'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="amplifier-area">
                            <p class="amplifier">アンプ：<?php print(htmlspecialchars($post['amplifier'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="other-parts-area">
                            <p class="other-parts">その他：<?php print(htmlspecialchars($post['other_parts'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="description-area" style="height: 205px !important;">
                            <p class="description"><?php print(htmlspecialchars($post['description'], ENT_QUOTES)); ?></p>
                        </div>
                        <div class="info-area"></div>
                    </div>
                </div>
            <?php else: ?>
                <p>その投稿は削除されたか、URLが間違えています</p>
            <?php endif; ?>

        </div>
        <!-- ./row -->

    </div>
    <!-- ./container -->

    <!-- Footer -->
    <div class="footer">
        <div class="footer-upward">
            <address>© Vinyl-Life</address>
        </div>
        <div class="footer-lower">
            <a href="./index.php">ホーム</a>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
