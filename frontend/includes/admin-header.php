<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7fa;
        min-height: 100vh;
    }
    .header {
        background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
        color: white;
        padding: 15px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .logo {
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
    }
    .nav-links {
        display: flex;
        gap: 20px;
        margin-left: 30px;
    }
    .nav-link {
        color: white;
        text-decoration: none;
        font-size: 14px;
        transition: opacity 0.3s;
    }
    .nav-link:hover { opacity: 0.8; }
    .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .logout-btn {
        background: rgba(255,255,255,0.2);
        border: 2px solid white;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
    }
    .logout-btn:hover {
        background: white;
        color: #FF6B35;
    }
    .notification-bell {
        position: relative;
        cursor: pointer;
        font-size: 24px;
        transition: transform 0.3s;
        margin-right: 15px;
    }
    .notification-bell:hover {
        transform: scale(1.1);
    }
    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ff3b3b;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 20px;
        text-align: center;
        display: none;
    }
    .notification-badge.show {
        display: block;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    .notification-dropdown {
        position: absolute;
        top: 60px;
        right: 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        width: 420px;
        max-height: 500px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
        animation: slideDown 0.3s ease;
    }
    .notification-dropdown.show {
        display: block;
    }
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .notification-dropdown-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .notification-dropdown-header h3 {
        color: #2C3E50;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    .notification-dropdown-count {
        background: #ff3b3b;
        color: white;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 600;
    }
    .notification-dropdown-list {
        max-height: 400px;
        overflow-y: auto;
    }
    .notification-item {
        padding: 15px 20px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.2s;
    }
    .notification-item:hover {
        background: #f8f9fa;
    }
    .notification-item:last-child {
        border-bottom: none;
    }
    .notification-item.expiring {
        border-left: 4px solid #ffc107;
    }
    .notification-item.low-stock {
        border-left: 4px solid #dc3545;
    }
    .notification-item-header {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 5px;
    }
    .notification-item-icon {
        font-size: 24px;
    }
    .notification-item-content {
        flex: 1;
    }
    .notification-item-title {
        font-weight: 600;
        color: #2C3E50;
        font-size: 14px;
        margin-bottom: 3px;
    }
    .notification-item-message {
        color: #7F8C8D;
        font-size: 13px;
        margin-bottom: 5px;
    }
    .notification-item-details {
        font-size: 12px;
        color: #95a5a6;
    }
    .notification-dropdown-empty {
        padding: 40px 20px;
        text-align: center;
        color: #7F8C8D;
    }
    .notification-dropdown-empty-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }
    .notification-dropdown-footer {
        padding: 15px 20px;
        border-top: 1px solid #e0e0e0;
        text-align: center;
    }
    .notification-dropdown-footer a {
        color: #FF6B35;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }
    .notification-dropdown-footer a:hover {
        text-decoration: underline;
    }
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    @media (max-width: 768px) {
        .header { padding: 15px 20px; flex-direction: column; gap: 10px; }
        .nav-links { margin-left: 0; }
        .notification-dropdown {
            right: 10px;
            left: 10px;
            width: auto;
        }
        .notification-item-details {
            font-size: 11px;
        }
    }
</style>

<header class="header">
    <div class="header-left">
        <div class="logo" onclick="window.location.href='admin_dashboard.php'">🏋️ Protein Planet</div>
        <nav class="nav-links">
            <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
            <a href="view-products.php" class="nav-link">Products</a>
            <a href="pos-sale.php" class="nav-link">POS</a>
        </nav>
    </div>
    <div class="user-info">
        <div class="notification-bell" onclick="toggleNotificationDropdown()" id="notificationBell">
            🔔
            <span class="notification-badge" id="notificationBadge">0</span>
        </div>
        <span style="font-size: 14px;">👤 <span id="headerUserName">Admin</span></span>
        <button class="logout-btn" onclick="logoutUser()">Logout</button>
    </div>
</header>

<!-- Notification Dropdown -->
<div class="notification-dropdown" id="notificationDropdown">
    <div class="notification-dropdown-header">
        <h3>🔔 Notifications</h3>
        <span class="notification-dropdown-count" id="dropdownNotificationCount">0</span>
    </div>
    <div class="notification-dropdown-list" id="notificationDropdownList">
        <div class="notification-dropdown-empty">
            <div class="notification-dropdown-empty-icon">🔄</div>
            <p>Loading notifications...</p>
        </div>
    </div>
    <div class="notification-dropdown-footer">
        <a href="admin_dashboard.php">View All on Dashboard</a>
    </div>
</div>

<script>
    // Toggle notification dropdown
    function toggleNotificationDropdown() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('show');
        
        // Load notifications when opening
        if (dropdown.classList.contains('show')) {
            loadNotificationDropdown();
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('notificationDropdown');
        const bell = document.getElementById('notificationBell');
        
        if (dropdown && bell && !dropdown.contains(event.target) && !bell.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Load notifications into dropdown
    async function loadNotificationDropdown() {
        try {
            const productsSnapshot = await firebaseDb.collection('products')
                .where('status', '==', 'active')
                .get();

            const notifications = [];
            const today = new Date();
            const threeMonthsFromNow = new Date();
            threeMonthsFromNow.setDate(today.getDate() + 90);

            // Get brand cache
            const brandCache = {};

            for (const doc of productsSnapshot.docs) {
                const product = doc.data();

                // Get brand name
                if (product.brandId && !brandCache[product.brandId]) {
                    const brandDoc = await firebaseDb.collection('brands').doc(product.brandId).get();
                    brandCache[product.brandId] = brandDoc.exists ? brandDoc.data().name : 'Unknown';
                }

                const brandName = brandCache[product.brandId] || 'Unknown';

                // Check expiring products
                if (product.expiryDate) {
                    let expiryDate;
                    if (typeof product.expiryDate === 'string') {
                        expiryDate = new Date(product.expiryDate + 'T00:00:00');
                    } else if (product.expiryDate.toDate) {
                        expiryDate = product.expiryDate.toDate();
                    } else {
                        expiryDate = new Date(product.expiryDate);
                    }

                    const todayMidnight = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                    const expiryMidnight = new Date(expiryDate.getFullYear(), expiryDate.getMonth(), expiryDate.getDate());
                    const threeMonthsMidnight = new Date(threeMonthsFromNow.getFullYear(), threeMonthsFromNow.getMonth(), threeMonthsFromNow.getDate());
                    const daysUntilExpiry = Math.ceil((expiryMidnight - todayMidnight) / (1000 * 60 * 60 * 24));

                    if (expiryMidnight <= threeMonthsMidnight && expiryMidnight >= todayMidnight) {
                        notifications.push({
                            type: 'expiring',
                            priority: daysUntilExpiry <= 30 ? 'high' : 'medium',
                            title: 'Expiring Soon',
                            message: `${product.name} expires in ${daysUntilExpiry} days`,
                            details: `${brandName} • ${product.availableQuantity || 0} units`,
                            sortOrder: daysUntilExpiry
                        });
                    }
                }

                // Check low stock
                const availableQty = product.availableQuantity || 0;
                if (availableQty <= 10) {
                    notifications.push({
                        type: 'low-stock',
                        priority: availableQty === 0 ? 'critical' : availableQty <= 5 ? 'high' : 'medium',
                        title: availableQty === 0 ? 'Out of Stock!' : 'Low Stock',
                        message: `${product.name} - ${availableQty} units left`,
                        details: `${brandName} • ₹${product.buyingPrice || 0}`,
                        sortOrder: availableQty
                    });
                }
            }

            // Sort notifications
            notifications.sort((a, b) => {
                const priorityOrder = { critical: 0, high: 1, medium: 2 };
                const priorityDiff = priorityOrder[a.priority] - priorityOrder[b.priority];
                if (priorityDiff !== 0) return priorityDiff;
                return a.sortOrder - b.sortOrder;
            });

            // Update counts
            document.getElementById('notificationBadge').textContent = notifications.length;
            document.getElementById('dropdownNotificationCount').textContent = notifications.length;
            
            if (notifications.length > 0) {
                document.getElementById('notificationBadge').classList.add('show');
            } else {
                document.getElementById('notificationBadge').classList.remove('show');
            }

            // Display notifications
            const listContainer = document.getElementById('notificationDropdownList');

            if (notifications.length === 0) {
                listContainer.innerHTML = `
                    <div class="notification-dropdown-empty">
                        <div class="notification-dropdown-empty-icon">✅</div>
                        <p style="font-weight: 600;">All Good!</p>
                        <p style="font-size: 13px; margin-top: 5px;">No urgent notifications</p>
                    </div>
                `;
                return;
            }

            let html = '';
            notifications.slice(0, 10).forEach(notif => {
                const icon = notif.type === 'expiring' ? '⏰' : notif.priority === 'critical' ? '🚨' : '📦';
                html += `
                    <div class="notification-item ${notif.type}" onclick="window.location.href='view-products.php'">
                        <div class="notification-item-header">
                            <span class="notification-item-icon">${icon}</span>
                            <div class="notification-item-content">
                                <div class="notification-item-title">${notif.title}</div>
                                <div class="notification-item-message">${notif.message}</div>
                                <div class="notification-item-details">${notif.details}</div>
                            </div>
                        </div>
                    </div>
                `;
            });

            listContainer.innerHTML = html;

        } catch (error) {
            console.error('Error loading notifications:', error);
            document.getElementById('notificationDropdownList').innerHTML = `
                <div class="notification-dropdown-empty">
                    <div class="notification-dropdown-empty-icon">⚠️</div>
                    <p style="color: #e74c3c;">Error loading notifications</p>
                </div>
            `;
        }
    }

    // Load notifications on page load
    if (typeof firebaseDb !== 'undefined') {
        firebaseAuth.onAuthStateChanged((user) => {
            if (user) {
                loadNotificationDropdown();
            }
        });
    }

    function logoutUser() {
        if (confirm('Are you sure you want to logout?')) {
            firebaseAuth.signOut().then(() => {
                window.location.href = 'login.php';
            });
        }
    }
</script>

