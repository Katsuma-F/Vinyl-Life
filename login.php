<?php
session_start();
require('./dbconnect.php');

if ($_COOKIE['user_id'] !== '') {
    $UserID = $_COOKIE['user_id'];
}

if (!empty($_POST)) {
    $UserID = $_POST['user_id'];

    if ($_POST['user_id'] !== '' && $_POST['password'] !== '') {
        $login = $db->prepare('SELECT * FROM users WHERE user_id = ? AND password = ?');
        $login->execute(array(
          $_POST['user_id'],
          sha1($_POST['password'])
        ));
        $user = $login->fetch();

        if($user) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['time'] = time();

            if ($_POST['save'] === 'on') {
              setcookie('user_id', $_POST['user_id'], time()+60*60*24*14);
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

<!DOCTYPE html>
<html lang="ja" dir="ltr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="./css/styles.css">

  <title>Vinyl-Life</title>
</head>

<body>
  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand text-light" href="index.php">
        <img src="./img/record_player.png" width="40" height="40" class="d-inline-block align-top" alt="Logo">
        Vinyl-Life
      </a>
    </div>
  </nav>

  <div class="container">
    <div class="mx-auto w-75">
      <form action="" method="post">
        <h1 class="mb-5">ログイン</h1>
        <div class="form-group">
          <input class="form-control mb-4" name="user_id" type="text" placeholder="ユーザーid" value="<?php print(htmlspecialchars($UserID, ENT_QUOTES)); ?>">
          <?php if ($error['login'] === 'blank'): ?>
            <p class="error">*ユーザーidとパスワードをご記入ください</p>
          <?php endif; ?>
          <?php if ($error['login'] === 'failed'): ?>
            <p class="error">*ログインに失敗しました、正しくご記入ください。</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <input class="form-control mb-5" name="password" type="password" placeholder="パスワード" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
        </div>
        <dd>ログイン情報の記録</dd>
        <dt>
          <input id="save" name="save" type="checkbox" value="on">
          <label for="save">次回からは自動的にログインする</label>
        </dt>
        <button class="btn btn-danger mr-4" name="login" type="submit">ログインする</button>
        <a href="./join/index.php">会員登録はこちら</a>
      </form>
    </div>
  </div>

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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
