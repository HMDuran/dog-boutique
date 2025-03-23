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
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        $_SESSION['notifications'][] = ["type" => "error", "message" => "Email and Password are required"];
        header('Location: ../../../../apps/views/auth/login.php');
        exit();
    }

    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    $isUserLoggedIn = $user->login();

    if ($isUserLoggedIn === "no_account") {
        $_SESSION['notifications'][] = ["type" => "error", "message" => "No account found with this email"];
        header('Location: ../../../../apps/views/auth/login.php');
        exit();
    } elseif ($isUserLoggedIn === false) {
        $_SESSION['notifications'][] = ["type" => "error", "message" => "Invalid email or password"];
        header('Location: ../../../../apps/views/auth/login.php');
        exit();
    } else {
        $_SESSION['user'] = $isUserLoggedIn;
        http_response_code(200);

        if ($isUserLoggedIn['role'] === 'admin') {
            header('Location: ../../../../apps/views/dashboard/dashboard.php#dashboard');
            exit();
        } elseif ($isUserLoggedIn['role'] === 'customer') {
            header('Location: ../../../../apps/views/home/homeUser.php');
            exit();
        }
    }
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Form not submitted'));
}
?>