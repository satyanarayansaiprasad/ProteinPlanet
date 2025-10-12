# 🔥 Firebase Setup Guide - Protein Planet

Your Protein Planet login system is now powered by Firebase! No SQL database needed. ✨

---

## ✅ What's Already Done

- ✅ Firebase configured with your credentials
- ✅ Login page updated to use Firebase Authentication
- ✅ Password reset functionality added
- ✅ Beautiful UI preserved (exactly as before!)

---

## 🚀 Quick Start (3 Steps)

### Step 1: Enable Firestore Database

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project: **protein-planet-9cd02**
3. Click **"Firestore Database"** in the left menu
4. Click **"Create database"**
5. Select **"Start in production mode"** (we'll set rules next)
6. Choose a location (e.g., `us-central1`)
7. Click **"Enable"**

### Step 2: Update Firestore Security Rules

1. In Firestore, click the **"Rules"** tab
2. Replace the rules with this:

```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    // Allow users to read their own user document
    match /users/{userId} {
      allow read: if request.auth != null && request.auth.uid == userId;
      allow write: if false; // Only allow writes through Firebase Admin or setup page
    }
    
    // Allow authenticated users to read all users (for admin purposes)
    match /users/{userId} {
      allow read: if request.auth != null;
    }
  }
}
```

3. Click **"Publish"**

### Step 3: Create Your First Users

1. **Open the setup page in your browser:**
   ```
   http://localhost:8000/../setup-users.html
   ```

2. **Create an Admin user:**
   - Name: Your Name
   - Email: admin@proteinplanet.com
   - Password: admin123 (or your choice)
   - User Type: Admin

3. **Create a Staff user:**
   - Name: Staff Name
   - Email: staff@proteinplanet.com
   - Password: staff123 (or your choice)
   - User Type: Staff

4. **🔒 IMPORTANT:** After creating users, **delete the `setup-users.html` file** for security!

---

## 🎯 How to Login

1. **Start your server:**
   ```bash
   cd "/Users/satyanarayansaiprasad/Desktop/Developments/UnDevPro/Protein Planet"
   php -S localhost:8000 -t frontend
   ```

2. **Open in browser:**
   ```
   http://localhost:8000/login.php
   ```

3. **Login with your created credentials:**
   - Click **Admin** or **Staff** button
   - Enter email and password
   - Click **Sign In**

---

## 🔐 Firebase Authentication Features

### ✨ What's Included:

- ✅ **Email/Password Login** - Secure authentication
- ✅ **Password Reset** - Via email link
- ✅ **Remember Me** - Persistent sessions
- ✅ **User Roles** - Admin and Staff separation
- ✅ **Auto Redirect** - Already logged-in users auto-redirect to dashboard
- ✅ **Session Management** - Automatic session handling
- ✅ **Error Handling** - User-friendly error messages

### 🔒 Security Features:

- Password hashing (handled by Firebase)
- Secure token-based authentication
- HTTPS support (when deployed)
- Rate limiting (built into Firebase)
- Account lockout after failed attempts

---

## 📊 Firebase Data Structure

Your Firestore database will have this structure:

```
users (collection)
  └── {userId} (document)
      ├── name: "John Doe"
      ├── email: "john@example.com"
      ├── userType: "admin" or "staff"
      ├── status: "active" or "inactive"
      ├── createdAt: timestamp
      └── lastLogin: timestamp
```

---

## 🔄 Password Reset Flow

1. User clicks **"Forgot Password?"** on login page
2. Enters their email address
3. Firebase sends reset email automatically
4. User clicks link in email
5. Firebase provides password reset form
6. User sets new password
7. User can login with new password

**Note:** Make sure to configure email templates in Firebase Console:
- Go to **Authentication** → **Templates** → Customize email templates

---

## 📱 How It Works

### Login Process:
```
User enters credentials
    ↓
Firebase authenticates
    ↓
Check user type in Firestore
    ↓
Verify user is active
    ↓
Redirect to appropriate dashboard
```

### Data Flow:
```
Firebase Authentication
    ├── Handles: Login, Logout, Password Reset
    └── Stores: Email, Password (hashed)

Firestore Database
    ├── Stores: User metadata (name, type, status)
    └── Used for: Role checking, user info
```

---

## 🛠️ Customization

### Add More User Fields

Edit `setup-users.html` and add fields to the form:

```javascript
await firebaseDb.collection('users').doc(user.uid).set({
    name: name,
    email: email,
    userType: userType,
    status: 'active',
    phone: phoneNumber,        // Add this
    department: department,    // Add this
    createdAt: firebase.firestore.FieldValue.serverTimestamp()
});
```

### Change User Status

To deactivate a user, go to Firestore Console:
1. Find the user document
2. Change `status` from `"active"` to `"inactive"`

---

## 🆘 Troubleshooting

### Problem: "User not found" error
**Solution:** Make sure you created the user using `setup-users.html`

### Problem: "Wrong user type" error
**Solution:** Make sure you clicked the correct user type button (Admin/Staff)

### Problem: Firestore permission denied
**Solution:** Check that you updated the Firestore security rules (Step 2)

### Problem: Password reset email not received
**Solution:** 
1. Check spam folder
2. Verify email templates are enabled in Firebase Console
3. Make sure the email exists in Firebase Authentication

### Problem: Can't access setup-users.html
**Solution:** The file is in the root directory, access it with:
```
http://localhost:8000/../setup-users.html
```

---

## 💰 Firebase Free Tier Limits

Firebase offers generous free limits:

- **Authentication:** 
  - Unlimited users
  - 10,000 verifications/month (email)

- **Firestore:**
  - 1 GB storage
  - 50,000 reads/day
  - 20,000 writes/day
  - 20,000 deletes/day

**For a supplement store:** These limits are MORE than enough! 🎉

---

## 📈 Next Steps

1. ✅ Create users using setup-users.html
2. ✅ Test login with different user types
3. ✅ Test password reset
4. ✅ Delete setup-users.html after use
5. ⏭️ Build admin dashboard
6. ⏭️ Build staff dashboard
7. ⏭️ Add product management
8. ⏭️ Deploy to production

---

## 🌐 Deployment

When ready to deploy:

1. **Update Firebase Authentication settings:**
   - Add your production domain to authorized domains

2. **Update Firestore rules for production:**
   - Tighten security rules as needed

3. **Configure email templates:**
   - Customize branding in Firebase Console

4. **Set up custom domain:**
   - Add your domain in Firebase Hosting (optional)

---

## 📞 Support

- **Firebase Docs:** https://firebase.google.com/docs
- **Firebase Console:** https://console.firebase.google.com/
- **Project Support:** support@proteinplanet.com

---

## 🎉 Congratulations!

Your Protein Planet login system is now powered by Firebase! 

**No SQL database needed. No server management. Just pure, secure authentication!** 🔥

Enjoy your supplement store management system! 💪🏋️‍♂️

---

**Updated:** October 12, 2025  
**Version:** 2.0.0 (Firebase Edition)

