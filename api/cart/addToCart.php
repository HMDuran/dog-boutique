<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../objects/Cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
$user_id;

if(isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
} else {
    http_response_code(401);
    echo json_encode(array("message" => "User is not authenticated."));
    exit();
}

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$cart->user_id = $user_id;
$cart->product_id = $product_id;
$cart->quantity = $quantity;

if($cart->addToCart()){
    http_response_code(200);
    echo json_encode(array("message" => "Product added to cart."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to add product to cart."));
}
?>
