<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Planet - Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-wrapper">
            <!-- Left Side - Branding -->
            <div class="branding-section">
                <div class="branding-content">
                    <div class="logo">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="28" fill="#FF6B35" opacity="0.2"/>
                            <path d="M30 10C35 10 40 15 40 20V25C40 30 35 35 30 35C25 35 20 30 20 25V20C20 15 25 10 30 10Z" fill="#FF6B35"/>
                            <path d="M30 35C35 35 40 40 40 45V50H20V45C20 40 25 35 30 35Z" fill="#FF6B35"/>
                        </svg>
                        <h1>Protein Planet</h1>
                    </div>
                    <p class="tagline">Fuel Your Fitness Journey</p>
                    <div class="features">
                        <div class="feature-item">
                            <span class="icon">💪</span>
                            <span>Premium Quality</span>
                        </div>
                        <div class="feature-item">
                            <span class="icon">🏋️</span>
                            <span>Trusted by Athletes</span>
                        </div>
                        <div class="feature-item">
                            <span class="icon">🌟</span>
                            <span>Best Results</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="form-section">
                <div class="form-content">
                    <h2>Welcome Back</h2>
                    <p class="subtitle">Login to manage your supplement store</p>

                    <!-- User Type Selection -->
                    <div class="user-type-selector">
                        <button type="button" class="type-btn active" data-type="admin">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2C7.24 2 5 4.24 5 7c0 2.76 2.24 5 5 5s5-2.24 5-5c0-2.76-2.24-5-5-5zm0 2c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Admin
                        </button>
                        <button type="button" class="type-btn" data-type="staff">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2C8.34 2 7 3.34 7 5c0 1.66 1.34 3 3 3s3-1.34 3-3c0-1.66-1.34-3-3-3zm0 2c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm5 4c-1.66 0-3 1.34-3 3 0 1.66 1.34 3 3 3s3-1.34 3-3c0-1.66-1.34-3-3-3zm-10 0c-1.66 0-3 1.34-3 3 0 1.66 1.34 3 3 3s3-1.34 3-3c0-1.66-1.34-3-3-3zM10 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Staff
                        </button>
                    </div>

                    <!-- Login Form -->
                    <form id="loginForm">
                        <input type="hidden" name="user_type" id="userType" value="admin">
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 4h16v12H2V4zm14 2l-6 4-6-4v10h12V6z"/>
                                </svg>
                                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 2C7.8 2 6 3.8 6 6v2H5c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2h-1V6c0-2.2-1.8-4-4-4zm0 2c1.1 0 2 .9 2 2v2H8V6c0-1.1.9-2 2-2z"/>
                                </svg>
                                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 5C5 5 1.73 8.11 1 10c.73 1.89 4 5 9 5s8.27-3.11 9-5c-.73-1.89-4-5-9-5zm0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm0-4.8c-.99 0-1.8.81-1.8 1.8s.81 1.8 1.8 1.8 1.8-.81 1.8-1.8-.81-1.8-1.8-1.8z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="form-options">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember" id="rememberMe">
                                <span class="checkmark"></span>
                                Remember me
                            </label>
                            <a href="reset-password.php" class="forgot-link">Forgot Password?</a>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Sign In</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2L8.59 3.41 13.17 8H2v2h11.17l-4.58 4.59L10 16l6-6-6-6z"/>
                            </svg>
                        </button>
                    </form>

                    <div class="help-text">
                        <p>Need help? Contact <a href="mailto:support@proteinplanet.com">support@proteinplanet.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    
    <!-- Firebase Configuration -->
    <script src="js/firebase-config.js"></script>
    
    <!-- Login Script -->
    <script src="js/login.js"></script>
</body>
</html>
