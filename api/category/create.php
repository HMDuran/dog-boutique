<?php
session_start();
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/database.php';
include_once '../objects/Category.php';

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['c_name'])) {

        $category->name = $_POST['c_name'];

        if ($category->create()) {
            $_SESSION['notifications'][] = array("type" => "success", "message" => "Category was created.");
            header("Location: ../../apps/views/dashboard/dashboard.php#category");
            exit();
        } else {
            $_SESSION['notifications'][] = array("type" => "error", "message" => "Unable to create category.");
            header("Location: ../../apps/views/dashboard/dashboard.php#category");
            exit();
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create category. Data is incomplete."));
    }
    } else {
        http_response_code(405);
        echo json_encode(array("message" => "Method Not Allowed."));
    }

?>
