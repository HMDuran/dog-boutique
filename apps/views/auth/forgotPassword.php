<link rel="stylesheet" href="/public/styles/auth/requestReset.css">
<title>Password Reset Request</title>

<div class="container">
    <div class="card">
        <a href="/apps/views/home/home.php"><img src="/public/assets/img/logo/logov2.svg" alt="logo"></a>
        <h2>Request Password Reset</h2>

        <form id="resetForm" action="/api/user/forgot_password.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>