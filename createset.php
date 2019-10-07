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

?>
