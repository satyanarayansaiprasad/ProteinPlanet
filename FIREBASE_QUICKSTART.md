# 🔥 Firebase Quick Start - 3 Steps!

## Step 1: Enable Firestore (2 minutes)

1. Go to: https://console.firebase.google.com/
2. Select project: **protein-planet-9cd02**
3. Click **"Firestore Database"** → **"Create database"**
4. Choose **"Start in production mode"**
5. Select location: **us-central1**
6. Click **"Enable"**

## Step 2: Set Firestore Rules (1 minute)

1. Click **"Rules"** tab
2. Paste this code:

```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /users/{userId} {
      allow read: if request.auth != null;
      allow write: if false;
    }
  }
}
```

3. Click **"Publish"**

## Step 3: Create Users (2 minutes)

1. Open: http://localhost:8000/../setup-users.html

2. **Create Admin:**
   - Name: Admin User
   - Email: admin@proteinplanet.com
   - Password: admin123
   - Type: Admin
   - Click "Create User"

3. **Create Staff:**
   - Name: Staff User
   - Email: staff@proteinplanet.com
   - Password: staff123
   - Type: Staff
   - Click "Create User"

4. **Delete setup-users.html file** (security!)

---

## ✅ Done! Now Login:

1. Go to: http://localhost:8000/login.php
2. Click Admin or Staff
3. Enter email and password
4. Enjoy! 🎉

---

**Total time: 5 minutes** ⏱️

See **FIREBASE_SETUP.md** for detailed documentation.

