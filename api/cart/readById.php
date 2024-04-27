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

if (isset($_GET['cartItemIds'])) {
    $itemIds = $_GET['cartItemIds'];

    $itemIdsArray = explode(',', $itemIds);

    $result = $cart->readByIds($itemIdsArray);

    if (is_array($result)) {
        $numRows = count($result);
    } else {
        $numRows = $result->rowCount();
    }

    if ($numRows > 0) {
        $items_arr = array();
        $items_arr["data"] = array();

        foreach ($result as $row) {
            extract($row);
            $item = array(
                "id" => $id,
                "image" => $image,
                "name" => $name,
                "quantity" => $quantity,
                "price" => $price,
                "total_amount" => $total_amount
            );
            array_push($items_arr["data"], $item);
        }
        http_response_code(200);
        echo json_encode($items_arr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No items found.")
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array("message" => "Bad request. 'cartItemIds' parameter is missing.")
    );
}
?>
