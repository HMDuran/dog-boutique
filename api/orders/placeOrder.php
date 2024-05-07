<?php
session_start();

include_once '../../config/Database.php';
include_once '../objects/Orders.php';
include_once '../objects/OrderItems.php';
include_once '../objects/Product.php';

$database = new Database();
$db = $database->getConnection();

$order = new Orders($db);

if(isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];

    $total_amount = $_POST['total_amount'];
    $orderItems = $_POST['orderItems'];
    $cartItemIds = isset($_POST['cartItemIds']) ? $_POST['cartItemIds'] : [];

    $order->user_id = $user_id;
    $order->total_amount = $total_amount;
    $order->status = "pending"; 
    $order->created_at = date('Y-m-d H:i:s');
    $order->updated_at = date('Y-m-d H:i:s');

    $orderItemsData = [];
    foreach ($orderItems as $item) {
        $orderItemsData[] = array(
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'total_price' => $item['total_price']
        );

        $product = new Product($db);
        $product->updateStock($item['product_id'], $item['quantity']);
    }

    if ($order->create($orderItemsData)) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false));
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "User is not authenticated."));
}
?>
