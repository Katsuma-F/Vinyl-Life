<?php
require('./dbconnect.php');

// 投稿画像を取得
$sql = 'SELECT image_type, image_content FROM posts WHERE post_id = :post_id LIMIT 1';
$images = $db->prepare($sql);
$images->bindValue(':post_id', (int)$_GET['post_id'], PDO::PARAM_INT);
$images->execute();
$image = $images->fetch();

header('Content-type: ' . $image['image_type']);

// 投稿画像を表示
echo $image['image_content'];
exit();

?>
