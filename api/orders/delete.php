<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../objects/Orders.php';
include_once '../objects/OrderItems.php';

$database = new Database();
$db = $database->getConnection();

$orders = new Orders($db);
$orderItems = new OrderItems($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $orderId = $data->id;

    if ($orderItems->deleteOrderItems($orderId)) {
        if ($orders->deleteOrder($orderId)) {
            http_response_code(200);
            echo json_encode(array("message" => "Order and related items deleted successfully."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Unable to delete order."));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Unable to delete related order items."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to delete order. ID is missing."));
}

?>
