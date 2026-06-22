<?php

$dsn = 'mysql:dbname=tb280159db;host=localhost';
$user = 'tb-280159';
$password = 'QfZGHJsz8B';

    $pdo = new PDO(
        $dsn,
        $user,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );

$sql = "
CREATE TABLE IF NOT EXISTS m7_users_table(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    login_id VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)
";

$pdo->exec($sql);


/* postsテーブル */

$sql = "
CREATE TABLE IF NOT EXISTS m7_posts_table(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    activity TEXT NOT NULL,
    company_name VARCHAR(100),
    minutes INT NOT NULL,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
)
";

$pdo->exec($sql);

?>