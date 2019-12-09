<?php
if (!empty($_POST)) {
    $fileName = $_FILES['post_image']['name'];
    if (!empty($fileName)) {
        // 画像ファイルの拡張子チェック
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
            $error['post_image'] = 'type';
        }

        if (empty($error) && $_POST['title'] !== '' && $_POST['record_player'] !== '' && $_POST['speaker'] !== '' && $_POST['description'] !== '') {
            // 投稿データを各変数に代入
            $imageType = $_FILES['post_image']['type'];
            $imageContent = file_get_contents($_FILES['post_image']['tmp_name']);
            $title = $_POST['title'];
            $recordPlayer = $_POST['record_player'];
            $speaker = $_POST['speaker'];
            $phonoEqualizer = $_POST['phono_equalizer'];
            $amplifier = $_POST['amplifier'];
            $otherParts = $_POST['other_parts'];
            $description = $_POST['description'];
            $userId = $user['id'];

            // パーツセットの情報をデータベースに保存
            $sql = 'INSERT INTO posts (image_type, image_content, title, record_player, speaker, phono_equalizer, amplifier, other_parts, description, user_id, created_at)
                    VALUES (:image_type, :image_content, :title, :record_player, :speaker, :phono_equalizer, :amplifier, :other_parts, :description, :user_id, NOW())';
            $posts = $db->prepare($sql);
            $posts->bindValue(':image_type', $imageType, PDO::PARAM_STR);
            $posts->bindValue(':image_content', $imageContent, PDO::PARAM_STR);
            $posts->bindValue(':title', $title, PDO::PARAM_STR);
            $posts->bindValue(':record_player', $recordPlayer, PDO::PARAM_STR);
            $posts->bindValue(':speaker', $speaker, PDO::PARAM_STR);
            $posts->bindValue(':phono_equalizer', $phonoEqualizer, PDO::PARAM_STR);
            $posts->bindValue(':amplifier', $amplifier, PDO::PARAM_STR);
            $posts->bindValue(':other_parts', $otherParts, PDO::PARAM_STR);
            $posts->bindValue(':description', $description, PDO::PARAM_STR);
            $posts->bindValue(':user_id', $userId, PDO::PARAM_STR);
            $posts->execute();
        }
    }

    header('Location: mypage.php');
    exit();
}

?>
