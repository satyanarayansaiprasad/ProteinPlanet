<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            padding: 20px 40px;
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
            font-size: 24px;
            font-weight: 700;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-name {
            font-weight: 500;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: white;
            color: #FF6B35;
        }

        /* Main Content */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .welcome-section {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .welcome-section h1 {
            color: #2C3E50;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #7F8C8D;
            font-size: 16px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .stat-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7F8C8D;
            font-size: 14px;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .quick-actions h2 {
            color: #2C3E50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            padding: 20px;
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: left;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .action-btn-icon {
            font-size: 24px;
            display: block;
            margin-bottom: 10px;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .recent-activity h2 {
            color: #2C3E50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .activity-item {
            padding: 15px;
            border-left: 4px solid #FF6B35;
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .activity-time {
            color: #7F8C8D;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .activity-text {
            color: #2C3E50;
            font-weight: 500;
        }

        /* Loading State */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-size: 20px;
            color: #7F8C8D;
        }

        /* Notifications Section */
        .notifications-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .notifications-header h2 {
            color: #2C3E50;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-count {
            background: #ff3b3b;
            color: white;
            font-size: 14px;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .notifications-grid {
            display: grid;
            gap: 15px;
        }

        .notification-card {
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .notification-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .notification-card.expiring {
            background: #fff3cd;
            border-color: #ffc107;
        }

        .notification-card.low-stock {
            background: #f8d7da;
            border-color: #dc3545;
        }

        .notification-icon {
            font-size: 32px;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            font-size: 16px;
            color: #2C3E50;
            margin-bottom: 5px;
        }

        .notification-message {
            color: #7F8C8D;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .notification-details {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #495057;
        }

        .notification-detail-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .no-notifications {
            text-align: center;
            padding: 40px;
            color: #7F8C8D;
        }

        .no-notifications-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-grid {
                grid-template-columns: 1fr;
            }

            .welcome-section h1 {
                font-size: 24px;
            }

            .notification-details {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div id="loadingScreen" class="loading">
        <div>Loading dashboard... 🔄</div>
    </div>

    <div id="dashboardContent" style="display: none;">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="logo">🏋️ Protein Planet</div>
                <div style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                    ADMIN
                </div>
            </div>
            <div class="user-info">
                <span class="user-name">👤 <span id="userName">Admin</span></span>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1>Welcome back, <span id="welcomeName">Admin</span>! 👋</h1>
                <p>Here's what's happening with your supplement store today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-value" id="totalProducts">0</div>
                    <div class="stat-label">Total Products</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🛒</div>
                    <div class="stat-value" id="totalSales">0</div>
                    <div class="stat-label">Total Sales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-value">₹<span id="totalRevenue">0</span></div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📈</div>
                    <div class="stat-value">₹<span id="monthProfit">0</span></div>
                    <div class="stat-label">This Month's Profit</div>
                </div>
            </div>

            <!-- Notifications Section -->
            <div id="notifications" class="notifications-section">
                <div class="notifications-header">
                    <h2>
                        🔔 Alerts & Notifications
                        <span class="notification-count" id="notificationCount">0</span>
                    </h2>
                </div>
                <div id="notificationsContainer" class="notifications-grid">
                    <div class="no-notifications">
                        <div class="no-notifications-icon">🔄</div>
                        <p>Loading notifications...</p>
                    </div>
                </div>
            </div>

            <!-- Stock Management -->
            <div class="quick-actions">
                <h2>Stock Management</h2>
                <div class="action-grid">
                    <button class="action-btn" onclick="window.location.href='manage-brands.php'">
                        <span class="action-btn-icon">🏷️</span>
                        Manage Brands
                    </button>
                    <button class="action-btn" onclick="window.location.href='manage-categories.php'">
                        <span class="action-btn-icon">📂</span>
                        Manage Categories
                    </button>
                    <button class="action-btn" onclick="window.location.href='add-product.php'">
                        <span class="action-btn-icon">➕</span>
                        Add Product/Stock
                    </button>
                    <button class="action-btn" onclick="window.location.href='view-products.php'">
                        <span class="action-btn-icon">📦</span>
                        View All Products
                    </button>
                </div>
            </div>

            <!-- Sales & Reports -->
            <div class="quick-actions" style="margin-top: 20px;">
                <h2>Sales & Reports</h2>
                <div class="action-grid">
                    <button class="action-btn" onclick="window.location.href='pos-sale.php'">
                        <span class="action-btn-icon">💰</span>
                        Make Sale (POS)
                    </button>
                    <button class="action-btn" onclick="window.location.href='sales-history.php'">
                        <span class="action-btn-icon">📊</span>
                        Sales History
                    </button>
                    <button class="action-btn">
                        <span class="action-btn-icon">👥</span>
                        Manage Staff
                    </button>
                    <button class="action-btn">
                        <span class="action-btn-icon">⚙️</span>
                        Settings
                    </button>
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="recent-activity">
                <h2>Recent Sales (Last 10)</h2>
                <div id="recentSalesList">
                    <div style="text-align: center; padding: 20px; color: #7F8C8D;">
                        Loading recent sales...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>

    <script>
        // Check authentication
        firebaseAuth.onAuthStateChanged(async (user) => {
            if (!user) {
                // Not logged in, redirect to login
                window.location.href = 'login.php';
                return;
            }

            try {
                // Get user data from Firestore
                const userDoc = await firebaseDb.collection('users').doc(user.uid).get();
                
                if (!userDoc.exists) {
                    alert('User data not found. Please contact administrator.');
                    await firebaseAuth.signOut();
                    window.location.href = 'login.php';
                    return;
                }

                const userData = userDoc.data();

                // Check if user is admin
                if (userData.userType !== 'admin') {
                    alert('Access denied. Admin access required.');
                    await firebaseAuth.signOut();
                    window.location.href = 'login.php';
                    return;
                }

                // Display user info
                document.getElementById('userName').textContent = userData.name;
                document.getElementById('welcomeName').textContent = userData.name;

                // Hide loading, show dashboard
                document.getElementById('loadingScreen').style.display = 'none';
                document.getElementById('dashboardContent').style.display = 'block';

                // Load dashboard statistics
                loadDashboardStats();
                loadRecentSales();
                loadNotifications();

            } catch (error) {
                console.error('Error loading dashboard:', error);
                alert('Error loading dashboard. Please try again.');
                window.location.href = 'login.php';
            }
        });

        // Load dashboard statistics
        async function loadDashboardStats() {
            try {
                // Get total products
                const productsSnapshot = await firebaseDb.collection('products').get();
                const totalProducts = productsSnapshot.size;
                document.getElementById('totalProducts').textContent = totalProducts;

                // Get all sales
                const salesSnapshot = await firebaseDb.collection('sales').get();
                const totalSales = salesSnapshot.size;
                document.getElementById('totalSales').textContent = totalSales;

                // Calculate total revenue and this month's profit
                let totalRevenue = 0;
                let monthProfit = 0;
                const currentMonth = new Date().getMonth();
                const currentYear = new Date().getFullYear();

                salesSnapshot.forEach(doc => {
                    const sale = doc.data();
                    totalRevenue += sale.totalAmount || 0;

                    // Check if sale is from current month
                    if (sale.soldAt) {
                        const saleDate = sale.soldAt.toDate();
                        if (saleDate.getMonth() === currentMonth && saleDate.getFullYear() === currentYear) {
                            monthProfit += sale.totalProfit || 0;
                        }
                    }
                });

                document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
                document.getElementById('monthProfit').textContent = monthProfit.toFixed(2);

            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Load recent sales
        async function loadRecentSales() {
            try {
                const salesSnapshot = await firebaseDb.collection('sales')
                    .orderBy('soldAt', 'desc')
                    .limit(10)
                    .get();

                const container = document.getElementById('recentSalesList');

                if (salesSnapshot.empty) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 20px; color: #7F8C8D;">
                            <p>No sales yet</p>
                            <p style="font-size: 14px; margin-top: 10px;">Sales will appear here after checkout</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                salesSnapshot.forEach(doc => {
                    const sale = doc.data();
                    const date = sale.soldAt ? sale.soldAt.toDate() : new Date();
                    const timeAgo = getTimeAgo(date);
                    
                    html += `
                        <div class="activity-item">
                            <div class="activity-time">${timeAgo}</div>
                            <div class="activity-text">
                                Sale completed - ${sale.totalItems} items - ₹${sale.totalAmount.toFixed(2)}
                                <span style="color: #27ae60; font-weight: 600;">(Profit: ₹${sale.totalProfit.toFixed(2)})</span>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;

            } catch (error) {
                console.error('Error loading recent sales:', error);
                document.getElementById('recentSalesList').innerHTML = `
                    <div style="text-align: center; padding: 20px; color: #e74c3c;">
                        Error loading sales
                    </div>
                `;
            }
        }

        // Get time ago text
        function getTimeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            
            if (seconds < 60) return 'Just now';
            
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
            
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
            
            const days = Math.floor(hours / 24);
            if (days < 30) return `${days} day${days > 1 ? 's' : ''} ago`;
            
            return date.toLocaleDateString();
        }

        // Load notifications (expiring products and low stock)
        async function loadNotifications() {
            try {
                const productsSnapshot = await firebaseDb.collection('products')
                    .where('status', '==', 'active')
                    .get();

                const notifications = [];
                const today = new Date();
                const threeMonthsFromNow = new Date();
                threeMonthsFromNow.setDate(today.getDate() + 90); // 90 days = 3 months

                // Get brand and category data for better display
                const brandCache = {};
                const categoryCache = {};

                for (const doc of productsSnapshot.docs) {
                    const product = doc.data();
                    const productId = doc.id;

                    // Get brand name
                    if (product.brandId && !brandCache[product.brandId]) {
                        const brandDoc = await firebaseDb.collection('brands').doc(product.brandId).get();
                        brandCache[product.brandId] = brandDoc.exists ? brandDoc.data().name : 'Unknown Brand';
                    }

                    // Get category name
                    if (product.categoryId && !categoryCache[product.categoryId]) {
                        const categoryDoc = await firebaseDb.collection('categories').doc(product.categoryId).get();
                        categoryCache[product.categoryId] = categoryDoc.exists ? categoryDoc.data().name : 'Unknown Category';
                    }

                    const brandName = brandCache[product.brandId] || 'Unknown Brand';
                    const categoryName = categoryCache[product.categoryId] || 'Unknown Category';

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

                        // Calculate days until expiry
                        const daysUntilExpiry = Math.ceil((expiryMidnight - todayMidnight) / (1000 * 60 * 60 * 24));

                        console.log(`Product: ${product.name}`);
                        console.log(`  Expiry Date: ${expiryMidnight.toLocaleDateString()}`);
                        console.log(`  Days Until Expiry: ${daysUntilExpiry}`);
                        console.log(`  Within 90 days: ${expiryMidnight <= threeMonthsMidnight && expiryMidnight >= todayMidnight}`);
                        
                        if (expiryMidnight <= threeMonthsMidnight && expiryMidnight >= todayMidnight) {
                            notifications.push({
                                type: 'expiring',
                                priority: daysUntilExpiry <= 30 ? 'high' : 'medium',
                                title: `Product Expiring Soon`,
                                message: `${product.name} will expire in ${daysUntilExpiry} days`,
                                details: {
                                    brand: brandName,
                                    category: categoryName,
                                    expiryDate: expiryMidnight.toLocaleDateString(),
                                    stock: product.availableQuantity || 0,
                                    daysLeft: daysUntilExpiry
                                },
                                productId: productId,
                                sortOrder: daysUntilExpiry // For sorting by urgency
                            });
                            console.log(`  ✅ Added to notifications!`);
                        } else {
                            console.log(`  ❌ Not within alert range`);
                        }
                    }

                    // Check for low stock (10 or fewer items)
                    const availableQty = product.availableQuantity || 0;
                    if (availableQty <= 10) {
                        notifications.push({
                            type: 'low-stock',
                            priority: availableQty === 0 ? 'critical' : availableQty <= 5 ? 'high' : 'medium',
                            title: availableQty === 0 ? 'Out of Stock!' : 'Low Stock Alert',
                            message: `${product.name} - Only ${availableQty} unit${availableQty !== 1 ? 's' : ''} remaining`,
                            details: {
                                brand: brandName,
                                category: categoryName,
                                currentStock: availableQty,
                                buyingPrice: product.buyingPrice || 0
                            },
                            productId: productId,
                            sortOrder: availableQty // For sorting by urgency
                        });
                    }
                }

                // Sort notifications by priority and urgency
                notifications.sort((a, b) => {
                    const priorityOrder = { critical: 0, high: 1, medium: 2 };
                    const priorityDiff = priorityOrder[a.priority] - priorityOrder[b.priority];
                    if (priorityDiff !== 0) return priorityDiff;
                    return a.sortOrder - b.sortOrder;
                });

                // Update notification count
                const notificationCount = notifications.length;
                document.getElementById('notificationCount').textContent = notificationCount;

                // Display notifications
                const container = document.getElementById('notificationsContainer');

                if (notificationCount === 0) {
                    container.innerHTML = `
                        <div class="no-notifications">
                            <div class="no-notifications-icon">✅</div>
                            <p style="font-weight: 600;">All Good!</p>
                            <p style="font-size: 14px; margin-top: 5px;">No urgent notifications at this time.</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                notifications.forEach((notif, index) => {
                    const icon = notif.type === 'expiring' ? '⏰' : notif.priority === 'critical' ? '🚨' : '📦';
                    const typeClass = notif.type;

                    html += `
                        <div class="notification-card ${typeClass}" onclick="window.location.href='view-products.php'">
                            <div class="notification-icon">${icon}</div>
                            <div class="notification-content">
                                <div class="notification-title">${notif.title}</div>
                                <div class="notification-message">${notif.message}</div>
                                <div class="notification-details">
                    `;

                    if (notif.type === 'expiring') {
                        html += `
                            <div class="notification-detail-item">
                                <strong>📅 Expires:</strong> ${notif.details.expiryDate}
                            </div>
                            <div class="notification-detail-item">
                                <strong>🏷️ Brand:</strong> ${notif.details.brand}
                            </div>
                            <div class="notification-detail-item">
                                <strong>📊 Stock:</strong> ${notif.details.stock} units
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="notification-detail-item">
                                <strong>📦 Stock:</strong> ${notif.details.currentStock} units
                            </div>
                            <div class="notification-detail-item">
                                <strong>🏷️ Brand:</strong> ${notif.details.brand}
                            </div>
                            <div class="notification-detail-item">
                                <strong>💰 Price:</strong> ₹${notif.details.buyingPrice}
                            </div>
                        `;
                    }

                    html += `
                                </div>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;

                console.log(`✅ Loaded ${notificationCount} notification${notificationCount !== 1 ? 's' : ''}`);

            } catch (error) {
                console.error('Error loading notifications:', error);
                document.getElementById('notificationsContainer').innerHTML = `
                    <div class="no-notifications">
                        <div class="no-notifications-icon">⚠️</div>
                        <p style="color: #e74c3c;">Error loading notifications</p>
                    </div>
                `;
            }
        }

        // Logout function
        async function logout() {
            try {
                await firebaseAuth.signOut();
                window.location.href = 'login.php';
            } catch (error) {
                console.error('Logout error:', error);
                alert('Error logging out. Please try again.');
            }
        }
    </script>
</body>
</html>

