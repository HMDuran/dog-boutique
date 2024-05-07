<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

include '../../config/database.php';
include '../objects/Orders.php';
include '../objects/OrderItems.php';

$database = new Database();
$db = $database->getConnection();

$order = new Orders($db);

$stmt = $order->readWithItems();
$num = $stmt->rowCount();

if ($num > 0) {
    $orders_arr = array();
    $orders_arr["data"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $customer_name = $first_name . ' ' . $last_name;
        $order_items_arr = array();

        $items = explode('<br>', $order_items);

        foreach ($items as $item) {
            $item_details = explode('x ', $item);
            $quantity = $item_details[0];
            $product_name = $item_details[1];

            $order_items_arr[] = array(
                "quantity" => $quantity,
                "product_name" => $product_name
            );
        }

        $order_item = array(
            "id" => $id,
            "order_number" => $id,
            "order_date" => $created_at, 
            "customer_name" => $customer_name,
            "order_items" => $order_items_arr,
            "total_amount" => $total_amount,
            "status" => $status
        );

        array_push($orders_arr["data"], $order_item);
    }

    http_response_code(200);
    echo json_encode($orders_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No orders found."));
}
?>
