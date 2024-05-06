<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
include_once '../../config/Database.php';
include_once '../objects/Category.php';
  
$database = new Database();
$db = $database->getConnection();

$category = new Category($db); 
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['c_id'])) {
    if (!empty($_POST['c_id']) &&
        !empty($_POST['c_name'])) {

        $category->id = $_POST['c_id'];
        $category->name= $_POST['c_name'];
        
        if ($category->update()) {
            $_SESSION['notifications'][] = array("type" => "success", "message" => "Category was updated.");
            header("Location: ../../apps/views/dashboard/dashboard.php#category");
            exit();
        } else {
            $_SESSION['notifications'][] = array("type" => "error", "message" => "Unable to update category.");
            header("Location: ../../apps/views/dashboard/dashboard.php#category");
            exit();
        }
    } 
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No data received."));
}
?>