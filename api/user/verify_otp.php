<?php
session_start();

include '../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_GET['user_id'];
    $submitted_otp = $_POST['otp'];

    echo "Debug: User ID = $user_id<br>";

    $stmt_select = $pdo->prepare("SELECT otp FROM password_resets WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    if (!$stmt_select) {
        echo "SQL error: " . $pdo->errorInfo()[2] . "<br>";
        exit(); 
    }
    $stmt_select->execute([$user_id]);
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $stored_otp = $row['otp'];
        if ($submitted_otp == $stored_otp) {
            $_SESSION['notifications'][] = array("type" => "success", "message" => "OTP verified successfully. You can now reset your password.");
            header("Location: /apps/views/auth/resetPassword.php?user_id=$user_id");
            exit();
        } else {
            echo "Error: Invalid OTP. Please try again.";
        }
    } else {
        echo "Error: No OTP found for the user.";
    }
}
?>
