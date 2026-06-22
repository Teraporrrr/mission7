<?php

require_once("m7_admin_auth.php");
require_once("m7_db_connect.php");

if(!isset($_GET["id"])){

    header("Location: m7_admin.php");
    exit();

}

$post_id = $_GET["id"];


/* 投稿が存在するか確認 */

$sql = $pdo->prepare(
"
SELECT *
FROM m7_posts_table
WHERE id = :id
"
);

$sql->bindParam(
    ':id',
    $post_id,
    PDO::PARAM_INT
);

$sql->execute();

$post = $sql->fetch(PDO::FETCH_ASSOC);


/* 存在しない場合 */

if(!$post){

    header("Location: m7_admin.php");
    exit();

}


/* 削除処理 */

$sql = $pdo->prepare(
"
DELETE FROM m7_posts_table
WHERE id = :id
"
);

$sql->bindParam(
    ':id',
    $post_id,
    PDO::PARAM_INT
);

$sql->execute();


header("Location: m7_admin.php");
exit();

?>