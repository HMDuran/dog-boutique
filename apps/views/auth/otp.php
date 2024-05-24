<title>OTP Verification</title>
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">
<link rel="stylesheet" href="/public/styles/auth/otp.css">

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