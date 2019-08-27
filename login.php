<?php
session_start();
require('dbconnect.php');

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}

if (!empty($_POST)) {
  $email = $_POST['email'];

  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $member = $login->fetch();

    if($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if ($_POST['save'] === 'on') {
        setcookie('email', $_POST['email'], time()+60*60*24*14);
      }

      header('Location: index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
}

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
</head>

<body style="background-color: #EFEFEF;">
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #FDFDFD;">
    <div class="container">
      <a class="navber-brand text-dark" href="index.php">Vinyl-Life_img</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainMenu">
        <ul class="navbar-nav"></ul>
        <ul class="navbar-nav ml-auto text-dark">
          <form class="form-inline ml-auto">
            <a href="" class="btn btn-secondary">ログイン</a>
            <a href="" class="btn btn-danger">新規登録</a>
          </form>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="mx-auto w-75">
      <form action="" method="post">
        <h1>ログイン</h1>
        <div class="form-group">
          <input class="form-control" name="email" type="text" placeholder="メールアドレス" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>" />
          <?php if ($error['login'] === 'blank'): ?>
            <p class="error">*メールアドレスとパスワードをご記入ください</p>
          <?php endif; ?>
          <?php if ($error['login'] === 'failed'): ?>
            <p class="error">*ログインに失敗しました。正しくご記入ください</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <input class="form-control" name="password" type="password" placeholder="パスワード" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
        </div>
        <dd>ログイン情報の記録</dd>
        <dt>
          <input id="save" name="save" type="checkbox" value="on">
          <label for="save">次回からは自動的にログインする</label>
        </dt>
        <button class="btn btn-danger" name="login" type="submit">ログインする</button>
        <a href="./join/index.php">会員登録はこちら</a>
      </form>
    </div>
  </div>

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
