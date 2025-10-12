# Protein Planet - Supplement Store Management System

A modern, responsive web application for managing a supplement store with separate admin and staff login portals.

## 🚀 Features

- **Responsive Design**: Works seamlessly on all devices (desktop, tablet, mobile)
- **Dual Login System**: Separate login portals for Admin and Staff
- **Modern UI**: Beautiful gradient designs with smooth animations
- **Secure**: PHP session management and password hashing support
- **Easy to Customize**: Clean, well-organized code structure

## 📁 Project Structure

```
Protein Planet/
├── frontend/
│   ├── login.php           # Login page
│   ├── index.php           # Entry point
│   ├── css/
│   │   └── login.css       # Login page styles
│   └── js/
│       └── login.js        # Login page interactions
└── backend/
    ├── login.php           # Login authentication handler
    └── config.php          # Database and app configuration
```

## 🛠️ Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher (optional for demo)
- Web server (Apache/Nginx) or PHP built-in server

### Installation

1. **Clone or Download the Project**
   ```bash
   cd "Protein Planet"
   ```

2. **Start PHP Development Server**
   ```bash
   php -S localhost:8000 -t frontend
   ```

3. **Access the Application**
   Open your browser and navigate to:
   ```
   http://localhost:8000/login.php
   ```

### Demo Credentials

For testing without a database, use these demo credentials:

**Admin Login:**
- Email: `admin@proteinplanet.com`
- Password: `admin123`

**Staff Login:**
- Email: `staff@proteinplanet.com`
- Password: `staff123`

## 🗄️ Database Setup (Optional)

If you want to use a real database instead of demo credentials:

1. **Create Database**
   ```sql
   CREATE DATABASE protein_planet;
   ```

2. **Create Admin Table**
   ```sql
   CREATE TABLE admins (
       id INT PRIMARY KEY AUTO_INCREMENT,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL,
       status ENUM('active', 'inactive') DEFAULT 'active',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       last_login TIMESTAMP NULL
   );
   ```

3. **Create Staff Table**
   ```sql
   CREATE TABLE staff (
       id INT PRIMARY KEY AUTO_INCREMENT,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) UNIQUE NOT NULL,
       password VARCHAR(255) NOT NULL,
       status ENUM('active', 'inactive') DEFAULT 'active',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       last_login TIMESTAMP NULL
   );
   ```

4. **Insert Sample Admin**
   ```sql
   INSERT INTO admins (name, email, password) 
   VALUES ('Admin User', 'admin@proteinplanet.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
   -- Password: password
   ```

5. **Insert Sample Staff**
   ```sql
   INSERT INTO staff (name, email, password) 
   VALUES ('Staff User', 'staff@proteinplanet.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
   -- Password: password
   ```

6. **Update Config File**
   Edit `backend/config.php` and update database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'protein_planet');
   ```

## 🎨 Customization

### Color Scheme
The application uses CSS variables for easy customization. Edit `frontend/css/login.css`:

```css
:root {
    --primary-color: #FF6B35;      /* Main brand color */
    --secondary-color: #004E89;    /* Secondary brand color */
    --accent-color: #FFB627;       /* Accent color */
}
```

### Logo
Replace the SVG logo in `frontend/login.php` at line 20-25 with your own logo.

## 📱 Responsive Breakpoints

- Desktop: 968px and above
- Tablet: 577px - 968px
- Mobile: 576px and below

## 🔒 Security Features

- Password hashing with `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection with input sanitization
- Session management
- CSRF protection (can be added)

## 📝 Next Steps

1. Create dashboard pages (`admin_dashboard.php` and `staff_dashboard.php`)
2. Implement logout functionality
3. Add password reset feature
4. Create user management system
5. Build inventory management features
6. Add order processing system
7. Implement reporting and analytics

## 🤝 Support

For issues or questions, contact: support@proteinplanet.com

## 📄 License

This project is open source and available for personal and commercial use.

---

**Built with ❤️ for Protein Planet**

