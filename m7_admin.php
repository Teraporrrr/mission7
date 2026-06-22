<?php

require_once("m7_admin_auth.php");
require_once("m7_db_connect.php");

$sql = $pdo->query(
"
SELECT
    p.*,
    u.username
FROM
    m7_posts_table p
JOIN
    m7_users_table u
ON
    p.user_id = u.id
ORDER BY
    p.created_at DESC
"
);

$posts = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ページ</title>

    <link rel="stylesheet"
          href="m7_admin_style.css">
</head>
<body>

<h1>管理者ページ</h1>

<p>
管理者：
<?php echo htmlspecialchars($_SESSION["username"]); ?>
</p>

<nav>

<a href="m7_home.php">
投稿一覧
</a>

|

<a href="m7_logout.php">
ログアウト
</a>

</nav>

<hr>

<h2>全投稿一覧</h2>

<?php if(count($posts) == 0): ?>

<p>
投稿はありません
</p>

<?php endif; ?>

<?php foreach($posts as $post): ?>

<div class="post">

    <h3>
        <?php echo htmlspecialchars($post["username"]); ?>
    </h3>

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
        href="m7_admin_delete.php?id=<?php echo $post["id"]; ?>"
        onclick="return confirm('この投稿を削除しますか？')">
        削除
        </a>

    </p>

</div>

<hr>

<?php endforeach; ?>

</body>
</html>