<?php
session_start();
require('dbconnect.php');
require('./getlog/getlogged-inuser.php');

require('createset.php');

require('paging.php');
require('posts.php');

?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="./css/styles.css">

  <link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="./folder/all.css">

  <title>Vinyl-Life</title>
</head>
<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand text-light" href="index.php">
        <img src="" width="30" height="30" class="d-inline-block align-top" alt="">
        Vinyl-Life
      </a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainMenu">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <li class="nav-item">
              <?php if (isset($_SESSION['id'])): ?>
                <a class="nav-link" href="mypage.php">マイページ</a>
              <?php endif; ?>
            </li>
          </li>
        </ul>
        <form class="form-inline justify-content-end">
          <?php if (!isset($_SESSION['id'])): ?>
            <a href="login.php" class="btn btn-outline-secondary mr-3">ログイン</a>
            <a href="join/index.php" class="btn btn-outline-danger my-2">新規登録</a>
          <?php endif; ?>
        </form>
        <ul class="navbar-nav justify-content-end my-2">
          <li class="nav-item dropdown">
            <?php if (isset($_SESSION['id'])): ?>
              <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="user_picture/<?php print(htmlspecialchars($user['picture'], ENT_QUOTES)); ?>" class="rounded" style="width: 30px; height: 30px; margin-right: 10px">
                <span><?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?></span>
              </a>
              <div class="dropdown-menu" aria-labelledby="userMenu">
                <a class="dropdown-item" href="mypage.php">マイページ</a>
                <a class="dropdown-item" href="logout.php">ログアウト</a>
              </div>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Top-Heading -->
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <center>
        <h1 class="main-message mb-4">今すぐアナログレコードのある生活を始めよう！</h1>
        <h6 class="sub-message mb-5">アナログレコードを聴くために必要なパーツセットをシェアするサービスです。</h6>
        <form>
          <?php if (!isset($_SESSION['id'])): ?>
            <a href="join/index.php" class="btn btn-info btn-lg" value="/">
              <i class="far fa-registered"></i>
              会員登録する
            </a>
          <?php endif; ?>
        </form>
      </center>
    </div>
  </div>

  <!-- Main -->
  <div class="container">
    <!-- Card-Items -->
    <div class="row">
      <?php foreach ($posts as $post): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
          <div class="card">
            <a href="view.php?card_id=<?php print(htmlspecialchars($post['card_id'])); ?>">
              <div class="row no-gutters card-area">
                <img src="card_image/<?php print(htmlspecialchars($post['card_image'], ENT_QUOTES)); ?>" class="card-img-top">
              </div>
            </a>
            <div class="title-area">
              <a href="view.php?card_id=<?php print(htmlspecialchars($post['card_id'])); ?>" class="title"><?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?></a>
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
              <div class="sns-username">
                <p class="sns-username"><?php print(htmlspecialchars($post['sns_name'], ENT_QUOTES)); ?></p>
              </div>
            </div>
            <div class="description-area">
              <p class="description"><?php print(htmlspecialchars($post['description'], ENT_QUOTES)); ?></p>
            </div>
            <div class="info-area">
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
    <!-- ./row -->

    <!-- Pagination -->
    <ul class="pagination">
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link" href="index.php?page=<?php print($page - 1); ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
      <?php endif; ?>
      <?php for ($x = 1; $x <= $pagination; $x++): ?>
        <li class="page-item <?php if ($page === $x) { echo 'active'; } ?>">
          <a class="page-link" href="index.php?page=<?php echo $x; ?>"><?php echo $x; ?></a>
        </li>
      <?php endfor; ?>
      <?php if ($page < $pagination): ?>
        <li class="page-item">
          <a class="page-link" href="index.php?page=<?php print($page + 1); ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      <?php endif; ?>
    </ul>

  </div>
  <!-- ./container -->

  <!-- Footer -->
  <div class="footer">
    <div class="footer-upward">
      <address>© Vinyl-Life</address>
    </div>
    <div class="footer-lower">
      <a href="/">ホーム</a>
      <a href="">利用規約</a>
      <a href="">プライバシーポリシー</a>
      <a href="" target="_blank">お問い合わせ</a>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
