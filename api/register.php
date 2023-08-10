<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");
use PHPMailer\PHPMailer\PHPMailer;

include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/utilities/PHPMailer-master/src/Exception.php';

try {
    $body = json_decode(file_get_contents("php://input"));

    $email = $body->email;
    $password = $body->password;
    $name = $body->name;

    if (empty($email) || empty($password) || empty($name)) {
        # code...
        echo json_encode(array(
            "status" => false,
            "message" => "ko tao duoc"
        ));
        return;
    }

    $user = $dbConn->query("SELECT id,email,password 
    FROM users where email = '$email'");
    if ($user->rowCount() > 0) {
        echo json_encode(array(
            "status" => false,
            "message" => "tai khoan ton tai"
        ));
        return;
    } else {
        // ma hoas pass
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbConn->query("INSERT INTO users(email,password,name)
         VALUE ('$email','$password','$name')");

        // tao token
        $token = md5(time() . $email);
        //luu token vao database
        $dbConn->query("insert into reset_password(email,token) values('$email','$token')");

        //gui link
        $link = "<a href='http://127.0.0.1:3456/verify_account.php?email="
            . $email . "&token=" . $token . "'>Click to Login</a>";
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = "qtuvip";
        $mail->Password = "nuarhubvrdkoblqy";
        $mail->SMTPSecure = "ssl";
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = "465";
        $mail->From = "qtuvip@gmail.com";
        $mail->FromName = "PhamTu";
        $mail->addAddress($email, 'Hello');
        $mail->Subject = "Xác thực tài khoản";
        $mail->isHTML(true);
        $mail->Body = "Click on this link to " . $link . " ";
        $res = $mail->Send();

        if ($res) {
            echo json_encode(array(
                "status" => true,
                "message" => "Vào email để xác thực đê."
            ));
        } else {
            echo json_encode(array(
                "status" => false,
                "message" => "Đăng ký không thành công."
            ));
        }
    }
} catch (Exception $e) {
    echo json_encode(array(
        "status" => false,
        "message" => $e->getMessage()
    ));
}
