# Firebase Storage Setup Guide

## Issue: CORS Error When Uploading Images

If you see CORS errors like:
```
Access to XMLHttpRequest at 'https://firebasestorage.googleapis.com/...' has been blocked by CORS policy
```

## Solution: Configure Firebase Storage

### Option 1: Enable Firebase Storage (Recommended - Easy)

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project: **protein-planet-9cd02**
3. Click **Storage** in left sidebar
4. Click **Get Started** if not already enabled
5. Choose **Start in production mode** or **Test mode**
6. Click **Done**

### Option 2: Update Storage Rules (If Already Enabled)

1. Go to Firebase Console → Storage → Rules
2. Replace with these rules:

```javascript
rules_version = '2';
service firebase.storage {
  match /b/{bucket}/o {
    // Allow authenticated users to upload product images
    match /products/{imageId} {
      allow read: if true;  // Public read access
      allow write: if request.auth != null;  // Only authenticated users can upload
    }
    
    // Default: deny all other access
    match /{allPaths=**} {
      allow read, write: if false;
    }
  }
}
```

3. Click **Publish**

### Option 3: Configure CORS (Advanced - If issues persist)

If you still see CORS errors, you may need to configure CORS for Firebase Storage:

1. Install Google Cloud SDK
2. Create a `cors.json` file:

```json
[
  {
    "origin": ["https://proteinplanet.onrender.com", "http://localhost:8000"],
    "method": ["GET", "POST", "PUT", "DELETE"],
    "maxAgeSeconds": 3600
  }
]
```

3. Run this command:
```bash
gsutil cors set cors.json gs://protein-planet-9cd02.firebasestorage.app
```

## Verification

After setup:
1. Try uploading a product image
2. You should see:
   - "📤 Uploading image..."
   - "💾 Saving product..."
   - "✅ Product added to inventory successfully!"
3. Check the product displays with the image on all-products page

## Fallback Behavior

If image upload fails:
- Product is still added to inventory
- No image URL is stored
- Product displays with default gradient + icon
- Error message shown but doesn't block product creation

## Image Specifications

- **Formats Supported**: JPG, PNG, WebP, GIF
- **Maximum Size**: 2MB
- **Recommended Size**: 500x500px
- **Storage Location**: `products/timestamp_filename.ext`

## Testing

1. Add a product without image → Should work
2. Add a product with image → Should upload and display
3. View products on all-products page → Should show images or fallback icon
4. Check admin view-products → Should show thumbnails

---

**Note**: Firebase Storage is a separate service from Firestore. Make sure it's enabled in your Firebase project.

