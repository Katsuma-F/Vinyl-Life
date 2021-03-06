<?php
// ユーザーidと投稿ユーザーidを照合し、全パーツセットを$limit件ずつ取得
$sql = "SELECT u.id, u.name, u.sns_name, p.post_id, p.title, p.record_player, p.speaker, p.phono_equalizer, p.amplifier, p.other_parts, p.description, p.user_id, p.created_at
        FROM users u, posts p
        WHERE u.id = p.user_id
        ORDER BY p.created_at DESC LIMIT {$start}, {$limit}";
$posts = $db->prepare($sql);

$posts->execute();
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

?>
