<?php

session_start();

/* セッション変数を全削除 */
$_SESSION = array();

/* セッション破棄 */
session_destroy();

/* トップページへ */
header("Location: m7_index.php");
exit();

?>