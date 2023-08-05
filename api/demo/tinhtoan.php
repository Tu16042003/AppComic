<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// http://127.0.0.1:3456/api/demo/tinhtoan.php?a=5&b=6

$a = $_GET['a'];
$b = $_GET['b'];

$tong = $a+$b;
$hieu = $a-$b;
$tich = $a*$b;
$thuong = $a/$b;

echo json_encode(
    array(
        "tong"=>$tong,
        "hieu"=>$hieu,
        "tich"=>$tich,
        "thuong"=>$thuong
    )
    );
