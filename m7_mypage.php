<?php

require_once("m7_auth.php");
require_once("m7_db_connect.php");

$sql = $pdo->prepare(
"
SELECT *
FROM m7_posts_table
WHERE user_id = :user_id
ORDER BY created_at DESC
"
);

$sql->bindParam(
    ':user_id',
    $_SESSION["user_id"],
    PDO::PARAM_INT
);

$sql->execute();

$posts = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>

    <link rel="stylesheet"
          href="m7_mypage_style.css">
</head>
<body>

<h1>マイページ</h1>

<p>
ようこそ
<?php echo htmlspecialchars($_SESSION["username"]); ?>
さん
</p>

<nav>

<a href="m7_home.php">
投稿一覧
</a>

|

<a href="m7_create_post.php">
投稿する
</a>

|

<a href="m7_logout.php">
ログアウト
</a>

</nav>

<hr>

<h2>自分の投稿一覧</h2>

<?php if(count($posts) == 0): ?>

<p>
まだ投稿がありません
</p>

<?php endif; ?>

<?php foreach($posts as $post): ?>

<div class="post">

    <p>
        <strong>カテゴリ：</strong>
        <?php echo htmlspecialchars($post["category"]); ?>
    </p>

    <p>
        <strong>今日やった就活：</strong><br>
        <?php
        echo nl2br(
            htmlspecialchars($post["activity"])
        );
        ?>
    </p>

    <?php if($post["company_name"] != ""): ?>

    <p>
        <strong>企業名：</strong>
        <?php
        echo htmlspecialchars(
            $post["company_name"]
        );
        ?>
    </p>

    <?php endif; ?>

    <p>
        <strong>取り組み時間：</strong>
        <?php
        echo htmlspecialchars(
            $post["minutes"]
        );
        ?>
        分
    </p>

    <?php if($post["comment"] != ""): ?>

    <p>
        <strong>コメント：</strong><br>

        <?php
        echo nl2br(
            htmlspecialchars(
                $post["comment"]
            )
        );
        ?>
    </p>

    <?php endif; ?>

    <p>
        投稿日：
        <?php echo $post["created_at"]; ?>
    </p>

    <p>

        <a
        href="m7_edit_post.php?id=<?php echo $post["id"]; ?>">
        編集
        </a>

        |

        <a
        href="m7_delete_post.php?id=<?php echo $post["id"]; ?>"
        onclick="return confirm('削除しますか？')">
        削除
        </a>

    </p>

</div>

<hr>

<?php endforeach; ?>

</body>
</html>