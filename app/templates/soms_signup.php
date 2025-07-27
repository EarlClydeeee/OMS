<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOMS - Sign Up</title>
    <link rel="stylesheet" href="../assets/css/soms_signup.css">
</head>
<body>
    <div class="signup-container">
        <h2 class="signup-title">Create Account</h2>
        <form method="POST" action="../controllers/sign_in.php" autocomplete="off">
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-input" placeholder="Enter your username" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" class="form-input" placeholder="First name" required>
                </div>
                
                <div class="form-lastname">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" class="form-input" placeholder="Last name" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-input" placeholder="Confirm your password" required>
            </div>
            
            <button type="submit" class="signup-btn">Create Account</button>
        </form>
        <p class="login-link">Already have an account? <a href="soms_login.php">Log in here</a></p>
    </div>

</body>
</html>