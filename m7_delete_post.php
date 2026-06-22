<?php

require_once("m7_auth.php");
require_once("m7_db_connect.php");

if(!isset($_GET["id"])){

    header("Location: m7_mypage.php");
    exit();

}

$post_id = $_GET["id"];


/* 自分の投稿か確認 */

$sql = $pdo->prepare(
"
SELECT *
FROM m7_posts_table
WHERE id = :id
AND user_id = :user_id
"
);

$sql->bindParam(
    ':id',
    $post_id,
    PDO::PARAM_INT
);

$sql->bindParam(
    ':user_id',
    $_SESSION["user_id"],
    PDO::PARAM_INT
);

$sql->execute();

$post = $sql->fetch(PDO::FETCH_ASSOC);


/* 存在しない場合 */

if(!$post){

    header("Location: m7_mypage.php");
    exit();

}


/* 削除 */

$sql = $pdo->prepare(
"
DELETE FROM m7_posts_table
WHERE id = :id
AND user_id = :user_id
"
);

$sql->bindParam(
    ':id',
    $post_id,
    PDO::PARAM_INT
);

$sql->bindParam(
    ':user_id',
    $_SESSION["user_id"],
    PDO::PARAM_INT
);

$sql->execute();


header("Location: m7_mypage.php");
exit();

?>