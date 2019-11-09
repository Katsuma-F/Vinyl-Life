<?php
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
    // 会員登録内容のエラーチェック
    if ($_POST['name'] === '') {
        $error['name'] = 'blank';
    }
    if ($_POST['user_id'] === '') {
        $error['user_id'] = 'blank';
    }
    if (strlen($_POST['password']) < 4 || strlen($_POST['password']) > 32) {
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
        $user = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE user_id=?');
        $user->execute(array($_POST['user_id']));
        $record = $user->fetch();
        if ($record['cnt'] > 0) {
            $error['user_id'] = 'duplicate';
        }
    }

    // プロフィール写真の情報をフォルダに保存
    if (empty($error)) {
        $picture = date('YmdHis') . $_FILES['picture']['name'];
        move_uploaded_file($_FILES['picture']['tmp_name'], '../user_picture/' . $picture);
        $_SESSION['join'] = $_POST;
        $_SESSION['join']['picture'] = $picture;
        header('Location: check.php');
        exit();
    }
}

if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
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

  <!-- 会員登録フォーム -->
  <div class="container">
    <div class="mx-auto w-75">
      <form action="" method="post" enctype="multipart/form-data">
        <h1 style="margin-bottom: 35px;">会員登録</h1>
        <div class="form-group">
          <label>ユーザー名</label>
          <input class="form-control" name="name" type="text" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>">
          <?php if ($error['name'] === 'blank'): ?>
            <p class="error">*ユーザー名を入力してください</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>*任意  Twitterアカウント名</label>
          <input class="form-control" name="sns_name" type="text" placeholder="@" value="<?php print(htmlspecialchars($_POST['sns_name'], ENT_QUOTES)); ?>">
        </div>
        <div class="form-group">
          <label>ユーザーid</label>
          <input class="form-control" name="user_id" type="user_id" value="<?php print(htmlspecialchars($_POST['user_id'], ENT_QUOTES)); ?>">
          <?php if ($error['user_id'] === 'blank'): ?>
            <p class="error">*ユーザーidを入力してください</p>
          <?php endif; ?>
          <?php if ($error['user_id'] === 'duplicate'): ?>
            <p class="error">*指定されたユーザーidは、すでに登録されています</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>パスワード</label>
          <input class="form-control" name="password" type="password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
          <p>※パスワードは4文字以上、32文字以下でご登録ください</p>
          <?php if ($error['password'] === 'length'): ?>
            <p class="error">*パスワードは4文字以上、32文字以下で入力してください</p>
          <?php endif; ?>
          <?php if ($error['password'] === 'blank'): ?>
            <p class="error">*パスワードを入力してください</p>
          <?php endif; ?>
        </div>
        <div class="form-group">
          <label>プロフィール写真：</label>
          <input type="file" name="picture" value="test">
        </div>
        <input class="btn btn-danger" type="submit" value="入力内容を確認する">
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
