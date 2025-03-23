<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; 
include '../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    if (!$user_id) {
        echo json_encode(["type" => "error", "message" => "Invalid user ID."]);
        exit();
    }

    $stmt_email = $pdo->prepare("SELECT email FROM users WHERE id = ?");
    $stmt_email->execute([$user_id]);
    $user = $stmt_email->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(["type" => "error", "message" => "User not found."]);
        exit();
    }

    $otp = rand(100000, 999999);

    $stmt_otp = $pdo->prepare("SELECT id FROM password_resets WHERE user_id = ?");
    $stmt_otp->execute([$user_id]);
    $existing_otp = $stmt_otp->fetch(PDO::FETCH_ASSOC);

    if ($existing_otp) {
        $updateStmt = $pdo->prepare("UPDATE password_resets SET otp = ?, created_at = NOW() WHERE user_id = ?");
        $success = $updateStmt->execute([$otp, $user_id]);
    } else {
        $insertStmt = $pdo->prepare("INSERT INTO password_resets (user_id, otp, created_at) VALUES (?, ?, NOW())");
        $success = $insertStmt->execute([$user_id, $otp]);
    }

    if ($success) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dogboutique.mybestfriend@gmail.com';
            $mail->Password = 'jidndtixvtagxyvu';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('dogboutique.mybestfriend@gmail.com', 'dog-boutique');
            $mail->addAddress($user['email']);

            $mail->isHTML(true);
            $mail->Subject = 'Your New OTP Code';
            $mail->Body    = 'Your new OTP is: ' . $otp;
            $mail->AltBody = 'Your new OTP is: ' . $otp;

            $mail->send();
            echo json_encode(["type" => "success", "message" => "A new OTP has been sent to your email."]);
        } catch (Exception $e) {
            echo json_encode(["type" => "error", "message" => "OTP email failed to send."]);
        }
    } else {
        echo json_encode(["type" => "error", "message" => "Failed to generate OTP. Try again."]);
    }
}
?>