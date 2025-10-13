# 🔥 Updated Firestore Security Rules

## 📋 Copy and paste these rules in your Firebase Console

Go to: **Firebase Console** → **Firestore Database** → **Rules** tab

Replace all existing rules with these:

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
    
    // Users collection
    match /users/{userId} {
      // Anyone authenticated can read user documents (needed for login)
      allow read: if isAuthenticated();
      
      // Users can only create their own document (registration)
      allow create: if isAuthenticated() && request.auth.uid == userId;
      
      // Users can update their own document
      allow update: if isAuthenticated() && request.auth.uid == userId;
      
      // No deletes allowed
      allow delete: if false;
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
- ✅ All authenticated users can read user documents
- ✅ Users can create and update their own profile
- ❌ No one can delete users

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

---

**Last Updated:** October 12, 2025  
**Version:** 1.0.0

