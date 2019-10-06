<?php
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

// ユーザーidと投稿ユーザーidの情報を照合し、全パーツセットの投稿を取得
$posts = $db->query('SELECT u.name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created_at DESC');

?>
