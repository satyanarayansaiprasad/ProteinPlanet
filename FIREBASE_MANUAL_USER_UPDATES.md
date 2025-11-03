# 🔧 Firebase Manual User Updates Guide

This guide explains how to manually update user passwords and emails in Firebase Console when the setup page can't update them directly.

---

## 📋 Why Manual Updates Are Needed

The setup page (`setup-users.html`) can update:
- ✅ **User Name** (in Firestore)
- ✅ **User Type** (admin/staff in Firestore)

But requires manual updates for:
- ⚠️ **Password** (requires Firebase Admin SDK or user authentication)
- ⚠️ **Email in Firebase Auth** (requires Firebase Admin SDK or user re-authentication)

---

## 🔐 How to Update Password in Firebase Console

### Method 1: Password Reset (Recommended)
1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project: **protein-planet-9cd02**
3. Click **Authentication** in the left menu
4. Click **Users** tab
5. Find the user by email address
6. Click the **three dots (⋮)** next to the user
7. Select **Reset password**
8. Firebase will send a password reset email to the user
9. User clicks the link in email and sets new password

### Method 2: Manual Password Reset Link
1. In **Authentication → Users**, find the user
2. Click on the user's email address
3. Click **"Reset password"** button
4. User receives email and can set new password

### Method 3: Delete and Recreate (Only if needed)
⚠️ **Warning:** This will delete all user data. Use only as last resort.

1. In **Authentication → Users**, find the user
2. Click **Delete user**
3. Use `setup-users.html` to create the user again with new password

---

## 📧 How to Update Email in Firebase Console

### Steps:
1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select project: **protein-planet-9cd02**
3. Click **Authentication → Users**
4. Find the user by current email
5. Click on the user's email address to open details
6. Click the **edit (pencil) icon** next to the email field
7. Enter the new email address
8. Click **Save**

### Important Notes:
- ⚠️ **After changing email in Firebase Auth**, you should also update it in Firestore:
  1. Go to **Firestore Database**
  2. Open `users` collection
  3. Find the user document (by UID or email)
  4. Update the `email` field manually
  5. Click **Update**

---

## 🔄 Complete Update Workflow

### To Update Both Password AND Email:

1. **Update Email in Firebase Auth:**
   - Authentication → Users → Find user → Edit email → Save

2. **Update Email in Firestore:**
   - Firestore Database → users collection → Find user → Update email field

3. **Reset Password:**
   - Authentication → Users → Find user → Reset password → User sets new password via email

---

## 🛠️ Alternative: Using Firebase Admin SDK (Server-Side)

For automated password/email updates, you would need:

1. **Node.js backend** with Firebase Admin SDK
2. **Server endpoint** like `/api/update-user`
3. **Service account key** from Firebase Console

This is more complex but allows programmatic updates.

---

## ✅ Quick Checklist for Updates

When updating a user manually:

- [ ] Update **Name** in Firestore (`users` collection)
- [ ] Update **User Type** (admin/staff) in Firestore if changed
- [ ] Update **Email in Firebase Auth** if changed
- [ ] Update **Email in Firestore** to match Firebase Auth email
- [ ] Reset **Password** if needed (via Firebase Console)

---

## 🆘 Troubleshooting

### Problem: Can't find user in Firebase Console
**Solution:** Make sure you're looking in the correct project and check the email spelling

### Problem: Password reset email not received
**Solution:**
- Check spam folder
- Verify email address is correct
- Check Firebase Console → Authentication → Templates for email settings

### Problem: Email updated but login still uses old email
**Solution:** 
- Make sure you updated email in BOTH Firebase Auth AND Firestore
- Clear browser cache and cookies
- Try logging in with new email

### Problem: Permission denied when updating in setup page
**Solution:**
1. Check Firestore rules allow authenticated updates:
   ```javascript
   match /users/{userId} {
     allow update: if isAuthenticated();
   }
   ```
2. Make sure anonymous authentication is enabled in Firebase Console
3. Refresh the setup page and try again

---

## 📚 Related Files

- `setup-users.html` - User setup and management page
- `FIRESTORE_RULES_UPDATE.md` - Firestore security rules
- `FIREBASE_SETUP.md` - Initial Firebase setup guide

---

**Need Help?** Check Firebase documentation: https://firebase.google.com/docs/auth/admin/manage-users

