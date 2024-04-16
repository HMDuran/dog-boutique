<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/database.php';
include_once '../objects/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !empty($_POST['name']) &&
        !empty($_POST['description']) &&
        !empty($_POST['price']) &&
        !empty($_POST['stock']) &&
        !empty($_POST['categoryid']) &&
        !empty($_FILES["image"])
    ) {
        if ($_FILES["image"]["error"] == 0) {
            $name = $_FILES['image']['name'];
            $temp = $_FILES['image']['tmp_name'];

            $location = "../../uploads/";
            $finalImage = $location . $name;

            if (move_uploaded_file($temp, $finalImage)) {
                $product->name = $_POST['name'];
                $product->image = $finalImage;
                $product->description = $_POST['description'];
                $product->price = $_POST['price'];
                $product->stock = $_POST['stock'];
                $product->categoryid = $_POST['categoryid'];
                $product->created_at = date('Y-m-d H:i:s');

                if ($product->create()) {
                    http_response_code(201);
                    echo json_encode(array("message" => "Product was created."));
                } else {
                    http_response_code(503);
                    echo json_encode(array("message" => "Unable to create product."));
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
        // Data is incomplete
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
    }
} else {
    // Method Not Allowed
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed."));
}
?>
