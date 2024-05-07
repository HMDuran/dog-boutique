<?php
include_once '../../config/Database.php';
include_once '../objects/Orders.php';

$database = new Database();
$db = $database->getConnection();

$order = new Orders($db);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->status)) {
    $order->id = $data->id;
    $order->status = $data->status;

    if ($order->updateStatus()) {
        http_response_code(200);
        echo json_encode(array("message" => "Order status updated successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update order status."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid data provided."));
}
?>
