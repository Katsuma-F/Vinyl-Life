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
$sql = 'SELECT COUNT(*) post_id FROM posts';
$pageNum = $db->prepare($sql);
$pageNum->execute();
$pageNum = $pageNum->fetchColumn();

// ページネーションの数を取得する
$pagination = ceil($pageNum / $limit);

?>
