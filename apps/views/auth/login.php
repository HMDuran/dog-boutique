<title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">
<link rel="stylesheet" href="/public/styles/auth/login.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<main>
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
    <div class="container">
        <a href="/apps/views/home/home.php">
            <img src="/public/assets/img/logo/logov2.svg" alt="logo">
        </a>    
        <h1>Member Login</h1>
        <p>Doesn't have an account yet? <a href="/apps/views/auth/signup.php">Sign Up</a></p>

        <form action="/api/user/read.php" method="POST">
            <div class="input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
           
            <a href="/apps/views/auth/forgotPassword.php">Forgot Password?</a>
            </div>

            <button type="submit">Login</button>            
        </form>
    </div>
</main>