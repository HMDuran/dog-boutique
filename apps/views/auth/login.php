<title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">
<link rel="stylesheet" href="/public/styles/auth/login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<?php 
session_start();
?>

<main>
<?php 
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
            <img src="/public/assets/img/logo/logo.svg" alt="logo">
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
                <i class="far fa-eye" id="togglePassword"></i>
            </div>
            <a href="/apps/views/auth/forgotPassword.php">Forgot Password?</a>

            <button type="submit">Login</button>            
        </form>
    </div>
</main>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

  togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});

$(document).ready(function() {
    $("#loginForm").submit(function(event) {
        event.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action'); 

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === "error") {
                    $.notify(response.message, "error");
                } else if (response.redirect) {
                    window.location.href = response.redirect; 
                }
            },
            error: function() {
                $.notify("Something went wrong. Please try again.", "error");
            }
        });
    });
});
</script>