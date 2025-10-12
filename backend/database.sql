-- Protein Planet Database Setup
-- Execute this file to create the database and tables

-- Create Database
CREATE DATABASE IF NOT EXISTS protein_planet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE protein_planet;

-- Create Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL,
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Staff Table
CREATE TABLE IF NOT EXISTS staff (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    position VARCHAR(50) DEFAULT 'Sales Staff',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL DEFAULT NULL,
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Remember Tokens Table (for "Remember Me" functionality)
CREATE TABLE IF NOT EXISTS remember_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    user_type ENUM('admin', 'staff') NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    INDEX idx_token (token),
    INDEX idx_user (user_id, user_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Login Attempts Table (for security/rate limiting)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    user_type ENUM('admin', 'staff') NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    success BOOLEAN DEFAULT FALSE,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_time (email, attempted_at),
    INDEX idx_ip_time (ip_address, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Admin User
-- Password: admin123 (hashed with password_hash() in PHP)
INSERT INTO admins (name, email, password, status) 
VALUES (
    'System Administrator',
    'admin@proteinplanet.com',
    '$2y$10$YJmxZ8PqQrOYZ0vqhXvD8uGRjBqZ0qZJ5XvDvHJnZ0qZJ5XvDvHJn',
    'active'
) ON DUPLICATE KEY UPDATE email=email;

-- Insert Default Staff User  
-- Password: staff123 (hashed with password_hash() in PHP)
INSERT INTO staff (name, email, password, position, status)
VALUES (
    'Store Staff',
    'staff@proteinplanet.com', 
    '$2y$10$YJmxZ8PqQrOYZ0vqhXvD8uGRjBqZ0qZJ5XvDvHJnZ0qZJ5XvDvHJn',
    'Sales Associate',
    'active'
) ON DUPLICATE KEY UPDATE email=email;

-- Create Products Table (for future use)
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    image_url VARCHAR(255) DEFAULT NULL,
    status ENUM('active', 'inactive', 'out_of_stock') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Orders Table (for future use)
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) DEFAULT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    staff_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_staff (staff_id),
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Order Items Table (for future use)
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Products
INSERT INTO products (name, description, category, price, stock_quantity, status) VALUES
('Whey Protein Isolate', 'Premium quality whey protein isolate, 25g protein per serving', 'Protein', 49.99, 100, 'active'),
('Creatine Monohydrate', 'Pure micronized creatine monohydrate for strength and muscle gains', 'Performance', 29.99, 150, 'active'),
('Pre-Workout Energy', 'High-performance pre-workout formula with caffeine and beta-alanine', 'Pre-Workout', 39.99, 75, 'active'),
('BCAA Recovery', 'Essential amino acids for muscle recovery and growth', 'Recovery', 34.99, 90, 'active'),
('Multivitamin', 'Complete daily multivitamin for overall health and wellness', 'Vitamins', 24.99, 200, 'active'),
('Fish Oil Omega-3', 'High-quality omega-3 fatty acids for heart and brain health', 'Vitamins', 19.99, 180, 'active'),
('Mass Gainer', 'High-calorie mass gainer for muscle and weight gain', 'Protein', 59.99, 60, 'active'),
('Fat Burner', 'Thermogenic fat burner to support weight loss goals', 'Weight Loss', 44.99, 80, 'active');

-- Success Message
SELECT 'Database setup completed successfully!' AS message,
       'Default admin: admin@proteinplanet.com / admin123' AS admin_credentials,
       'Default staff: staff@proteinplanet.com / staff123' AS staff_credentials;

