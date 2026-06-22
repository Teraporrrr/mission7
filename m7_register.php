<?php

session_start();

require_once("m7_db_connect.php");

$message = "";

if(
    isset($_POST["username"]) &&
    isset($_POST["login_id"]) &&
    isset($_POST["password"])
){

    $username = trim($_POST["username"]);
    $login_id = trim($_POST["login_id"]);
    $password = trim($_POST["password"]);

    if(
        $username !== "" &&
        $login_id !== "" &&
        $password !== ""
    ){

        // 同じログインIDが存在するか確認
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

        $result = $sql->fetch(PDO::FETCH_ASSOC);

        if($result){

            $message = "そのログインIDは既に使用されています";

        }else{

            // ユーザー数を取得
            $sql = $pdo->query(
                "SELECT COUNT(*) FROM m7_users_table"
            );

            $user_count = $sql->fetchColumn();

            // 最初のユーザーだけ管理者
            if($user_count == 0){
                $is_admin = 1;
            }else{
                $is_admin = 0;
            }

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = $pdo->prepare(
            "
            INSERT INTO m7_users_table
            (
                username,
                login_id,
                password,
                is_admin
            )
            VALUES
            (
                :username,
                :login_id,
                :password,
                :is_admin
            )
            "
            );

            $sql->bindParam(
                ':username',
                $username,
                PDO::PARAM_STR
            );

            $sql->bindParam(
                ':login_id',
                $login_id,
                PDO::PARAM_STR
            );

            $sql->bindParam(
                ':password',
                $hashed_password,
                PDO::PARAM_STR
            );

            $sql->bindParam(
                ':is_admin',
                $is_admin,
                PDO::PARAM_INT
            );

            $sql->execute();

            header("Location: m7_login.php");
            exit();
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
    <title>新規登録</title>

    <link rel="stylesheet"
          href="m7_register_style.css">
</head>
<body>

<h1>新規登録</h1>

<form action="" method="post">

    <input
        type="text"
        name="username"
        placeholder="ユーザー名"
    >
    <br><br>

    <input
        type="text"
        name="login_id"
        placeholder="ログインID"
    >
    <br><br>

    <input
        type="password"
        name="password"
        placeholder="パスワード"
    >
    <br><br>

    <input
        type="submit"
        value="登録"
    >

</form>

<p>
<?php echo htmlspecialchars($message); ?>
</p>

<p>
<a href="m7_index.php">
トップへ戻る
</a>
</p>

</body>
</html>