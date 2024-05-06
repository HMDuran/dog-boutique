<?php
include '../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed_password, $user_id]);

    if ($stmt->rowCount() > 0) {
        echo "Password reset successful. You can now login with your new password.";
        header ("Location: ../../../../apps/views/auth/login.php");
        exit();
    } else {
        echo "Error: Failed to reset your password. Please try again later.";
    }
}
?>
