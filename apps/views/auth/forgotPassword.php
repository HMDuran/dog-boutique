<title>Password Reset Request</title>
<link rel="stylesheet" href="/public/styles/auth/requestReset.css">
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<script>
        $(document).ready(function() {
            $.notify('{$_SESSION['error']}', { className: 'error', position: 'top right' });
        });
    </script>";
    unset($_SESSION['error']); 
}
?>

<div class="container">
    <div class="card">
        <a href="/apps/views/home/home.php"><img src="/public/assets/img/logo/logo.svg" alt="logo"></a>
        <h2>Request Password Reset</h2>

        <form id="resetForm" action="/api/user/forgot_password.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>