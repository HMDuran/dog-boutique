<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../../config/Database.php';
include_once '../objects/Product.php';
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
  
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || is_null($data->id)) {
    http_response_code(400); 
    echo json_encode(array("message" => "Product ID is missing."));
    exit();
}

$product = new Product($db); 
$product->id = htmlspecialchars(strip_tags($data->id));

if($product->delete()) {
    http_response_code(200); 
    echo json_encode(array("message" => "Product deleted."));
} else {
    http_response_code(500);  
    echo json_encode(array("message" => "Unable to delete product.", "error" => $conn->error)); 
}
?>