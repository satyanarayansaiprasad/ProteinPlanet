/**
 * Protein Planet - Login Script with Firebase Authentication
 */

// User Type Selector
const typeButtons = document.querySelectorAll('.type-btn');
const userTypeInput = document.getElementById('userType');

typeButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons
        typeButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        this.classList.add('active');
        
        // Update hidden input value
        const userType = this.getAttribute('data-type');
        userTypeInput.value = userType;
        
        // Update form styling based on user type
        updateFormStyle(userType);
    });
});

function updateFormStyle(userType) {
    const formSection = document.querySelector('.form-section');
    
    if (userType === 'admin') {
        formSection.style.borderLeft = '4px solid var(--primary-color)';
    } else {
        formSection.style.borderLeft = '4px solid var(--secondary-color)';
    }
}

// Password Toggle
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (togglePassword) {
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Change icon
        this.innerHTML = type === 'password' 
            ? `<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 5C5 5 1.73 8.11 1 10c.73 1.89 4 5 9 5s8.27-3.11 9-5c-.73-1.89-4-5-9-5zm0 8c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm0-4.8c-.99 0-1.8.81-1.8 1.8s.81 1.8 1.8 1.8 1.8-.81 1.8-1.8-.81-1.8-1.8-1.8z"/>
              </svg>`
            : `<svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 5C5 5 1.73 8.11 1 10c.18.47.88 1.94 2.66 3.44l1.42-1.42C3.74 10.85 3.18 10.16 3 10c.73-1.89 4-5 7-5 .84 0 1.64.16 2.4.43l1.51-1.51C12.68 3.33 11.37 3 10 3zm9 5c-.18-.47-.88-1.94-2.66-3.44l-1.42 1.42C16.26 9.15 16.82 9.84 17 10c-.73 1.89-4 5-7 5-.84 0-1.64-.16-2.4-.43l-1.51 1.51C7.32 16.67 8.63 17 10 17c5 0 8.27-3.11 9-5zM2 2l1.41 1.41 14.17 14.17L19 16.17 4.83 2 2 2z"/>
              </svg>`;
    });
}

// Form Validation and Submission with Firebase
const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Get form values
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const userType = userTypeInput.value;
    const remember = document.getElementById('rememberMe').checked;
    
    // Basic validation
    if (!validateEmail(email)) {
        showMessage('Please enter a valid email address', 'error');
        return;
    }
    
    if (password.length < 6) {
        showMessage('Password must be at least 6 characters long', 'error');
        return;
    }
    
    // Show loading state
    const submitBtn = document.querySelector('.submit-btn');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    
    try {
        // Sign in with Firebase Authentication
        const userCredential = await firebaseAuth.signInWithEmailAndPassword(email, password);
        const user = userCredential.user;
        
        console.log('🔥 User signed in:', user.uid);
        
        // Get user metadata from Firestore
        const userDoc = await firebaseDb.collection('users').doc(user.uid).get();
        
        if (!userDoc.exists) {
            throw new Error('User data not found. Please contact administrator.');
        }
        
        const userData = userDoc.data();
        
        // Check if user type matches
        if (userData.userType !== userType) {
            showMessage(`This account is not a ${userType} account. Please select the correct user type.`, 'error');
            await firebaseAuth.signOut();
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            return;
        }
        
        // Check if user is active
        if (userData.status !== 'active') {
            showMessage('Your account is inactive. Please contact administrator.', 'error');
            await firebaseAuth.signOut();
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            return;
        }
        
        // Set persistence based on "Remember Me"
        if (remember) {
            await firebaseAuth.setPersistence(firebase.auth.Auth.Persistence.LOCAL);
        } else {
            await firebaseAuth.setPersistence(firebase.auth.Auth.Persistence.SESSION);
        }
        
        // Store user info in sessionStorage for quick access
        sessionStorage.setItem('userName', userData.name);
        sessionStorage.setItem('userEmail', user.email);
        sessionStorage.setItem('userType', userData.userType);
        sessionStorage.setItem('userId', user.uid);
        
        // Show success message
        showMessage('Login successful! Redirecting...', 'success');
        
        // Redirect based on user type
        setTimeout(() => {
            if (userData.userType === 'admin') {
                window.location.href = 'admin_dashboard.php';
            } else {
                window.location.href = 'staff_dashboard.php';
            }
        }, 1000);
        
    } catch (error) {
        console.error('Login error:', error);
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;
        
        // Handle specific Firebase errors
        let errorMessage = 'Login failed. Please try again.';
        
        switch (error.code) {
            case 'auth/user-not-found':
                errorMessage = 'No account found with this email address.';
                break;
            case 'auth/wrong-password':
                errorMessage = 'Incorrect password. Please try again.';
                break;
            case 'auth/invalid-email':
                errorMessage = 'Invalid email address format.';
                break;
            case 'auth/user-disabled':
                errorMessage = 'This account has been disabled.';
                break;
            case 'auth/too-many-requests':
                errorMessage = 'Too many failed login attempts. Please try again later.';
                break;
            case 'auth/network-request-failed':
                errorMessage = 'Network error. Please check your connection.';
                break;
            default:
                errorMessage = error.message || 'An error occurred during login.';
        }
        
        showMessage(errorMessage, 'error');
    }
});

// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Show message function
function showMessage(message, type) {
    // Remove existing message if any
    const existingMessage = document.querySelector('.message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    // Create new message
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = message;
    
    // Insert before form
    const form = document.getElementById('loginForm');
    form.parentNode.insertBefore(messageDiv, form);
    
    // Show message with animation
    setTimeout(() => {
        messageDiv.classList.add('show');
    }, 10);
    
    // Remove message after 5 seconds
    setTimeout(() => {
        messageDiv.classList.remove('show');
        setTimeout(() => {
            messageDiv.remove();
        }, 300);
    }, 5000);
}

// Input animations and enhancements
const inputs = document.querySelectorAll('.input-wrapper input');

inputs.forEach(input => {
    // Add floating label effect
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        if (this.value === '') {
            this.parentElement.classList.remove('focused');
        }
    });
    
    // Check if input has value on page load
    if (input.value !== '') {
        input.parentElement.classList.add('focused');
    }
});

// Prevent form submission on Enter key in input fields
inputs.forEach(input => {
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            loginForm.dispatchEvent(new Event('submit'));
        }
    });
});

// Smooth animations on page load
window.addEventListener('load', function() {
    document.querySelector('.login-wrapper').style.animation = 'fadeInScale 0.5s ease forwards';
});

// Add animation keyframes dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
`;
document.head.appendChild(style);

// Check if user is already logged in
firebaseAuth.onAuthStateChanged((user) => {
    if (user && window.location.pathname.includes('login.php')) {
        // User is already logged in, redirect to appropriate dashboard
        firebaseDb.collection('users').doc(user.uid).get()
            .then(doc => {
                if (doc.exists) {
                    const userData = doc.data();
                    if (userData.userType === 'admin') {
                        window.location.href = 'admin_dashboard.php';
                    } else {
                        window.location.href = 'staff_dashboard.php';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking user status:', error);
            });
    }
});

console.log('🔥 Login script loaded with Firebase Authentication!');
