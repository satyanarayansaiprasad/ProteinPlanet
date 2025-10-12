<?php
// Start session
session_start();

// Set header for JSON response
header('Content-Type: application/json');

// Database configuration (you'll need to update these with your actual database credentials)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'protein_planet');

// Function to connect to database
function getDatabaseConnection() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            return null;
        }
        
        return $conn;
    } catch (Exception $e) {
        return null;
    }
}

// Response array
$response = array(
    'success' => false,
    'message' => '',
    'redirect' => ''
);

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Get POST data
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$user_type = isset($_POST['user_type']) ? $_POST['user_type'] : 'staff';
$remember = isset($_POST['remember']) ? $_POST['remember'] : '0';

// Validate input
if (empty($email) || empty($password)) {
    $response['message'] = 'Please fill in all fields';
    echo json_encode($response);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Invalid email format';
    echo json_encode($response);
    exit;
}

// Connect to database
$conn = getDatabaseConnection();

// If database connection fails, use demo credentials
if ($conn === null) {
    // Demo credentials for testing (REMOVE IN PRODUCTION)
    $demo_users = array(
        'admin' => array(
            'email' => 'admin@proteinplanet.com',
            'password' => 'admin123',
            'name' => 'Admin User',
            'redirect' => '../frontend/admin_dashboard.php'
        ),
        'staff' => array(
            'email' => 'staff@proteinplanet.com',
            'password' => 'staff123',
            'name' => 'Staff User',
            'redirect' => '../frontend/staff_dashboard.php'
        )
    );
    
    // Check demo credentials
    if (isset($demo_users[$user_type])) {
        $demo_user = $demo_users[$user_type];
        
        if ($email === $demo_user['email'] && $password === $demo_user['password']) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = 1;
            $_SESSION['email'] = $email;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['name'] = $demo_user['name'];
            
            // Set remember me cookie if requested
            if ($remember === '1') {
                setcookie('remember_user', $email, time() + (86400 * 30), '/'); // 30 days
            }
            
            $response['success'] = true;
            $response['message'] = 'Login successful!';
            $response['redirect'] = $demo_user['redirect'];
        } else {
            $response['message'] = 'Invalid credentials. Please check your email and password.';
        }
    } else {
        $response['message'] = 'Invalid user type selected.';
    }
    
    echo json_encode($response);
    exit;
}

// Database query to verify credentials
$table_name = ($user_type === 'admin') ? 'admins' : 'staff';
$stmt = $conn->prepare("SELECT id, email, password, name, status FROM $table_name WHERE email = ? AND status = 'active'");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify password (assuming password is hashed with password_hash())
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_type'] = $user_type;
        $_SESSION['name'] = $user['name'];
        
        // Set remember me cookie if requested
        if ($remember === '1') {
            $token = bin2hex(random_bytes(32));
            setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
            
            // Store token in database (you'll need a remember_tokens table)
            // $stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, user_type, token, expires_at) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL 30 DAY))");
            // $stmt->bind_param("iss", $user['id'], $user_type, $token);
            // $stmt->execute();
        }
        
        // Update last login timestamp
        $update_stmt = $conn->prepare("UPDATE $table_name SET last_login = NOW() WHERE id = ?");
        $update_stmt->bind_param("i", $user['id']);
        $update_stmt->execute();
        
        $response['success'] = true;
        $response['message'] = 'Login successful!';
        $response['redirect'] = ($user_type === 'admin') ? '../frontend/admin_dashboard.php' : '../frontend/staff_dashboard.php';
    } else {
        $response['message'] = 'Invalid credentials. Please check your email and password.';
    }
} else {
    $response['message'] = 'Invalid credentials. Please check your email and password.';
}

// Close database connection
$stmt->close();
$conn->close();

// Return JSON response
echo json_encode($response);
?>

