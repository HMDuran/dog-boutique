<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../objects/Orders.php';

$database = new Database();
$db = $database->getConnection();

$order = new Orders($db);

if (isset($_SESSION['user'])) {
    $order->user_id = $_SESSION['user']['id'];

    $stmt = $order->readDetails();

    if ($stmt) {
        $num = $stmt->rowCount();

        if ($num > 0) {
            $order_arr = array();
            $order_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $order_item = array(
                    "id" => $id,
                    "first_name" => $first_name,
                    "last_name" => $last_name
                );

                $order_arr["records"][] = $order_item;
            }

            echo json_encode($order_arr);
        } else {
            echo json_encode(array("message" => "No orders found."));
        }
    } else {
        echo json_encode(array("message" => "Error fetching orders."));
    }
} else {
    echo json_encode(array("message" => "User is not authenticated."));
}
?>
