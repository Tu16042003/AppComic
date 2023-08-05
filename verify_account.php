<?php

include_once("./database/connection.php");

try {
    $email = $_GET['email'];
    $token = $_GET['token'];
    if (empty($email) || empty($token)) {
        throw new Exception("Email or token not tồn tại");
    }
    // kt token
    $user = $dbConn->query(" SELECT id from 
                        users where email = '$email' ");

    if ($user->rowCount() == 0) {
        throw new Exception("Email not tồn tại");
    }
    // xác thực tk
    $dbConn->query(" UPDATE users SET verify = 1 
                         where email = '$email' ");

    header("Location: login.php");
} catch (Exception $e) {

    header("Location: 404.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực tài khoản</title>
</head>

<body>
    <h1>Tài khoản đã xác thực!!!</h1>
</body>

</html>