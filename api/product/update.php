<?php
session_start();

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
        if ($_FILES["image"]["error"] == 0) {
            $name = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];

            $location = "../../uploads/";
            $finalImage = $location . $name;

            if (move_uploaded_file($temp, $finalImage)) {
                $product->id = $_POST['product_id'];
                $product->name = $_POST['name'];
                $product->image = $finalImage;
                $product->description = $_POST['description'];
                $product->price = $_POST['price'];
                $product->stock = $_POST['stock'];
                $product->categoryid = $_POST['categoryid'];
                $product->updated_at = date('Y-m-d H:i:s');

                if ($product->update()) {
                    $_SESSION['notifications'][] = array("type" => "success", "message" => "Product was updated.");
                    header("Location: ../../apps/views/dashboard/dashboard.php#products");
                    exit();
                } else {
                    $_SESSION['notifications'][] = array("type" => "error", "message" => "Unable to update product.");
                    header("Location: ../../apps/views/dashboard/dashboard.php#products");
                    exit();
                }
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Failed to move uploaded file."));
            }
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Error uploading file."));
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