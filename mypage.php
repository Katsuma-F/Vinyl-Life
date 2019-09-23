<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();
  // ユーザー情報の取得
  $users = $db->prepare('SELECT * FROM users WHERE id=?');
  $users->execute(array($_SESSION['id']));
  $user = $users->fetch();
} else {
  header('Location: login.php');
  exit();
}

if (!empty($_POST)) {
  if ($_POST['image'] !== '' && $_POST['title'] !== '' && $_POST['description'] !== '') {
    // パーツセットの情報をデータベースに保存
    $card = $db->prepare('INSERT INTO posts SET card_image=?, title=?, description=?, user_id=?, created_at=NOW()');
    $card->execute(array(
      $_POST['image'],
      $_POST['title'],
      $_POST['description'],
      $user['id']
    ));

    header('Location: mypage.php');
    exit();
  }
}

// ログイン中のユーザーidと投稿ユーザーidの情報を照合し、パーツセットの投稿を取得
$posts = $db->query('SELECT u.name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created_at DESC');

?>

<!doctype html>
<html lang="ja">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="./css/styles.css">
  <title>Vinyl-Life</title>
  <link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="./folder/all.css">
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #FDFDFD;">
    <div class="container">
      <a class="navbar-brand text-dark" href="index.php">Vinyl-Life_img</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainMenu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-menu" href="">マイページ</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto text-dark">
          <form class="form-inline ml-auto">
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="" class="rounded" style="width: 30px; height: 30px; margin-right: 10px"><span>名前</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
                <a class="dropdown-item" href="">マイページ</a>
                <a class="dropdown-item" href="">ログアウト</a>
              </div>
            </div>
          </form>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <div class="container">
    <div class="user-area">
      <div class="user-thum">
        <img src="user_picture/<?php print(htmlspecialchars($user['picture'], ENT_QUOTES)); ?>" class="rounded-circle" alt="画像" style="width: 70px; height: 70px;">
      </div>
      <div class="user-username">
        <?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?>
      </div>
      <a href="#" target="_blank" class="user-sns">
        <i class="fab fa-twitter" style="margin-right: 3px"></i>
        @sns_acount
      </a>
      <p class="user-status">いいね獲得数: 0</p>
      <p class="user-"></p>
      <h6 class="user-description">自己紹介文。自己紹介文。自己紹介文。自己紹介文。</h6>
    </div>
      <div class="alert alert-danger alert-dismissble fade show" role="alert">
        リストがまだありません。作成ボタンからパーツセットを作成してみましょう！
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる">
          <span aria-hidden="true">×</span>
        </button>
      </div>
    <center>
      <a href="#" class="btn btn-danger col-12 mb-4 mx-auto" data-toggle="modal" data-target="#myModal">パーツセットを作成する</a>
    </center>

    <!-- リスト -->
    <div class="row">
      <?php foreach ($posts as $post): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
          <div class="card">
            <a href="#">
              <div class="row no-gutters card-area">
                <img class="card-img-top" src="">
              </div>
            </a>
            <div class="title-area">
              <a href="#" class="title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></a>
            </div>
            <div class="profile-area">
              <div class="profile-thum">
                <a href="#">
                  <img src="user_picture/<?php print(htmlspecialchars($post['picture'], ENT_QUOTES)); ?>" class="rounded-circle" alt="画像">
                </a>
              </div>
              <div class="profile-username">
                <a href="#" class="profile-username"><?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?></a>
              </div>
            </div>
            <div class="description-area">
              <p class="description"><?php print(htmlspecialchars($post['description'], ENT_QUOTES)); ?></p>
            </div>
            <div class="info-area">
              <i class="far fa-bookmark"></i>
              <span class="num">0</span>
              <i class="fas fa-heart"></i>
              <span class="num">0</span>
              <a href="#" class="text-primary" data-toggle="modal" data-target="#myEditModal58" style="margin-right: 7px;">
                <i class="fas fa-pen" style="margin-right: 7px;"></i>
                編集
              </a>
              <a href="#" class="text-primary" data-toggle="modal" data-target="#myDeleteModal58" >
                <i class="fas fa-trash-alt" style="margin-right: 4px;"></i>
                削除
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- 編集モーダルの設定 -->
      <div class="modal fade" id="myEditModal58" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">パーツセットの編集</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <input type="hidden" name="" value="">
                <p>
                  セットの写真：
                  <input type="file" name="image" value="test" size="50" id="id_file" required>
                </p>
                <p>
                  セット名
                  <input type="text" name="title" class="form-control" value="" placeholder="セットのタイトル" maxlength="50" id="id_title" required>
                </p>
                <p>
                  セットの説明
                  <textarea name="description" rows="3" cols="40" class="form-control" placeholder="このセットについての説明(280文字以内)" maxlength="280" required id="id_description"></textarea>
                </p>
                <input type="hidden" name="folder_pk" value="58">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                <button type="submit" class="btn btn-danger" name="edit_folder">作成</button>
              </div>
              <!-- ./modal-footer -->
            </form>
          </div>
          <!-- ./modal-content -->
        </div>
        <!-- ./modal-dialog -->
      </div>
      <!-- ./modal -->

      <!-- 削除のモーダル設定 -->
      <div class="modal fade" id="myDeleteModal58" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">パーツセットの削除</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form action="" method="post">
              <div class="modal-body">
                <input type="hidden" name="" value="">
                <p>("セット名")を削除してもよろしいでしょうか？</p>
                <input type="hidden" name="title" class="form-control" value="" placeholder="セットのタイトル" maxlength="50" required id="id_title">
                <input type="hidden" name="folder_pk" value="58">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger form-control" name="delete_folder">削除</button>
              </div>
              <!-- ./modal-footer -->
            </form>
          </div>
          <!-- ./modal-content -->
        </div>
        <!-- ./modal-dialog -->
      </div>
      <!-- ./modal -->

    </div>
    <!-- ./row -->

    <ul class="pagination">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">4</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>

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
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="" value="">
            <p>
              <label for="id_file">セットの写真；</label>
              <input type="file" name="image" value="test" size="50" id="id_file">
            </p>
            <p>
              <label for="id_title">Title:</label>
              <input type="text" name="title" class="form-control" placeholder="セットのタイトル" autofocus="autofocus" maxlength="50" id="id_title" required >
            </p>
            <p>
              <label for="id_description">説明文:</label>
              <textarea class="form-control" name="description" placeholder="このセットについての説明(280文字以内)" autofocus="autofocus" maxlength="280" id="id_description" required ></textarea>
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
  <footer>
    <div class="footer-upward">
      <address>© Vinyl-Life</address>
    </div>
    <div class="footer-lower">
      <a href="">ホーム</a>
      <a href="">利用規約</a>
      <a href="">プライバシーポリシー</a>
      <a href="" target="_blank">お問い合わせ</a>
    </div>
  </footer>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
