<?php
// １ページに表示するカード上限枚数
$limit = 6;

// GETで現在のページ数を取得する（未入力の場合は１を挿入）
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

// スタートのポジションを計算する
if ($page > 1) {
    // 例：２ページ目の場合は、(２ * ６) - ６ = ６』
    $start = ($page * $limit) - $limit;
} else {
    $start = 0;
}

// postsテーブルのデータ件数を取得する
$page_num = $db->prepare('SELECT COUNT(*) card_id FROM posts');
$page_num->execute();
$page_num = $page_num->fetchColumn();

// ページネーションの数を取得する
$pagination = ceil($page_num / $limit);

?>
