<?php
Session_start();

// Define the routes and their corresponding handlers
$routes = [
    '/home' => 'home',
];

// Get the requested URL
$request_uri = $_SERVER['REQUEST_URI'];

// Remove query parameters (if any)
$request_uri = strtok($request_uri, '?');

// Remove leading and trailing slashes
$request_uri = trim($request_uri, '/');

// Check if the requested route exists
if (array_key_exists($request_uri, $routes)) {
    // Invoke the corresponding handler function
    $handler = $routes[$request_uri];
    call_user_func($handler);
} else {
    home();
}

// Define handler functions
function home() {
   include 'apps/views/home/home.php';
}
?>
