<?php

session_start();

if(
    !isset($_SESSION["user_id"])
){

    header("Location: m7_login.php");
    exit();

}

if(
    $_SESSION["is_admin"] != 1
){

    header("Location: m7_home.php");
    exit();

}

?>