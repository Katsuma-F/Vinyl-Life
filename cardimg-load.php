<?php
require('./dbconnect.php');

// 投稿画像を取得
$sql = 'SELECT image_type, image_content FROM posts WHERE card_id = :card_id LIMIT 1';
$stmt = $db->prepare($sql);
$stmt->bindValue(':card_id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$CardImage = $stmt->fetch();

header('Content-type: ' . $CardImage['image_type']);

//画像を表示
echo $CardImage['image_content'];
exit();

?>
