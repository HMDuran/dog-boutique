<?php
session_start();
require_once '../../config/Database.php';
require_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->phone_number = $_POST['phone_number'];
    $user->delivery_address = $_POST['delivery_address'];
    $user->created_at = date('Y-m-d H:i:s');

    $result = $user->create();

    if ($result === true) {
        $_SESSION['notifications'][] = ["message" => "Account created successfully!", "type" => "success"];        
        echo json_encode(["success" => true, "redirect" => "/apps/views/auth/login.php"]);
        exit();
    } elseif (is_array($result)) {
        echo json_encode(["success" => false, "errors" => $result]);
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to create user."]);
        exit();
    }
}
?>
