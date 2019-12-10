<?php
require('./dbconnect.php');

// プロフィール画像を取得
$sql = 'SELECT image_type, image_content FROM users WHERE id = :id LIMIT 1';
$images = $db->prepare($sql);
$images->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
$images->execute();
$image = $images->fetch();

header('Content-type: ' . $image['image_type']);

// プロフィール画像を表示
echo $image['image_content'];
exit();

?>
