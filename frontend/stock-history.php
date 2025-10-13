<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Refill History - Protein Planet</title>
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
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .page-header {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filters {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filter-input {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .stat-label {
            color: #7F8C8D;
            font-size: 14px;
        }
        .history-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .back-btn {
            background: #7F8C8D;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">📊 Stock Refill History</h1>
                <p style="color: #7F8C8D;">Track all inventory refills and purchases</p>
            </div>
            <a href="view-products.php" class="back-btn">← Back to Products</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" id="totalRefills" style="color: #3498db;">0</div>
                <div class="stat-label">Total Refills</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="totalQuantity" style="color: #27AE60;">0</div>
                <div class="stat-label">Units Purchased</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="totalInvestment" style="color: #E74C3C;">₹0</div>
                <div class="stat-label">Total Investment</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="expectedRevenue" style="color: #9B59B6;">₹0</div>
                <div class="stat-label">Expected Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="expectedProfit" style="color: #16A085;">₹0</div>
                <div class="stat-label">Expected Profit</div>
            </div>
        </div>

        <div class="filters">
            <input type="text" id="searchBox" class="filter-input" placeholder="🔍 Search product, brand..." 
                   style="flex: 1; min-width: 250px;" onkeyup="applyFilters()">
            <select id="brandFilter" class="filter-input" onchange="applyFilters()">
                <option value="">All Brands</option>
            </select>
            <input type="date" id="dateFrom" class="filter-input" onchange="applyFilters()" placeholder="From Date">
            <input type="date" id="dateTo" class="filter-input" onchange="applyFilters()" placeholder="To Date">
        </div>

        <div class="history-table">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Qty Added</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Total Cost</th>
                        <th>Expected Revenue</th>
                        <th>Expected Profit</th>
                        <th>Previous Stock</th>
                        <th>New Stock</th>
                        <th>Refilled By</th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    <tr>
                        <td colspan="12" style="text-align: center; padding: 40px;">
                            <div style="font-size: 48px; margin-bottom: 10px;">🔄</div>
                            <p>Loading stock history...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>
    <script src="js/auth-check.js"></script>

    <script>
        let allHistory = [];

        // Load stock history
        async function loadStockHistory() {
            try {
                const snapshot = await firebaseDb.collection('stockHistory')
                    .orderBy('refillDate', 'desc')
                    .get();
                
                allHistory = [];
                snapshot.forEach(doc => {
                    allHistory.push({ id: doc.id, ...doc.data() });
                });

                displayHistory(allHistory);
                updateStats(allHistory);
                loadBrandFilter();

            } catch (error) {
                console.error('Error loading stock history:', error);
                document.getElementById('historyTableBody').innerHTML = `
                    <tr><td colspan="12" style="text-align:center; color: #e74c3c;">Error loading history: ${error.message}</td></tr>
                `;
            }
        }

        // Display stock history
        function displayHistory(history) {
            const tbody = document.getElementById('historyTableBody');
            
            if (history.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="12" style="text-align: center; padding: 40px;">
                            <div style="font-size: 48px; margin-bottom: 10px;">📦</div>
                            <p>No stock refills yet</p>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            history.forEach(record => {
                const refillDate = record.refillDate ? 
                    new Date(record.refillDate.toDate()).toLocaleDateString() : 'N/A';
                
                html += `
                    <tr>
                        <td><strong>${refillDate}</strong></td>
                        <td>${record.productName}</td>
                        <td>${record.brandName}</td>
                        <td><strong style="color: #3498db;">${record.quantityAdded}</strong></td>
                        <td>₹${record.buyingPrice.toFixed(2)}</td>
                        <td>₹${record.sellingPrice.toFixed(2)}</td>
                        <td><strong>₹${record.totalBuyingCost.toFixed(2)}</strong></td>
                        <td><strong>₹${record.totalSellingValue.toFixed(2)}</strong></td>
                        <td><strong style="color: #27AE60;">₹${record.expectedProfit.toFixed(2)}</strong></td>
                        <td>${record.previousStock}</td>
                        <td><strong style="color: #27AE60;">${record.newStock}</strong></td>
                        <td>${record.refillByName || 'Admin'}</td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        // Update statistics
        function updateStats(history) {
            const totalRefills = history.length;
            const totalQuantity = history.reduce((sum, r) => sum + (r.quantityAdded || 0), 0);
            const totalInvestment = history.reduce((sum, r) => sum + (r.totalBuyingCost || 0), 0);
            const expectedRevenue = history.reduce((sum, r) => sum + (r.totalSellingValue || 0), 0);
            const expectedProfit = history.reduce((sum, r) => sum + (r.expectedProfit || 0), 0);

            document.getElementById('totalRefills').textContent = totalRefills;
            document.getElementById('totalQuantity').textContent = totalQuantity;
            document.getElementById('totalInvestment').textContent = '₹' + totalInvestment.toFixed(2);
            document.getElementById('expectedRevenue').textContent = '₹' + expectedRevenue.toFixed(2);
            document.getElementById('expectedProfit').textContent = '₹' + expectedProfit.toFixed(2);
        }

        // Load brand filter
        async function loadBrandFilter() {
            const brandsSnapshot = await firebaseDb.collection('brands').orderBy('name').get();
            const brandFilter = document.getElementById('brandFilter');
            
            brandsSnapshot.forEach(doc => {
                const option = document.createElement('option');
                option.value = doc.id;
                option.textContent = doc.data().name;
                brandFilter.appendChild(option);
            });
        }

        // Apply filters
        function applyFilters() {
            const searchTerm = document.getElementById('searchBox').value.toLowerCase();
            const brandFilter = document.getElementById('brandFilter').value;
            const dateFrom = document.getElementById('dateFrom').value;
            const dateTo = document.getElementById('dateTo').value;

            let filtered = allHistory.filter(record => {
                // Search filter
                if (searchTerm && !(
                    record.productName.toLowerCase().includes(searchTerm) ||
                    record.brandName.toLowerCase().includes(searchTerm)
                )) {
                    return false;
                }

                // Brand filter
                if (brandFilter && record.brandId !== brandFilter) {
                    return false;
                }

                // Date filters
                if (record.refillDate) {
                    const refillDate = new Date(record.refillDate.toDate()).toISOString().split('T')[0];
                    if (dateFrom && refillDate < dateFrom) return false;
                    if (dateTo && refillDate > dateTo) return false;
                }

                return true;
            });

            displayHistory(filtered);
            updateStats(filtered);
        }

        // Load on page load
        loadStockHistory();
    </script>
</body>
</html>

