<?php
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
  // 会員登録内容のエラーチェック
  if ($_POST['name'] === '') {
		$error['name'] = 'blank';
	}
	if ($_POST['email'] === '') {
		$error['email'] = 'blank';
	}
	if (strlen($_POST['password']) < 4) {
		$error['password'] = 'length';
	}
	if ($_POST['password'] === '') {
		$error['password'] = 'blank';
	}

  $fileName = $_FILES['picture']['name'];
  if (!empty($fileName)) {
    $ext = substr($fileName, -3);
    if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
      $error['picture'] = 'type';
    }
  }

  // アカウントの重複チェック
  if (empty($error)) {
    $user = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
    $user->execute(array($_POST['email']));
    $record = $user->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }

  // プロフィール写真の情報をフォルダに保存
  if (empty($error)) {
    $image = date('YmdHis') . $_FILES['picture']['name'];
    move_uploaded_file($_FILES['picture']['tmp_name'], '../user_picture/' . $image);
    $_SESSION['join'] = $_POST;
    $_SESSION['join']['picture'] = $image;
    header('Location: check.php');
    exit();
  }
}

if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
  $_POST = $_SESSION['join'];
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

  <link rel="stylesheet" href="../css/styles.css">
  <title>Vinyl-Life</title>
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #FDFDFD;">
    <div class="container">
      <a class="navbar-brand text-dark" href="/">
        Vinyl-Life_img
      </a>
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

  <!-- 会員登録フォーム -->
  <div class="container">
    <div class="mx-auto w-75">
      <form action="" method="post" enctype="multipart/form-data">
        <h1 style="margin-bottom: 35px;">会員登録</h1>
        <div class="form-group">
          <label>ユーザー名</label>
          <input class="form-control" name="name" type="text" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" />
          <?php if ($error['name'] === 'blank'): ?>
            <p class="error">*ユーザー名を入力してください</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>メールアドレス</label>
          <input class="form-control" name="email" type="email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" />
          <?php if ($error['email'] === 'blank'): ?>
            <p class="error">*メールアドレスを入力してください</p>
          <?php endif; ?>
          <?php if ($error['email'] === 'duplicate'): ?>
            <p class="error">*指定されたメールアドレスは、すでに登録されています</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>パスワード</label>
          <input class="form-control" name="password" type="password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
          <?php if ($error['password'] === 'length'): ?>
            <p class="error">*パスワードは4文字以上で入力してください</p>
          <?php endif; ?>
          <?php if ($error['password'] === 'blank'): ?>
            <p class="error">*パスワードを入力してください</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>プロフィール写真</label>
          <input type="file" name="picture" value="test" />
        </div>
        <input class="btn btn-danger" type="submit" value="入力内容を確認する" />
        <?php if ($error['picture'] === 'type'): ?>
          <p class="error">*写真は「.jpg」「.gif」「.png」の画像を指定してください</p>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
          <p class="error">*恐れ入りますが、画像を改めて指定してください</p>
        <?php endif; ?>
        <a href="../login.php">ログインはこちら</a>
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
