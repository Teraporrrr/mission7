<?php

require_once("m7_auth.php");
require_once("m7_db_connect.php");

if(!isset($_GET["id"])){
    header("Location: m7_mypage.php");
    exit();
}

$post_id = $_GET["id"];

/* 自分の投稿だけ取得 */

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

/* 更新処理 */

if(
    isset($_POST["category"]) &&
    isset($_POST["activity"]) &&
    isset($_POST["minutes"]) &&
    isset($_POST["comment"])
){

    $category = trim($_POST["category"]);
    $activity = trim($_POST["activity"]);
    $company_name = trim($_POST["company_name"]);
    $minutes = trim($_POST["minutes"]);
    $comment = trim($_POST["comment"]);

    if(
        $category !== "" &&
        $activity !== "" &&
        $minutes !== ""
    ){

        $sql = $pdo->prepare(
        "
        UPDATE m7_posts_table
        SET
            category = :category,
            activity = :activity,
            company_name = :company_name,
            minutes = :minutes,
            comment = :comment
        WHERE
            id = :id
        AND
            user_id = :user_id
        "
        );

        $sql->bindParam(
            ':category',
            $category,
            PDO::PARAM_STR
        );

        $sql->bindParam(
            ':activity',
            $activity,
            PDO::PARAM_STR
        );

        $sql->bindParam(
            ':company_name',
            $company_name,
            PDO::PARAM_STR
        );

        $sql->bindParam(
            ':minutes',
            $minutes,
            PDO::PARAM_INT
        );

        $sql->bindParam(
            ':comment',
            $comment,
            PDO::PARAM_STR
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
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿編集</title>

    <link rel="stylesheet"
          href="m7_edit_post_style.css">
</head>
<body>

<h1>投稿編集</h1>

<form action="" method="post">

    <label>カテゴリ</label><br>

    <input
        type="text"
        name="category"
        value="<?php echo htmlspecialchars($post["category"]); ?>"
    >

    <br><br>

    <label>今日やった就活</label><br>

    <textarea
        name="activity"
        rows="5"
        cols="50"
    ><?php echo htmlspecialchars($post["activity"]); ?></textarea>

    <br><br>

    <label>企業名</label><br>

    <input
        type="text"
        name="company_name"
        value="<?php echo htmlspecialchars($post["company_name"]); ?>"
    >

    <br><br>

    <label>取り組み時間（分）</label><br>

    <input
        type="number"
        name="minutes"
        value="<?php echo htmlspecialchars($post["minutes"]); ?>"
    >

    <br><br>

    <label>コメント</label><br>

    <textarea
        name="comment"
        rows="4"
        cols="50"
    ><?php echo htmlspecialchars($post["comment"]); ?></textarea>

    <br><br>

    <input
        type="submit"
        value="更新する"
    >

</form>

<p>
<a href="m7_mypage.php">
戻る
</a>
</p>

</body>
</html>