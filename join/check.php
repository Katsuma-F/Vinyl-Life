<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
  header('Location: index.php');
  exit();
}

if (!empty($_POST)) {
  $statement = $db->prepare('INSERT INTO users SET name=?, email=?, password=?, picture=?, created_at=NOW()');
  $statement->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['password']),
    $_SESSION['join']['picture']
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
              <!-- <a class="nav-link" href="mypage.php">マイページ</a> -->
            </li>
          </li>
        </ul>
        <form class="form-inline justify-content-end">
          <!-- <a href="login.php" class="btn btn-outline-secondary mr-3">ログイン</a>
          <a href="join/index.php" class="btn btn-outline-danger my-2">新規登録</a> -->
        </form>
        <ul class="navbar-nav justify-content-end my-2">
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="" class="rounded" style="width: 30px; height: 30px; margin-right: 10px">
              <span>名前</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="userMenu">
              <a class="dropdown-item" href="#">マイページ</a>
              <a class="dropdown-item" href="#">ログアウト</a>
            </div>
          </li> -->
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="mx-auto w-75">
      <h1 style="margin-bottom: 35px;">会員登録</h1>
      <form action="" method="post">
        <input type="hidden" name="action" value="submit" />
        <dl>
          <dt>ユーザー名</dt>
          <dd><?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?></dd>
          <dt>メールアドレス</dt>
          <dd><?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?></dd>
          <dt>パスワード</dt>
          <dd>【表示されません】</dd>
          <dt>プロフィール写真</dt>
          <dd>
            <?php if ($_SESSION['join']['picture'] != ''): ?>
              <img src="../user_picture/<?php print(htmlspecialchars($_SESSION['join']['picture'], ENT_QUOTES)); ?>">
            <?php endif; ?>
          </dd>
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
