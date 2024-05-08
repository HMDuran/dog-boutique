<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->phone_number = $_POST['phone_number'];
    $user->delivery_address = $_POST['delivery_address'];
    $user->created_at = date('Y-m-d H:i:s');

    if ($user->create()) {
        $_SESSION['notifications'][] = array("type" => "success", "message" => "Created Successfully, You can now login to your account.");
        header('Location: ../../apps/views/auth/login.php');
        exit(); 
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'Failed to create user'));
    }
} else {
    echo json_encode(array('message' => 'Form not submitted'));
}
?>