<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Progress</title>

    <!-- 後で秋元さんのCSSを読み込む -->
    <link rel="stylesheet" href="m7_index_style.css">
</head>
<body>

<div class="container">

    <h1>Progress</h1>

    <p class="subtitle">
        就活の進捗を仲間と共有するサービス
    </p>

    <div class="description">

        <h2>サービス概要</h2>

        <p>
            Progressは、就職活動を進める学生が
            日々の取り組みを記録し、
            チーム内で共有できるサービスです。
        </p>

        <p>
            今日やった就活や企業研究、
            ES作成、面接練習などを投稿し、
            仲間と励まし合いながら
            就活を継続できます。
        </p>

    </div>

    <div class="menu">

        <?php if(isset($_SESSION["user_id"])): ?>

            <a href="m7_home.php">
                投稿一覧へ
            </a>

            <a href="m7_logout.php">
                ログアウト
            </a>

        <?php else: ?>

            <a href="m7_register.php">
                新規登録
            </a>

            <a href="m7_login.php">
                ログイン
            </a>

        <?php endif; ?>

    </div>

</div>

</body>
</html>