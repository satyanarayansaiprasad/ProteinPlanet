# 🚀 Quick Start Guide - Protein Planet

Get your Protein Planet login system up and running in 2 minutes!

## Step 1: Start the Server

Open Terminal and navigate to your project folder:

```bash
cd "/Users/satyanarayansaiprasad/Desktop/Developments/UnDevPro/Protein Planet"
php -S localhost:8000 -t frontend
```

## Step 2: Open in Browser

Open your web browser and go to:
```
http://localhost:8000/login.php
```

## Step 3: Login with Demo Credentials

### 👨‍💼 Admin Login
- **Email**: admin@proteinplanet.com
- **Password**: admin123

### 👤 Staff Login  
- **Email**: staff@proteinplanet.com
- **Password**: staff123

---

## 📱 Test Responsive Design

The login page is fully responsive! Try these:

1. **Desktop View**: Use your browser normally (1200px+)
2. **Tablet View**: Resize browser to ~768px width
3. **Mobile View**: Resize browser to ~375px width

Or use browser DevTools (F12) to test different device sizes.

---

## 🎨 Features You'll See

✅ Beautiful gradient background  
✅ Animated transitions  
✅ Admin/Staff toggle buttons  
✅ Password show/hide toggle  
✅ Form validation  
✅ Loading states  
✅ Error/success messages  
✅ Remember me functionality  

---

## ⚡ Next Steps

1. **Create Dashboard Pages**
   - `frontend/admin_dashboard.php` for admins
   - `frontend/staff_dashboard.php` for staff

2. **Setup Database** (Optional)
   - See full `README.md` for database setup instructions
   - Or continue using demo mode for development

3. **Customize**
   - Change colors in `frontend/css/login.css`
   - Update logo in `frontend/login.php`
   - Modify branding text

---

## 🆘 Troubleshooting

**Problem**: "Address already in use" error  
**Solution**: Try a different port:
```bash
php -S localhost:8080 -t frontend
```
Then visit: `http://localhost:8080/login.php`

**Problem**: Page not loading  
**Solution**: Make sure you're in the correct directory and PHP is installed:
```bash
php --version
```

**Problem**: Styles not loading  
**Solution**: Check that you're accessing the page through the PHP server (localhost:8000), not by opening the file directly.

---

## 📞 Need Help?

Check the full `README.md` for detailed documentation!

**Happy Coding! 💪🏋️‍♂️**

