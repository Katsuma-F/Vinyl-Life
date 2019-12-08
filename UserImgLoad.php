<?php
require('./dbconnect.php');

// 投稿画像を取得
$sql = 'SELECT picture_type, picture_content FROM users WHERE id = :id LIMIT 1';
$pictures = $db->prepare($sql);
$pictures->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
$pictures->execute();
$picture = $pictures->fetch();

header('Content-type: ' . $picture['picture_type']);

// 投稿画像を表示
echo $picture['picture_content'];
exit();

?>
