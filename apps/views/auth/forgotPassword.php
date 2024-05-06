<link rel="stylesheet" href="/public/styles/auth/requestReset.css">
<title>Password Reset Request</title>

<div class="container">
    <div class="card">
        <img src="/public/assets/img/logo/logov2.svg" alt="Logo">
        <h2>Request Password Reset</h2>

        <form id="resetForm" action="/api/user/forgot_password.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>