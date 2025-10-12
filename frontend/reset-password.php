<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Protein Planet</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-wrapper" style="grid-template-columns: 1fr; max-width: 500px; margin: 0 auto;">
            <!-- Reset Password Form -->
            <div class="form-section">
                <div class="form-content">
                    <h2>Reset Password</h2>
                    <p class="subtitle">Enter your email to receive a password reset link</p>

                    <!-- Reset Form -->
                    <form id="resetForm">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 4h16v12H2V4zm14 2l-6 4-6-4v10h12V6z"/>
                                </svg>
                                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Send Reset Link</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2L8.59 3.41 13.17 8H2v2h11.17l-4.58 4.59L10 16l6-6-6-6z"/>
                            </svg>
                        </button>
                    </form>

                    <div class="help-text" style="margin-top: 20px;">
                        <p>Remember your password? <a href="login.php">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    
    <!-- Firebase Configuration -->
    <script src="js/firebase-config.js"></script>
    
    <!-- Reset Password Script -->
    <script>
        const resetForm = document.getElementById('resetForm');

        resetForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const submitBtn = document.querySelector('.submit-btn');
            
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            try {
                await firebaseAuth.sendPasswordResetEmail(email);
                showMessage('Password reset link sent! Check your email.', 'success');
                
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 3000);
                
            } catch (error) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                
                let errorMessage = 'Failed to send reset link.';
                
                switch (error.code) {
                    case 'auth/user-not-found':
                        errorMessage = 'No account found with this email.';
                        break;
                    case 'auth/invalid-email':
                        errorMessage = 'Invalid email address.';
                        break;
                    default:
                        errorMessage = error.message;
                }
                
                showMessage(errorMessage, 'error');
            }
        });

        function showMessage(message, type) {
            const existingMessage = document.querySelector('.message');
            if (existingMessage) existingMessage.remove();
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${type}`;
            messageDiv.textContent = message;
            
            const form = document.getElementById('resetForm');
            form.parentNode.insertBefore(messageDiv, form);
            
            setTimeout(() => messageDiv.classList.add('show'), 10);
            
            setTimeout(() => {
                messageDiv.classList.remove('show');
                setTimeout(() => messageDiv.remove(), 300);
            }, 5000);
        }
    </script>
</body>
</html>

