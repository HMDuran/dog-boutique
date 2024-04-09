<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password']) && isset($_POST['email'])) {
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if ($user->login()) {
            http_response_code(200);
            if ($user->role === 'admin') {
                header('Location: ../../../../apps/views/dashboard/dashboard.php');
                exit();
            } elseif ($user->role === 'customer') {
                header('Location: ../../../../apps/views/home/homeUser.php');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Invalid email or password. Please try again.';
            header('Location: ../../../../apps/views/auth/login.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'You don\'t have an account';
        header('Location: ../../../../apps/views/auth/login.php');
        exit();
    }
} else {
    http_response_code(400);
    echo json_encode(array('message' => 'Form not submitted'));
}
?>