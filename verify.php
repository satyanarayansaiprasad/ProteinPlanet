<?php
/**
 * Protein Planet - System Verification Script
 * Run this file to check if your setup is correct
 * Access: http://localhost:8000/verify.php
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Planet - System Verification</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }
        h1 {
            color: #2C3E50;
            margin-bottom: 10px;
            font-size: 32px;
        }
        .subtitle {
            color: #7F8C8D;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #ddd;
            background: #f8f9fa;
        }
        .check-item.success {
            border-left-color: #27AE60;
            background: #e8f8f0;
        }
        .check-item.error {
            border-left-color: #E74C3C;
            background: #fee;
        }
        .check-item.warning {
            border-left-color: #FFB627;
            background: #fff8e1;
        }
        .check-title {
            font-weight: 600;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .check-message {
            font-size: 14px;
            color: #555;
        }
        .icon {
            font-size: 20px;
        }
        .section {
            margin: 30px 0;
        }
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }
        .summary {
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
        }
        .summary h2 {
            margin-bottom: 10px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: white;
            color: #FF6B35;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 5px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        code {
            background: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 System Verification</h1>
        <p class="subtitle">Checking if your Protein Planet installation is configured correctly...</p>

        <?php
        $errors = 0;
        $warnings = 0;
        $success = 0;

        // Check PHP Version
        echo '<div class="section">';
        echo '<h3 class="section-title">PHP Environment</h3>';
        
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '7.4.0', '>=')) {
            echo '<div class="check-item success">';
            echo '<div class="check-title"><span class="icon">✅</span> PHP Version</div>';
            echo "<div class=\"check-message\">PHP $phpVersion is installed (Required: 7.4+)</div>";
            echo '</div>';
            $success++;
        } else {
            echo '<div class="check-item error">';
            echo '<div class="check-title"><span class="icon">❌</span> PHP Version</div>';
            echo "<div class=\"check-message\">PHP $phpVersion is too old. Please upgrade to PHP 7.4 or higher.</div>";
            echo '</div>';
            $errors++;
        }

        // Check required PHP extensions
        $required_extensions = ['mysqli', 'json', 'session'];
        foreach ($required_extensions as $ext) {
            if (extension_loaded($ext)) {
                echo '<div class="check-item success">';
                echo "<div class=\"check-title\"><span class=\"icon\">✅</span> PHP Extension: $ext</div>";
                echo '<div class="check-message">Extension is loaded and available</div>';
                echo '</div>';
                $success++;
            } else {
                echo '<div class="check-item error">';
                echo "<div class=\"check-title\"><span class=\"icon\">❌</span> PHP Extension: $ext</div>";
                echo '<div class="check-message">Extension is not loaded. Please enable it in php.ini</div>';
                echo '</div>';
                $errors++;
            }
        }

        // Check File Structure
        echo '</div><div class="section">';
        echo '<h3 class="section-title">File Structure</h3>';

        $required_files = [
            'frontend/login.php' => 'Login page',
            'frontend/css/login.css' => 'Login styles',
            'frontend/js/login.js' => 'Login scripts',
            'backend/login.php' => 'Login handler',
            'backend/config.php' => 'Configuration file',
        ];

        foreach ($required_files as $file => $description) {
            if (file_exists($file)) {
                echo '<div class="check-item success">';
                echo "<div class=\"check-title\"><span class=\"icon\">✅</span> $description</div>";
                echo "<div class=\"check-message\">Found: <code>$file</code></div>";
                echo '</div>';
                $success++;
            } else {
                echo '<div class="check-item error">';
                echo "<div class=\"check-title\"><span class=\"icon\">❌</span> $description</div>";
                echo "<div class=\"check-message\">Missing: <code>$file</code></div>";
                echo '</div>';
                $errors++;
            }
        }

        // Check File Permissions
        echo '</div><div class="section">';
        echo '<h3 class="section-title">File Permissions</h3>';

        $writable_dirs = [
            '../backend' => 'Backend directory (for logs)',
        ];

        foreach ($writable_dirs as $dir => $description) {
            if (is_writable($dir)) {
                echo '<div class="check-item success">';
                echo "<div class=\"check-title\"><span class=\"icon\">✅</span> $description</div>";
                echo "<div class=\"check-message\">Directory is writable: <code>$dir</code></div>";
                echo '</div>';
                $success++;
            } else {
                echo '<div class="check-item warning">';
                echo "<div class=\"check-title\"><span class=\"icon\">⚠️</span> $description</div>";
                echo "<div class=\"check-message\">Directory may not be writable: <code>$dir</code> (This is OK if you don't need file uploads/logs)</div>";
                echo '</div>';
                $warnings++;
            }
        }

        // Check Database Connection
        echo '</div><div class="section">';
        echo '<h3 class="section-title">Database Connection</h3>';

        include_once 'backend/config.php';
        
        $db_conn = @getDatabaseConnection();
        if ($db_conn !== null) {
            echo '<div class="check-item success">';
            echo '<div class="check-title"><span class="icon">✅</span> Database Connection</div>';
            echo '<div class="check-message">Successfully connected to database</div>';
            echo '</div>';
            $success++;
            $db_conn->close();
        } else {
            echo '<div class="check-item warning">';
            echo '<div class="check-title"><span class="icon">⚠️</span> Database Connection</div>';
            echo '<div class="check-message">Could not connect to database. Demo mode will be used. To use a real database, update credentials in <code>backend/config.php</code> and import <code>backend/database.sql</code></div>';
            echo '</div>';
            $warnings++;
        }

        // Check Session
        echo '</div><div class="section">';
        echo '<h3 class="section-title">Session Support</h3>';

        if (session_start()) {
            echo '<div class="check-item success">';
            echo '<div class="check-title"><span class="icon">✅</span> PHP Sessions</div>';
            echo '<div class="check-message">Sessions are working correctly</div>';
            echo '</div>';
            $success++;
        } else {
            echo '<div class="check-item error">';
            echo '<div class="check-title"><span class="icon">❌</span> PHP Sessions</div>';
            echo '<div class="check-message">Sessions are not working. Check your PHP configuration.</div>';
            echo '</div>';
            $errors++;
        }

        echo '</div>';

        // Summary
        $total = $success + $warnings + $errors;
        ?>

        <div class="summary">
            <h2>📊 Verification Summary</h2>
            <p style="font-size: 18px; margin: 15px 0;">
                <strong>✅ Success:</strong> <?php echo $success; ?> | 
                <strong>⚠️ Warnings:</strong> <?php echo $warnings; ?> | 
                <strong>❌ Errors:</strong> <?php echo $errors; ?>
            </p>
            
            <?php if ($errors === 0): ?>
                <p style="font-size: 16px; margin-top: 20px;">
                    🎉 <strong>All critical checks passed!</strong> Your system is ready to use.
                </p>
                <div style="margin-top: 20px;">
                    <a href="frontend/login.php" class="btn">Go to Login Page →</a>
                    <a href="README.md" class="btn">Read Documentation</a>
                </div>
            <?php else: ?>
                <p style="font-size: 16px; margin-top: 20px;">
                    ⚠️ <strong>Please fix the errors above before using the system.</strong>
                </p>
                <div style="margin-top: 20px;">
                    <a href="verify.php" class="btn">Run Verification Again</a>
                    <a href="README.md" class="btn">Read Documentation</a>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; font-size: 14px; color: #555;">
            <h3 style="margin-bottom: 10px; color: #2C3E50;">📚 Demo Credentials</h3>
            <p><strong>Admin:</strong> admin@proteinplanet.com / admin123</p>
            <p><strong>Staff:</strong> staff@proteinplanet.com / staff123</p>
            <p style="margin-top: 10px; font-size: 13px; color: #888;">
                These credentials work without a database connection (demo mode).
            </p>
        </div>
    </div>
</body>
</html>

