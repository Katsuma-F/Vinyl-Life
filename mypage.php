<?php
ini_set('display_errors', 1);
session_start();
require('./dbconnect.php');
include('./getlog/AlwaysGetLog.php');

include('./createset.php');

include('./posts/myposts.php');

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

    <link rel="stylesheet" type="text/css" href="./css/styles.css">

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
                            <img src="UserImgLoad.php?id=<?php print(htmlspecialchars($user['id'], ENT_QUOTES)); ?>" class="rounded" alt="プロフィール画像"
                            style="width: 30px; height: 30px; margin-right: 10px">
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
        <div class="user-area">
            <div class="user-thum">
                <img src="UserImgLoad.php?id=<?php print(htmlspecialchars($user['id'], ENT_QUOTES)); ?>" class="rounded-circle" alt="プロフィール画像"
                style="width: 70px; height: 70px;">
            </div>
            <div class="user-username">
                <?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?>
            </div>
            <p class="user-sns">
                <i class="fab fa-twitter" style="margin-right: 3px"></i>
                <?php print(htmlspecialchars($user['sns_name'], ENT_QUOTES)); ?>
            </p>
        </div>
        <a href="#" class="btn btn-danger col-12 mb-4 mx-auto" data-toggle="modal" data-target="#myModal">パーツセットを作成する</a>

        <!-- My-Card-Items -->
        <div class="row">
            <?php foreach ($posts as $post): ?>
                <?php if ($_SESSION['id'] === $post['user_id']): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                        <div class="card">
                            <a href="view.php?post_id=<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>">
                                <div class="row no-gutters card-area">
                                    <img src="PostImgLoad.php?post_id=<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>" class="card-img-top"
                                    alt="投稿画像">
                                </div>
                            </a>
                            <div class="title-area">
                                <a href="view.php?post_id=<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>" class="title">
                                    <?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?>
                                </a>
                            </div>
                            <div class="profile-area">
                                <div class="profile-thum">
                                    <img src="UserImgLoad.php?id=<?php print(htmlspecialchars($post['id'], ENT_QUOTES)); ?>" class="rounded-circle"
                                    alt="プロフィール画像">
                                </div>
                                <div class="profile-username">
                                    <p class="profile-username"><?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></p>
                                </div>
                                <div class="sns-username">
                                    <p class="sns-username"><?php print(htmlspecialchars($post['sns_name'], ENT_QUOTES)); ?></p>
                                </div>
                            </div>
                            <div class="description-area"><?php print(htmlspecialchars($post['description'], ENT_QUOTES)); ?></div>
                            <div class="info-area">
                                <a href="#" class="text-primary" data-toggle="modal"
                                data-target="#myDeleteModal<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>">
                                    <i class="fas fa-trash-alt" style="margin-right: 4px;"></i>
                                    削除
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 削除のモーダル設定 -->
                    <div class="modal fade" id="myDeleteModal<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>" tabindex="-1"
                    role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">パーツセットの削除</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden">
                                        <p>本当に「<?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?>」を削除してもよろしいでしょうか？</p>
                                        <input type="hidden" name="folder_pk">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                        onclick="location.href='delete.php?post_id=<?php print(htmlspecialchars($post['post_id'], ENT_QUOTES)); ?>'"
                                        class="btn btn-danger form-control" name="delete_folder">
                                            削除
                                        </button>
                                    </div>
                                    <!-- ./modal-footer -->
                                </form>
                            </div>
                            <!-- ./modal-content -->
                        </div>
                        <!-- ./modal-dialog -->
                    </div>
                    <!-- ./modal -->
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
        <!-- ./row -->

    </div>
    <!-- ./container -->

    <!-- セット作成のモーダル設定 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">パーツセットを作成する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden">
                        <p>
                            <label for="id_file">※セットの写真：</label>
                            <input type="file" name="post_image" value="test" id="id_file" required>
                        </p>
                        <p>*写真は「.jpg」「.gif」「.png」の画像を指定してください</p>
                        <p>
                            <label for="id_title">※タイトル：</label>
                            <input type="text" name="title" class="form-control" placeholder="このセットのタイトルをご記入ください"
                            autofocus="autofocus" maxlength="50" id="id_title" required>
                        </p>
                        <p>
                            <label for="id_recordplayer">※レコードプレーヤー（ターンテーブル）：</label>
                            <input type="text" name="record_player" class="form-control" autofocus="autofocus" maxlength="50" id="id_recordplayer" required>
                        </p>
                        <p>
                            <label for="id_speaker">※スピーカー：</label>
                            <input type="text" name="speaker" class="form-control" autofocus="autofocus" maxlength="50" id="id_speaker" required>
                        </p>
                        <p>
                            <label for="id_phonoequalizer">フォノイコライザー：</label>
                            <input type="text" name="phono_equalizer" class="form-control" autofocus="autofocus" maxlength="50" id="id_phonoequalizer">
                        </p>
                        <p>
                            <label for="id_amplifier">アンプ：</label>
                            <input type="text" name="amplifier" class="form-control" autofocus="autofocus" maxlength="50" id="id_amplifier">
                        </p>
                        <p>
                            <label for="id_otherparts">その他：</label>
                            <input type="text" name="other_parts" class="form-control" placeholder="針（カートリッジ）etc."
                            autofocus="autofocus" maxlength="50" id="id_otherparts">
                        </p>
                        <p>
                            <label for="id_description">※解説：</label>
                            <textarea class="form-control" name="description" placeholder="このセットについての解説(280文字以内)"
                            autofocus="autofocus" maxlength="280" id="id_description" required></textarea>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                        <button type="submit" class="btn btn-danger" name="create_folder">作成</button>
                    </div>
                    <!-- ./modal-footer -->
                </form>
            </div>
            <!-- ./modal-content -->
        </div>
        <!-- ./modal-dialog -->
    </div>
    <!-- ./modal -->

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
