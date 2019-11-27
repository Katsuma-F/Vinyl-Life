<?php
require('./dbconnect.php');

// 投稿画像を取得
$sql = 'SELECT image_type, image_content FROM posts WHERE card_id = :card_id LIMIT 1';
$images = $db->prepare($sql);
$images->bindValue(':card_id', (int)$_GET['card_id'], PDO::PARAM_INT);
$images->execute();
$image = $images->fetch();

header('Content-type: ' . $image['image_type']);

//画像を表示
echo $image['image_content'];
exit();

?>
