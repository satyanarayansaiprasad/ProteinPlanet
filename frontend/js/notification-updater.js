/**
 * Notification Badge Updater
 * Updates the notification badge count in the header across all admin pages
 */

// Function to update notification badge
async function updateNotificationBadge() {
    try {
        const productsSnapshot = await firebaseDb.collection('products')
            .where('status', '==', 'active')
            .get();

        let notificationCount = 0;
        const today = new Date();
        const threeMonthsFromNow = new Date();
        threeMonthsFromNow.setDate(today.getDate() + 90); // 90 days = 3 months

        productsSnapshot.forEach(doc => {
            const product = doc.data();

            // Check for expiring products (within 90 days)
            if (product.expiryDate) {
                // Parse expiry date (handle both string and timestamp formats)
                let expiryDate;
                if (typeof product.expiryDate === 'string') {
                    // String format (YYYY-MM-DD from date input)
                    expiryDate = new Date(product.expiryDate + 'T00:00:00');
                } else if (product.expiryDate.toDate) {
                    // Firestore Timestamp
                    expiryDate = product.expiryDate.toDate();
                } else {
                    expiryDate = new Date(product.expiryDate);
                }

                // Reset time to midnight for accurate day comparison
                const todayMidnight = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                const expiryMidnight = new Date(expiryDate.getFullYear(), expiryDate.getMonth(), expiryDate.getDate());
                const threeMonthsMidnight = new Date(threeMonthsFromNow.getFullYear(), threeMonthsFromNow.getMonth(), threeMonthsFromNow.getDate());

                if (expiryMidnight <= threeMonthsMidnight && expiryMidnight >= todayMidnight) {
                    notificationCount++;
                }
            }

            // Check for low stock (10 or fewer items)
            const availableQty = product.availableQuantity || 0;
            if (availableQty <= 10) {
                notificationCount++;
            }
        });

        // Update badge
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            badge.textContent = notificationCount;
            if (notificationCount > 0) {
                badge.classList.add('show');
            } else {
                badge.classList.remove('show');
            }
        }

        console.log(`🔔 ${notificationCount} notification${notificationCount !== 1 ? 's' : ''}`);

    } catch (error) {
        console.error('Error updating notification badge:', error);
    }
}

// Update badge when page loads
if (typeof firebaseDb !== 'undefined') {
    firebaseAuth.onAuthStateChanged((user) => {
        if (user) {
            updateNotificationBadge();
        }
    });
} else {
    console.warn('Firebase not initialized yet for notifications');
}

