<?php
if (!empty($_POST)) {
    $FileName = $_FILES['image']['name'];
    if (!empty($FileName)) {
        // 画像ファイルの拡張子チェック
        $ext = substr($FileName, -3);
        if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
            $error['image'] = 'type';
        }

        if (empty($error) && $_POST['title'] !== '' && $_POST['record_player'] !== '' && $_POST['speaker'] !== '' && $_POST['description'] !== '') {
            // 投稿画像データを各変数に代入
            $type = $_FILES['image']['type'];
            $content = file_get_contents($_FILES['image']['tmp_name']);
            // パーツセットの情報をデータベースに保存
            $sql = 'INSERT INTO posts (image_type, image_content, title, record_player, speaker, phono_equalizer, amplifier, other_parts, description, user_id, created_at) VALUES (:image_type, :image_content, :title, :record_player, :speaker, :phono_equalizer, :amplifier, :other_parts, :description, :user_id, NOW())';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
            $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
            $stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
            $stmt->bindValue(':record_player', $_POST['record_player'], PDO::PARAM_STR);
            $stmt->bindValue(':speaker', $_POST['speaker'], PDO::PARAM_STR);
            $stmt->bindValue(':phono_equalizer', $_POST['phono_equalizer'], PDO::PARAM_STR);
            $stmt->bindValue(':amplifier', $_POST['amplifier'], PDO::PARAM_STR);
            $stmt->bindValue(':other_parts', $_POST['other_parts'], PDO::PARAM_STR);
            $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $user['id'], PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    header('Location: mypage.php');
    exit();
}

?>
