/**
 * Firebase Configuration for Public Pages (No Auth Required)
 */

const firebaseConfig = {
    apiKey: "AIzaSyBu8FOKjbsy9lD8pl98Dq9y-d-2UCjEQx0",
    authDomain: "protein-planet-9cd02.firebaseapp.com",
    projectId: "protein-planet-9cd02",
    storageBucket: "protein-planet-9cd02.firebasestorage.app",
    messagingSenderId: "622242532283",
    appId: "1:622242532283:web:c4510d72f147c25b36129e",
    measurementId: "G-6V0X1M3RKS"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Initialize Firestore only (no auth for public pages)
const db = firebase.firestore();

// Export for use in other files
window.firebaseDb = db;

console.log('🔥 Firebase initialized for public pages!');

