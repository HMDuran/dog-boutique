<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; 

include '../../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

$mail = new PHPMailer(true);

function generateOTP() {
    return rand(100000, 999999); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if there's an existing OTP for the user
            $stmt_otp = $pdo->prepare("SELECT id FROM password_resets WHERE user_id = ?");
            $stmt_otp->execute([$user['id']]);
            $existing_otp = $stmt_otp->fetch(PDO::FETCH_ASSOC);

            if ($existing_otp) {
                // Update existing OTP
                $otp = generateOTP();
                $updateStmt = $pdo->prepare("UPDATE password_resets SET otp = ? WHERE user_id = ?");
                $updateStmt->execute([$otp, $user['id']]);
            } else {
                // Insert new OTP
                $otp = generateOTP();
                $insertStmt = $pdo->prepare("INSERT INTO password_resets (user_id, otp) VALUES (?, ?)");
                $insertStmt->execute([$user['id'], $otp]);
            }
            
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'dogboutique.mybestfriend@gmail.com'; 
                $mail->Password   = 'jidndtixvtagxyvu';     
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;           

                $mail->setFrom('dogboutique.mybestfriend@gmail.com', 'dog-boutique');
                $mail->addAddress($email); 

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset OTP';
                $mail->Body    = 'Your password reset OTP is: ' . $otp;
                $mail->AltBody = 'Your password reset OTP is: ' . $otp;

                $mail->send();
                header("Location: ../../../../apps/views/auth/otp.php?user_id={$user['id']}");
                exit();
            } catch (Exception $e) {
                echo "Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: User not found.";
        }
    } else {
        echo "Error: Email field is empty.";
    }
}
?>