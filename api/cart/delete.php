<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    include_once '../../config/database.php';
    include_once '../objects/Cart.php';

    $database = new Database();
    $db = $database->getConnection();

    $cart = new Cart($db);

    if($cart->delete($id)) {
        http_response_code(200);
        echo json_encode(array("message" => "Cart deleted."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to delete cart."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Missing cart ID."));
}
?>