<?php
// ユーザーidと投稿ユーザーidを照合し、全パーツセットを$limit件ずつ取得
$posts = $db->prepare("SELECT u.name, u.sns_name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created_at DESC LIMIT {$start}, {$limit}");

// postsテーブルからデータを$limit件取得
$posts->execute();
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

?>
