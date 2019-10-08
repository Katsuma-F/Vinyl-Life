<?php
// １ページに表示する上限カード数
$limit = 6;

// GETで現在のページ数を取得する（未入力の場合は１を挿入）
if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}

// スタートのポジションを計算する
if ($page > 1) {
  // 例：２ページ目の場合は、(２ * ６) - 6 = 6』
  $start = ($page * $limit) - $limit;
} else {
  $start = 0;
}

// ユーザーidと投稿ユーザーidを照合し、全パーツセットを$limit件ずつ取得
$posts = $db->prepare("SELECT u.name, u.picture, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created_at DESC LIMIT {$start}, {$limit}");

// postsテーブルからデータを$limit件取得
$posts->execute();
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

// postsテーブルのデータ件数を取得する
$page_num = $db->prepare('SELECT COUNT(*) card_id FROM posts');
$page_num->execute();
$page_num = $page_num->fetchColumn();

// ページネーションの数を取得する
$pagination = ceil($page_num / $limit);

?>
