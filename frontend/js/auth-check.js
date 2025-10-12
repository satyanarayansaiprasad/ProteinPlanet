/**
 * Authentication Check for Admin Pages
 * Include this script on all admin pages
 */

firebaseAuth.onAuthStateChanged(async (user) => {
    if (!user) {
        window.location.href = 'login.php';
        return;
    }

    try {
        const userDoc = await firebaseDb.collection('users').doc(user.uid).get();
        
        if (!userDoc.exists) {
            alert('User data not found.');
            await firebaseAuth.signOut();
            window.location.href = 'login.php';
            return;
        }

        const userData = userDoc.data();

        if (userData.userType !== 'admin') {
            alert('Access denied. Admin access required.');
            await firebaseAuth.signOut();
            window.location.href = 'login.php';
            return;
        }

        // Update header username if element exists
        const headerUserName = document.getElementById('headerUserName');
        if (headerUserName) {
            headerUserName.textContent = userData.name;
        }

    } catch (error) {
        console.error('Auth check error:', error);
        alert('Authentication error. Please login again.');
        window.location.href = 'login.php';
    }
});

