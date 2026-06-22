<?php

session_start();

require_once("m7_db_connect.php");

$message = "";

if(
    isset($_POST["login_id"]) &&
    isset($_POST["password"])
){

    $login_id = trim($_POST["login_id"]);
    $password = trim($_POST["password"]);

    if(
        $login_id !== "" &&
        $password !== ""
    ){

        $sql = $pdo->prepare(
            "SELECT * FROM m7_users_table
             WHERE login_id = :login_id"
        );

        $sql->bindParam(
            ':login_id',
            $login_id,
            PDO::PARAM_STR
        );

        $sql->execute();

        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if(
            $user &&
            password_verify(
                $password,
                $user["password"]
            )
        ){

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["is_admin"] = $user["is_admin"];

            // 管理者なら管理者ページへ
            if($user["is_admin"] == 1){

                header("Location: m7_admin.php");
                exit();

            }else{

                header("Location: m7_home.php");
                exit();

            }

        }else{

            $message = "IDまたはパスワードが違います";

        }

    }else{

        $message = "全項目を入力してください";

    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>

    <link rel="stylesheet"
          href="m7_login_style.css">
</head>
<body>

<h1>ログイン</h1>

<form action="" method="post">

    <input
        type="text"
        name="login_id"
        placeholder="ログインID"
    >
    <br>

    <input
        type="password"
        name="password"
        placeholder="パスワード"
    >
    <br>

    <input
        type="submit"
        value="ログイン"
    >

</form>

<p>
    <?php echo $message; ?>
</p>

<p>
    <a href="m7_register.php">
        新規登録はこちら
    </a>
</p>

<p>
    <a href="m7_index.php">
        トップへ戻る
    </a>
</p>

</body>
</html>