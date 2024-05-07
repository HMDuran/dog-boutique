<?php 
include_once '../../config/Database.php';
include_once '../objects/Orders.php';

$database = new Database();
$db = $database->getConnection();

$order = new Orders($db);

$id = isset($_GET['id']) ? $_GET['id'] : die('Order ID not provided.');

$order->id = $id;
$order->readOne();

$order_arr = array(
    "id" => $order->id,
    "status" => $order->status 
);
print_r(json_encode($order_arr));
?>