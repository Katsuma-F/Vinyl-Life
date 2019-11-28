<?php
// ユーザーidと投稿ユーザーidを照合し、全パーツセットを取得
$posts = $db->prepare("SELECT u.name, u.sns_name, u.profile_picture, p.post_id, p.title, p.record_player, p.speaker, p.phono_equalizer, p.amplifier, p.other_parts, p.description, p.user_id, p.created_at FROM users u, posts p WHERE u.id = p.user_id ORDER BY p.created_at DESC");

$posts->execute();
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

?>
