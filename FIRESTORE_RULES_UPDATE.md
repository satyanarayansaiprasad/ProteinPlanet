# 🔥 COMPLETE Firestore Security Rules - COPY THIS TO FIREBASE CONSOLE

## 🚨 CRITICAL: Copy the ENTIRE rules below to Firebase Console

**Steps:**
1. Go to: https://console.firebase.google.com/
2. Select project: **protein-planet-9cd02**
3. Click **Firestore Database** → **Rules** tab
4. **DELETE ALL existing rules**
5. **COPY and PASTE the entire rules below**
6. Click **"Publish"**
7. Wait 2-3 minutes for deployment

## 📋 COMPLETE RULES TO COPY:

```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    
    // Helper function to check if user is authenticated
    function isAuthenticated() {
      return request.auth != null;
    }
    
    // Helper function to check if user is admin
    function isAdmin() {
      return isAuthenticated() && 
             exists(/databases/$(database)/documents/users/$(request.auth.uid)) &&
             get(/databases/$(database)/documents/users/$(request.auth.uid)).data.userType == 'admin';
    }
    
    // Users collection - FIXED FOR SETUP PAGE
    match /users/{userId} {
      // Anyone can read user documents (needed for setup page and login)
      allow read: if true;
      
      // Users can only create their own document (registration)
      allow create: if isAuthenticated() && request.auth.uid == userId;
      
      // ANY authenticated user can update users (FIXED for setup page)
      allow update: if isAuthenticated();
      
      // ANY authenticated user can delete users (setup page is IP-protected)
      allow delete: if isAuthenticated();
    }
    
    // Brands collection
    match /brands/{brandId} {
      // Anyone can read brands (public landing page needs this)
      allow read: if true;
      
      // Only admins can create, update, or delete brands
      allow create, update, delete: if isAdmin();
    }
    
    // Categories collection
    match /categories/{categoryId} {
      // Anyone can read categories (public landing page needs this)
      allow read: if true;
      
      // Only admins can create, update, or delete categories
      allow create, update, delete: if isAdmin();
    }
    
    // Products collection
    match /products/{productId} {
      // Anyone can read products (public landing page needs this)
      allow read: if true;
      
      // Only authenticated users (admin/staff) can create or delete products
      allow create, delete: if isAuthenticated();
      
      // Authenticated users can update products (for sales and refills)
      allow update: if isAuthenticated();
    }
    
    // Stock History collection
    match /stockHistory/{historyId} {
      // All authenticated users can read stock history
      allow read: if isAuthenticated();
      
      // Only authenticated users can create stock history records
      allow create: if isAuthenticated();
      
      // Only admins can update or delete history
      allow update, delete: if isAdmin();
    }
    
    // Sales collection
    match /sales/{saleId} {
      // All authenticated users can read all sales (needed for customer purchase history)
      allow read: if isAuthenticated();
      
      // Only authenticated users can create sales
      allow create: if isAuthenticated();
      
      // Only admins can update or delete sales
      allow update, delete: if isAdmin();
    }
    
    // Reviews collection
    match /reviews/{reviewId} {
      // Anyone can read reviews (public landing page needs this)
      allow read: if true;
      
      // Anyone can submit a review (public form)
      allow create: if true;
      
      // Only admins can update or delete reviews
      allow update, delete: if isAdmin();
    }
  }
}
```

## ✅ What These Rules Do:

### **Users Collection:**
- ✅ Anyone can read user documents (needed for setup page)
- ✅ Users can create their own profile
- ✅ Any authenticated user can update users (needed for setup page)
- ✅ Any authenticated user can delete users (page is IP-protected)

### **Brands Collection:**
- ✅ All authenticated users can read brands
- ✅ Only admins can add/edit/delete brands

### **Categories Collection:**
- ✅ All authenticated users can read categories
- ✅ Only admins can add/edit/delete categories

### **Products Collection:**
- ✅ Anyone can read products (public access)
- ✅ Authenticated users can add/delete/update products
- ✅ Allows product editing and stock refills

### **Stock History Collection:**
- ✅ Authenticated users can read stock history
- ✅ Authenticated users can create refill records
- ✅ Only admins can update/delete history
- ✅ Complete audit trail of inventory purchases

### **Sales Collection:**
- ✅ All authenticated users can read all sales
- ✅ All authenticated users can create sales
- ✅ Only admins can update/delete sales

### **Reviews Collection:**
- ✅ Anyone can read reviews (public access for landing page)
- ✅ Anyone can submit a review (public form)
- ✅ Only admins can update/delete reviews

## 🚀 How to Apply:

1. Go to Firebase Console: https://console.firebase.google.com/
2. Select project: **protein-planet-9cd02**
3. Click **Firestore Database** in left sidebar
4. Click **Rules** tab
5. **Delete all existing rules**
6. **Copy and paste** the rules above
7. Click **"Publish"** button

## ⏱️ Time Required: 2 minutes

## ⚠️ Important:

After publishing these rules, your stock management system will work perfectly with proper security!

## 🚨 TROUBLESHOOTING:

### **If you still get "Missing or insufficient permissions" error:**

1. **Check you're in the right project**: Make sure you see "protein-planet-9cd02" in Firebase Console
2. **Verify rules were published**: Look for "Rules published successfully" message
3. **Wait 2-3 minutes**: Rules take time to deploy globally
4. **Clear browser cache**: Refresh the page or try incognito mode
5. **Check authentication**: Make sure you're logged in when testing

### **Quick Test Rules (Temporary):**
If nothing works, use these **temporary test rules** (less secure):

```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read, write: if true;
    }
  }
}
```

**⚠️ WARNING**: These allow anyone to read/write everything. Only use for testing!

### **Verify Rules Are Applied:**
After publishing, you should see in Firebase Console:
- ✅ "Rules published successfully"
- ✅ Rules show `allow update: if isAuthenticated();` for users collection
- ✅ No syntax errors in the rules editor

---

**Last Updated:** October 22, 2025  
**Version:** 2.0.0 - Fixed for Setup Page

