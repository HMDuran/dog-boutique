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
 
// if (!empty($_POST)) {
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['product_id'])) {
    if (
        !empty($_POST['product_id']) &&
        !empty($_POST['name']) &&
        !empty($_POST['description']) && 
        !empty($_POST['price']) &&
        !empty($_POST['stock']) &&
        !empty($_POST['categoryid'])
    ) {
        if (isset($_FILES['image'])) {
            $uploadDir = '../../uploads/';
            $fileName = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $product->image = $fileName;
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Failed to upload image."));
                exit;
            }
        }  

        $product->id = $_POST['product_id']; 
        $product->name = $_POST['name']; 
        $product->description = $_POST['description'];
        $product->price = $_POST['price'];
        $product->stock = $_POST['stock'];
        $product->categoryid = $_POST['categoryid']; 
 
      
        if ($product->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Product updated successfully."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Failed to update product."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Incomplete data. Please provide all required fields."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No data received."));
}
?>