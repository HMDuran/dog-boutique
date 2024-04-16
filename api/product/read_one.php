<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
include_once '../../config/Database.php';
include_once '../objects/Product.php';
  
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
  
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
  
$product->readOne();
  
if($product->name!=null){
    $product_arr = array(
        "id" =>  $product->id,
        "name" => $product->name,
        "image" => $product->image,
        "description" => $product->description,
        "price" => $product->price,
        "stock" => $product->stock,
        "categoryid" => $product->categoryid,
    );
    // set response code - 200 OK
    http_response_code(200);
    // make it json format
    echo json_encode($product_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Product does not exist."));
}
?>