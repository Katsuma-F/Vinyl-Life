<?php
if (!empty($_POST)) {
    $fileName = $_FILES['image']['name'];
    if (!empty($fileName)) {
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
            $error['image'] = 'type';
        }
    }

    if (empty($error) && $_FILES['image'] !== '' && $_POST['title'] !== '' && $_POST['recordplayer'] !== '' && $_POST['speaker'] !== '' && $_POST['description'] !== '') {
        $image = date('YmdHis') . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/card_image' . '/' . $image);
        $card_image = $image;

        // パーツセットの情報をデータベースに保存
        $card = $db->prepare('INSERT INTO posts SET card_image=?, title=?, record_player=?, speaker=?, phono_equalizer=?, amplifier=?, other_parts=?, description=?, user_id=?, created_at=NOW()');
        $card->execute(array(
          $card_image,
          $_POST['title'],
          $_POST['record_player'],
          $_POST['speaker'],
          $_POST['phono_equalizer'],
          $_POST['amplifier'],
          $_POST['other_parts'],
          $_POST['description'],
          $user['id']
        ));

        header('Location: mypage.php');
        exit();
    }
}

?>
