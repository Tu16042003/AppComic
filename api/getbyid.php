<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("../database/connection.php");

try {

    $id = $_GET['id'];
    $products = $dbConn->query("SELECT p.id, p.name, p.price,
                                    p.quantity, p.image, p.description, 
                                    p.categoryId FROM products p
                                WHERE p.id = $id ");

    $products = $products->fetch(PDO::FETCH_ASSOC);
    echo json_encode(array(
        "status"=>true,
        "products"=>$products
    ));

} catch (Exception $e) {
    echo json_encode(array(
        "status"=>false,
        "message"=>$e ->getMessage()
    ));
}


?>