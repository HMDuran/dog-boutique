<?php
Session_start();

$routes = [
    '/home' => 'home',
];

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = strtok($request_uri, '?');
$request_uri = trim($request_uri, '/');

if (array_key_exists($request_uri, $routes)) {
    $handler = $routes[$request_uri];
    call_user_func($handler);
} else {
    home();
}

function home() {
   include 'apps/views/home/home.php';
}
?>