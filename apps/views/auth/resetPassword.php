<link rel="stylesheet" href="/public/styles/auth/resetPassword.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<title>Reset Password</title>

<div class="container">
<?php 
    session_start();
    if (isset($_SESSION['notifications']) && is_array($_SESSION['notifications'])) {
        foreach ($_SESSION['notifications'] as $notification) {
            $type = $notification['type'];
            $message = $notification['message'];
            echo "<script>$.notify('$message', '$type');</script>";
        }
        unset($_SESSION['notifications']); 
    }
?>
    <div class="card">
        <img src="/public/assets/img/logo/logov2.svg" alt="logo">
        <h1>Reset Your Password</h1>
        
        <form action="/api/user/resetPassword.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['user_id'] ?? ''); ?>">
           
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>

<script>
function validateForm() {
    var newPassword = document.getElementById("new_password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (newPassword !== confirmPassword) {
        alert("Passwords do not match.");
        return false; 
    }
    return true;
}
</script>