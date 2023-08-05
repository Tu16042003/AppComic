<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");


try {
    $body = json_decode(file_get_contents("php://input"));
    $email = $body->email;
    $pswd = $body->password;
    if (empty($email)|| empty($pswd)) {
        # code...
        echo json_encode(array(
            "status" => false,
            "message"=>"Nhap thieu"
        ));
        return;
    }

    $user = $dbConn->query("SELECT id,email,password 
    FROM users where email = '$email' and verify = 1");
    if ($user->rowCount() > 0) {
        # lay thong tin user
        $row = $user->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        $email = $row['email'];
        $password = $row['password'];
        # kiem tra mat khau
        if (password_verify($pswd,$password)) {
            echo json_encode(array(
                "status"=>true,
                "email" => $email,
                "id" => $id
            ));
        } else {
            echo json_encode(array(
                "status"=>false
            ));
        }
    }else{
        echo json_encode(array(
            "status"=>false
        ));
    }
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}

?>