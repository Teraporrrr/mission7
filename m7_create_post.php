<?php

require_once("m7_auth.php");
require_once("m7_db_connect.php");

$message = "";

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
            "INSERT INTO m7_posts_table
            (user_id, category, activity, company_name, minutes, comment)
            VALUES
            (:user_id, :category, :activity, :company_name, :minutes, :comment)"
        );

        $sql->bindParam(
            ':user_id',
            $_SESSION["user_id"],
            PDO::PARAM_INT
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

        $sql->execute();
        
        header("Location: m7_home.php");
        exit();

        $message = "投稿しました";
    }
    else{

        $message = "必須項目を入力してください";

    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿作成</title>

    <link rel="stylesheet"
          href="m7_create_post_style.css">
</head>
<body>

<h1>就活報告を投稿</h1>

<p>
ログイン中：
<?php echo htmlspecialchars($_SESSION["username"]); ?>
</p>

<form action="" method="post">

    <label>カテゴリ</label><br>

    <select name="category">

        <option value="">選択してください</option>

        <option value="自己分析">
            自己分析
        </option>

        <option value="企業研究">
            企業研究
        </option>

        <option value="ES作成">
            ES作成
        </option>

        <option value="説明会">
            説明会
        </option>

        <option value="面接対策">
            面接対策
        </option>

        <option value="その他">
            その他
        </option>

    </select>

    <br><br>

    <label>今日やった就活</label><br>

    <textarea
        name="activity"
        rows="5"
        cols="50"
    ></textarea>

    <br><br>

    <label>企業名（任意）</label><br>

    <input
        type="text"
        name="company_name"
    >

    <br><br>

    <label>取り組み時間（分）</label><br>

    <input
        type="number"
        name="minutes"
        min="1"
    >

    <br><br>

    <label>コメント</label><br>

    <textarea
        name="comment"
        rows="4"
        cols="50"
    ></textarea>

    <br><br>

    <input
        type="submit"
        value="投稿する"
    >

</form>

<p>
<?php echo $message; ?>
</p>

<p>
<a href="m7_home.php">
投稿一覧へ
</a>
</p>

</body>
</html>