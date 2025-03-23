<title>Sign Up</title>

<link rel="stylesheet" href="/public/styles/auth/signup.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">

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

<main>
    <div class="container">
        <a href="/apps/views/home/home.php">
            <img src="/public/assets/img/logo/logo.svg" alt="logo">
        </a>    
        <h1>Create Account</h1>
        <p>Already have an account? <a href="../auth/login.php">Login</a></p>
        
        <form id="signupForm" action="/api/user/create.php" method="POST">
            <div class="input-name">
                <div class="input-one">
                    <label for="firstname">First Name</label>
                    <input type="text" name="first_name" id="firstname">
                </div>

                <div class="input-two">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="last_name" id="lastname">
                </div>
            </div>

            <div class="input">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <i class="far fa-eye" id="togglePassword"></i>
            </div>

            <div class="input">
                <label for="phonenum">Phone Number</label>
                <input type="number" name="phone_number" id="phonenum">
            </div>

            <div class="input">
                <label for="delivery_address">Delivery Address</label>
                <input type="text" name="delivery_address" id="delivery_address">
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>
</main>

<script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const password = document.getElementById("password");
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash");
});

document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    let formData = new FormData(this);

    fetch("/api/user/create.php", { 
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else if (data.errors) {
            data.errors.forEach(error => {
                $.notify(error, { className: "error", position: "top right" });
            });
        } else {
            $.notify("Something went wrong!", { className: "warn", position: "top right" });
        }
    })
    .catch(error => console.error("Error:", error));
});
</script>
