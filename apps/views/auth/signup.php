<title>Sign Up</title>
<link rel="stylesheet" href="/public/styles/auth/signup.css">
<main>
    <div class="container">
         <a href="/apps/views/home/home.php">
            <img src="/public/assets/img/logo/logov2.svg" alt="logo">
        </a>    
        <h1>Create Account</h1>
        <p>Already have an account? <a href="../auth/login.php">Login</a></p>
        <Form action="/api/user/create.php" method="POST">

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
        </Form>
    </div>
</main>