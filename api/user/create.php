<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // Include database and object files
    include_once '../../config/database.php';
    include_once '../objects/user.php';

    // Instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();

    // Instantiate user object
    $user = new User($db);

   // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Set user properties based on form input
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->phone_number = $_POST['phone_number'];
        $user->delivery_address = $_POST['delivery_address'];
        $user->created_at = date('Y-m-d H:i:s');

        // Attempt to create the user
        if ($user->create()) {
            // Set response code
            http_response_code(200);
            // User created successfully
            header('Location: ../../apps/views/auth/login.php');
            exit(); 
        } else {
            http_response_code(400);
            // User creation failed
            echo json_encode(array('message' => 'Failed to create user'));
        }
    } else {
        // Form not submitted
        echo json_encode(array('message' => 'Form not submitted'));
    }
?>