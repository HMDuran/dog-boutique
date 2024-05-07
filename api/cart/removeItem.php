<?php
session_start();

include_once '../../config/Database.php';
include_once '../objects/Cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);

if (isset($_POST['cartItemIds'])) {
    $itemIds = $_POST['cartItemIds'];

    $itemIdsArray = explode(',', $itemIds);

    $cart->removeItems($itemIdsArray);

    echo json_encode(array("success" => true));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Bad request. 'cartItemIds' parameter is missing."));
}
?>
