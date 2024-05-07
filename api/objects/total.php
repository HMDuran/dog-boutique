<?php
include_once '../../config/Database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();

    $sqlCategories = "SELECT COUNT(*) AS totalCategories FROM categories";
    $stmtCategories = $pdo->query($sqlCategories);
    $rowCategories = $stmtCategories->fetch(PDO::FETCH_ASSOC);
    $totalCategories = $rowCategories['totalCategories'];

    $sqlProducts = "SELECT COUNT(*) AS totalProducts FROM products";
    $stmtProducts = $pdo->query($sqlProducts);
    $rowProducts = $stmtProducts->fetch(PDO::FETCH_ASSOC);
    $totalProducts = $rowProducts['totalProducts'];

    $sqlUsers = "SELECT COUNT(*) AS totalUsers FROM users";
    $stmtUsers = $pdo->query($sqlUsers);
    $rowUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC);
    $totalUsers = $rowUsers['totalUsers'];

    $sqlOrders = "SELECT COUNT(*) AS totalOrders FROM orders";
    $stmtOrders = $pdo->query($sqlOrders);
    $rowOrders = $stmtOrders->fetch(PDO::FETCH_ASSOC);
    $totalOrders = $rowOrders['totalOrders'];

    $sqlNewOrders = "SELECT COUNT(*) AS totalNewOrders FROM orders WHERE status = 'pending'";
    $stmtNewOrders = $pdo->query($sqlNewOrders);
    $rowNewOrders = $stmtNewOrders->fetch(PDO::FETCH_ASSOC);
    $totalNewOrders = $rowNewOrders['totalNewOrders'];
    
    $response = [
        'totalCategories' => $totalCategories,
        'totalProducts' => $totalProducts,
        'totalUsers' => $totalUsers,
        'totalOrders' => $totalOrders,
        'totalNewOrders' => $totalNewOrders
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

?>