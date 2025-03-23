<title>OTP Verification</title>
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">
<link rel="stylesheet" href="/public/styles/auth/otp.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<?php
session_start();
if (isset($_SESSION['notifications'])) {
    echo "<script>
        $(document).ready(function() {";
    foreach ($_SESSION['notifications'] as $notification) {
        echo "$.notify('{$notification['message']}', { className: '{$notification['type']}', position: 'top right' });";
    }
    echo "});
    </script>";
    unset($_SESSION['notifications']);
}
?>

<div class="container">
    <div class="card">
    <a href="/apps/views/home/home.php"><img src="/public/assets/img/logo/logo.svg" alt="logo"></a>
        <h1>One-Time Password (OTP) Verification</h1>
        <p>Please enter the One-Time Password (OTP) sent to your email to proceed.</p>

        <form  action="/api/user/verify_otp.php?user_id=<?php echo isset($_GET['user_id']) ? $_GET['user_id'] : ''; ?>" method="POST">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required>
    
            <button type="submit">Verify OTP</button>
        </form>
    </div>
</div>