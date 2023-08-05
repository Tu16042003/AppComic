<?php
//http://127.0.0.1:3456/delete.php?id=1
//including the database connection file
include("./database/connection.php");
//getting id of the data from url
$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=:id";
$query = $dbConn->prepare($sql);
$query->execute(array(':id' => $id));
header("Location:index.php");
?>