<?php

require_once("m7_db_connect.php");

/* 全ユーザー削除 */
$sql = "DELETE FROM m7_users_table";
$pdo->exec($sql);

/* 全投稿削除 */
$sql = "DELETE FROM m7_posts_table";
$pdo->exec($sql);

echo "削除完了";
?>