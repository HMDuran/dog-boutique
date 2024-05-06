<title>Login</title>
<link rel="stylesheet" href="/public/styles/auth/login.css">

<main>
    <div class="container">
        <a href="/apps/views/home/home.php">
            <img src="/public/assets/img/logo/logov2.svg" alt="logo">
        </a>    
        <h1>Member Login</h1>
        <p>Doesn't have an account yet? <a href="/apps/views/auth/signup.php">Sign Up</a></p>

        <Form action="/api/user/read.php" method="POST">
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
        </Form>
    </div>
</main>