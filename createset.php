<?php
if (!empty($_POST)) {
  if ($_POST['image'] !== '' && $_POST['title'] !== '' && $_POST['description'] !== '') {
    $image = date('YmdHis') . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/card_image' . '/' . $image);
    $_POST['card_image'] = $image;

    // パーツセットの情報をデータベースに保存
    $card = $db->prepare('INSERT INTO posts SET card_image=?, title=?, description=?, user_id=?, created_at=NOW()');
    $card->execute(array(
      $_POST['card_image'],
      $_POST['title'],
      $_POST['description'],
      $user['id']
    ));

    header('Location: mypage.php');
    exit();
  }
}

?>
