<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../objects/cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    if ($cart->updateQuantity($id, $quantity)) {
        echo json_encode(array("message" => "Quantity was updated."));
    } else {
        echo json_encode(array("message" => "Unable to update quantity."));
    }
} else {
    echo json_encode(array("message" => "ID or quantity not provided."));
}
?>
