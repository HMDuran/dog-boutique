<?php
session_start();
include '../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_GET['user_id'];
    $submitted_otp = $_POST['otp'];

    $stmt_select = $pdo->prepare("SELECT otp FROM password_resets WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt_select->execute([$user_id]);
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $stored_otp = $row['otp'];
        if ($submitted_otp == $stored_otp) {
            $_SESSION['notifications'][] = ["type" => "success", "message" => "OTP verified successfully."];
            header("Location: /apps/views/auth/resetPassword.php?user_id=$user_id");
            exit();
        } else {
            $_SESSION['notifications'][] = ["type" => "error", "message" => "Invalid OTP. Please try again."];
            header("Location: /apps/views/auth/otp.php?user_id=$user_id");
            exit();
        }
    } else {
        $_SESSION['notifications'][] = ["type" => "error", "message" => "No OTP found for this user."];
        header("Location: /apps/views/auth/otp.php?user_id=$user_id");
        exit();
    }
}
?>