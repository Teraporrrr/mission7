<?php

session_start();

if(!isset($_SESSION["user_id"])){

    header("Location: m7_login.php");
    exit();

}

?>