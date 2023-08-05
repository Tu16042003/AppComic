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
    // lay mail tu body
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    //kt mail co ton tai ko
    $result = $dbConn->query("select id from users where email = '$email' ");
    $user = $result->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        throw new Exception("Email khong ton tai");
    }
    // tao token
    $token = md5(time().$email);
    //luu token vao database
    $dbConn->query("insert into reset_password(email,token) values('$email','$token')");

//gui link
    $link = "<a href='http://127.0.0.1:3456/resetpassword.php?email="
    . $email . "&token=" . $token . "'>Click to reset password</a>";
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
    $mail->Subject = "Reset Password";
    $mail->isHTML(true);
    $mail->Body = "Click on this link to reset password " . $link . " ";
    $res = $mail->Send();

    if ($res) {
        echo json_encode(array(
            "status"=>true,
            "message"=>"Email send."
        ));
    }else{
        echo json_encode(array(
            "status"=>false,
            "message"=>"Email send failed."
        ));
    }


} catch (Exception $e) {
    echo json_encode(array(
        "status"=>false,
        "message"=>$e ->getMessage()
    ));
}
