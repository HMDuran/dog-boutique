<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../objects/Cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

session_start();
if(isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $cartData = $cart->read($user_id);

    $response = array(
        "data" => $cartData
    );
    
    http_response_code(200);
    echo json_encode($response);
} else {
    http_response_code(401);
    echo json_encode(array("message" => "User is not authenticated."));
}
?>
