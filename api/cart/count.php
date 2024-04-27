<?php 
session_start();

 header("Access-Control-Allow-Origin: *");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Allow-Methods: GET");
 header("Access-Control-Max-Age: 3600");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../config/database.php';
 include_once '../objects/cart.php';
 
 $database = new Database();
 $db = $database->getConnection();
 
 $cart = new Cart($db);
 $count = 0;

 if(isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $count = $cart->count($user_id);
} 
 
echo json_encode($count);

?>