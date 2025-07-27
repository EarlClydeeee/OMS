<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEPC - Log In</title>
    <link rel="stylesheet" href="../assets/css/soms_login.css">
    <?php require "../controllers/log_in.php"; ?>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="header">
              
                <nav class="nav"> 
                </nav>
            </div>

            <div class="login-container">
                <form class="login-form">
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to your account to continue</p>

                    <form method="POST" action="../controllers/log_in.php">
                        <div class="form-group">
                            <label class="form-label" for="email">Username</label>
                            <input 
                                type="text" 
                                name="username"
                                id="username" 
                                class="form-input" 
                                placeholder="Enter your username"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                class="form-input" 
                                placeholder="Enter your password"
                                required
                            >
                        </div>
                    </form>
                    <div class="forgot-password">
                        <a href="#">Forgot your password?</a>
                    </div>

                    <button type="submit" class="login-btn">
                        Sign In
                    </button>

                    <div class="divider">
                        <span></span>
                    </div>

                    <div class="signup-link"> 
                        Don't have an account? <a href="wsignin.php">Create one here</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="right-section">
            
            <div class="right-content" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                <img src="../assets/images/hepc_white.png" alt="Logo" style="width: 500%; max-width: 650px;">
            </div>
        
        </div>
    </div>
</body>
</html> 