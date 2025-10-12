<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Protein Planet</title>
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
            background: linear-gradient(135deg, #004E89 0%, #FF6B35 100%);
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
            color: #004E89;
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

        /* Tasks Section */
        .tasks-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .tasks-section h2 {
            color: #2C3E50;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .task-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .task-item:hover {
            background: #e9ecef;
        }

        .task-checkbox {
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .task-text {
            flex: 1;
            color: #2C3E50;
        }

        .task-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-urgent {
            background: #fee;
            color: #E74C3C;
        }

        .badge-normal {
            background: #fff8e1;
            color: #FFB627;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
            background: linear-gradient(135deg, #004E89 0%, #FF6B35 100%);
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
            box-shadow: 0 6px 20px rgba(0, 78, 137, 0.4);
        }

        .action-btn-icon {
            font-size: 24px;
            display: block;
            margin-bottom: 10px;
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
                    STAFF
                </div>
            </div>
            <div class="user-info">
                <span class="user-name">👤 <span id="userName">Staff</span></span>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h1>Hello, <span id="welcomeName">Staff</span>! 👋</h1>
                <p>Ready to help customers achieve their fitness goals today?</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-value" id="salesToday">0</div>
                    <div class="stat-label">Sales Today</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-value">₹<span id="revenueToday">0</span></div>
                    <div class="stat-label">Revenue Today</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-value" id="totalSales">0</div>
                    <div class="stat-label">Total Sales (All Time)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value" id="customersServed">0</div>
                    <div class="stat-label">Customers Served</div>
                </div>
            </div>

            <!-- Recent Sales -->
            <div class="tasks-section">
                <h2>My Recent Sales (Last 5)</h2>
                <div id="recentSalesList">
                    <div style="text-align: center; padding: 20px; color: #7F8C8D;">
                        Loading your recent sales...
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-grid">
                    <button class="action-btn" onclick="window.location.href='staff-pos.php'">
                        <span class="action-btn-icon">💰</span>
                        Make Sale (POS)
                    </button>
                    <button class="action-btn" onclick="window.location.href='staff-products.php'">
                        <span class="action-btn-icon">📦</span>
                        View Products & Prices
                    </button>
                    <button class="action-btn" onclick="window.location.href='customer-purchases.php'">
                        <span class="action-btn-icon">👥</span>
                        Customer Purchases
                    </button>
                    <button class="action-btn" onclick="window.location.href='staff-sales-history.php'">
                        <span class="action-btn-icon">📊</span>
                        My Sales History
                    </button>
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

                // Check if user is staff
                if (userData.userType !== 'staff') {
                    alert('Access denied. Staff access required.');
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

                // Load staff statistics
                loadStaffStats(user.uid);
                loadRecentSales(user.uid);

            } catch (error) {
                console.error('Error loading dashboard:', error);
                alert('Error loading dashboard. Please try again.');
                window.location.href = 'login.php';
            }
        });

        // Load staff statistics
        async function loadStaffStats(staffId) {
            try {
                // Get all sales by this staff
                const salesSnapshot = await firebaseDb.collection('sales')
                    .where('soldBy', '==', staffId)
                    .get();

                let totalSales = 0;
                let salesToday = 0;
                let revenueToday = 0;
                const uniqueCustomers = new Set();
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                salesSnapshot.forEach(doc => {
                    const sale = doc.data();
                    totalSales++;

                    // Add customer to set
                    if (sale.customer && sale.customer.name) {
                        uniqueCustomers.add(sale.customer.name.toLowerCase());
                    }

                    // Check if sale is today
                    if (sale.soldAt) {
                        const saleDate = sale.soldAt.toDate();
                        saleDate.setHours(0, 0, 0, 0);
                        
                        if (saleDate.getTime() === today.getTime()) {
                            salesToday++;
                            revenueToday += sale.totalAmount || 0;
                        }
                    }
                });

                // Update UI
                document.getElementById('salesToday').textContent = salesToday;
                document.getElementById('revenueToday').textContent = revenueToday.toFixed(2);
                document.getElementById('totalSales').textContent = totalSales;
                document.getElementById('customersServed').textContent = uniqueCustomers.size;

            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Load recent sales
        async function loadRecentSales(staffId) {
            try {
                const salesSnapshot = await firebaseDb.collection('sales')
                    .where('soldBy', '==', staffId)
                    .orderBy('soldAt', 'desc')
                    .limit(5)
                    .get();

                const container = document.getElementById('recentSalesList');

                if (salesSnapshot.empty) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 20px; color: #7F8C8D;">
                            <p>No sales yet</p>
                            <p style="font-size: 14px; margin-top: 10px;">Your sales will appear here</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                salesSnapshot.forEach(doc => {
                    const sale = doc.data();
                    const date = sale.soldAt ? sale.soldAt.toDate() : new Date();
                    const timeAgo = getTimeAgo(date);
                    const customerName = sale.customer?.name || 'Walk-in Customer';
                    
                    html += `
                        <div style="padding: 12px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid #004E89;">
                            <div style="font-size: 12px; color: #7F8C8D; margin-bottom: 4px;">${timeAgo}</div>
                            <div style="font-weight: 600; color: #2C3E50;">
                                ${customerName} - ${sale.totalItems} items - ₹${sale.totalAmount.toFixed(2)}
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

