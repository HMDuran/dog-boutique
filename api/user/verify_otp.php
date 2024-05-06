<?php
include '../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_GET['user_id'];
    $submitted_otp = $_POST['otp'];

    // Debugging: Output user ID to verify it's correct
    echo "Debug: User ID = $user_id<br>";

    // Retrieve the stored OTP from the database
    $stmt_select = $pdo->prepare("SELECT otp FROM password_resets WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    if (!$stmt_select) {
        // Debugging: Output SQL error message if the query preparation fails
        echo "SQL error: " . $pdo->errorInfo()[2] . "<br>";
        exit(); // Exit script if there's a SQL error
    }
    $stmt_select->execute([$user_id]);
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $stored_otp = $row['otp'];

        // Compare the submitted OTP with the stored OTP
        if ($submitted_otp == $stored_otp) {
            // Redirect to the password reset page if OTP is correct
            header("Location: /apps/views/auth/resetPassword.php?user_id=$user_id");
            exit();
        } else {
            // Display error message if OTP is incorrect
            echo "Error: Invalid OTP. Please try again.";
        }
    } else {
        // Display error message if no OTP is found for the user
        echo "Error: No OTP found for the user.";
    }
}
?>
