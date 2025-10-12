<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stat-label {
            color: #7F8C8D;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #2C3E50;
        }
        .sales-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2C3E50;
            border-bottom: 2px solid #e0e0e0;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #2C3E50;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .btn-view {
            padding: 6px 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 5px;
        }
        .btn-delete {
            padding: 6px 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-view:hover {
            background: #2980b9;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7F8C8D;
        }
        
        /* Search and Filter */
        .search-filter-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }
        .search-box {
            flex: 1;
            min-width: 250px;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .search-box:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .filter-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            background: white;
        }
        .btn-clear-filters {
            padding: 12px 20px;
            background: #7f8c8d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        .btn-clear-filters:hover {
            background: #6c7a7b;
        }
        
        /* Receipt Modal */
        .receipt-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .receipt-modal.show { display: flex; }
        
        .receipt-container {
            background: white;
            max-width: 500px;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        
        .receipt-content {
            padding: 30px;
            overflow-y: auto;
            flex: 1;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .receipt-logo {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .receipt-title {
            font-size: 28px;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 5px;
        }
        
        .receipt-subtitle {
            color: #7F8C8D;
            font-size: 14px;
        }
        
        .receipt-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .receipt-info-label {
            color: #7F8C8D;
        }
        
        .receipt-info-value {
            font-weight: 600;
            color: #2C3E50;
        }
        
        .receipt-items {
            margin-bottom: 20px;
        }
        
        .receipt-items-title {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .receipt-item {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .receipt-item:last-child {
            border-bottom: none;
        }
        
        .receipt-item-name {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 4px;
        }
        
        .receipt-item-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #7F8C8D;
        }
        
        .receipt-item-price {
            font-weight: 600;
            color: #27ae60;
        }
        
        .receipt-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .receipt-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 15px;
        }
        
        .receipt-total {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            margin-top: 10px;
        }
        
        .receipt-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            color: #7F8C8D;
            font-size: 13px;
        }
        
        .receipt-actions {
            padding: 20px;
            background: #f8f9fa;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .receipt-btn {
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .receipt-btn-whatsapp {
            background: #25D366;
            color: white;
        }
        
        .receipt-btn-email {
            background: #3498db;
            color: white;
        }
        
        .receipt-btn-print {
            background: #34495e;
            color: white;
            grid-column: 1 / -1;
        }
        
        .receipt-btn-close {
            background: #7f8c8d;
            color: white;
            grid-column: 1 / -1;
        }
        
        .receipt-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        @media print {
            .header, .container > *:not(#receiptModal) {
                display: none !important;
            }
            .receipt-modal {
                display: block !important;
                position: static;
                background: white;
            }
            .receipt-container {
                max-width: 100%;
                box-shadow: none;
            }
            .receipt-actions {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">📊 Sales History</h1>
                <p style="color: #7F8C8D;">Track all sales and revenue</p>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="search-filter-bar">
            <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search by customer name, product, brand, or category...">
            <div class="filter-group">
                <select class="filter-select" id="staffFilter">
                    <option value="">All Staff</option>
                </select>
                <select class="filter-select" id="dateFilter">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                <button class="btn-clear-filters" onclick="clearFilters()">Clear Filters</button>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Sales</div>
                <div class="stat-value" id="totalSales">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value" style="color: #27ae60;">₹<span id="totalRevenue">0.00</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Profit</div>
                <div class="stat-value" style="color: #FF6B35;">₹<span id="totalProfit">0.00</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Items Sold</div>
                <div class="stat-value" id="totalItems">0</div>
            </div>
        </div>

        <div class="sales-table">
            <table>
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Profit</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="salesTableBody">
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">Loading sales...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="receipt-modal">
        <div class="receipt-container">
            <div class="receipt-content">
                <div class="receipt-header">
                    <div class="receipt-logo">🏋️</div>
                    <div class="receipt-title">Protein Planet</div>
                    <div class="receipt-subtitle">Your Fitness Partner</div>
                </div>

                <div class="receipt-info">
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Receipt #</span>
                        <span class="receipt-info-value" id="receiptNumber">-</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Date & Time</span>
                        <span class="receipt-info-value" id="receiptDate">-</span>
                    </div>
                </div>

                <!-- Customer Information on Receipt -->
                <div id="customerInfoReceipt" style="display: none; background: #e8f4f8; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #3498db;">
                    <div style="font-weight: 600; color: #2C3E50; margin-bottom: 10px;">Customer Details</div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Name</span>
                        <span class="receipt-info-value" id="receiptCustomerName">-</span>
                    </div>
                    <div class="receipt-info-row" id="receiptWhatsappRow" style="display: none;">
                        <span class="receipt-info-label">WhatsApp</span>
                        <span class="receipt-info-value" id="receiptCustomerWhatsapp">-</span>
                    </div>
                    <div class="receipt-info-row" id="receiptEmailRow" style="display: none;">
                        <span class="receipt-info-label">Email</span>
                        <span class="receipt-info-value" id="receiptCustomerEmail">-</span>
                    </div>
                </div>

                <div class="receipt-items">
                    <div class="receipt-items-title">Items Purchased</div>
                    <div id="receiptItemsList"></div>
                </div>

                <div class="receipt-summary">
                    <div class="receipt-summary-row">
                        <span>Subtotal:</span>
                        <span>₹<span id="receiptSubtotal">0.00</span></span>
                    </div>
                    <div class="receipt-summary-row receipt-total">
                        <span>TOTAL:</span>
                        <span>₹<span id="receiptTotal">0.00</span></span>
                    </div>
                </div>

                <div class="receipt-footer">
                    <p><strong>Thank you for your purchase!</strong></p>
                    <p>Keep pushing your limits! 💪</p>
                    <p style="margin-top: 10px;">📱 +91 7008362528</p>
                    <p style="font-size: 11px; margin-top: 5px;">Shop 107, RCMS Complex, Civil Township, Rourkela, Odisha 769012</p>
                </div>
            </div>

            <div class="receipt-actions">
                <button class="receipt-btn receipt-btn-print" onclick="printReceipt()">
                    🖨️ Print Receipt
                </button>
                <button class="receipt-btn receipt-btn-close" onclick="closeReceipt()">
                    ✖️ Close
                </button>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>
    <script src="js/auth-check.js"></script>

    <script>
        let allSales = [];
        let filteredSales = [];

        async function loadSales() {
            try {
                const snapshot = await firebaseDb.collection('sales').orderBy('soldAt', 'desc').get();
                allSales = [];

                snapshot.forEach(doc => {
                    allSales.push({ id: doc.id, ...doc.data() });
                });

                filteredSales = [...allSales];
                displaySales(filteredSales);
                updateStats();

            } catch (error) {
                console.error('Error loading sales:', error);
                document.getElementById('salesTableBody').innerHTML = `
                    <tr><td colspan="6" style="text-align:center; color: #e74c3c;">Error: ${error.message}</td></tr>
                `;
            }
        }

        function displaySales(sales = filteredSales) {
            const tbody = document.getElementById('salesTableBody');
            
            if (allSales.length === 0) {
                tbody.innerHTML = `
                    <tr><td colspan="6">
                        <div class="empty-state">
                            <div style="font-size: 64px;">📊</div>
                            <h3>No Sales Yet</h3>
                            <p>Sales will appear here</p>
                        </div>
                    </td></tr>
                `;
                return;
            }

            let html = '';
            sales.forEach(sale => {
                const date = sale.soldAt ? new Date(sale.soldAt.toDate()).toLocaleString() : 'N/A';
                const customerName = sale.customer?.name || 'Walk-in Customer';
                const customerPhone = sale.customer?.whatsapp || '';
                
                html += `
                    <tr>
                        <td>${date}</td>
                        <td>
                            <div style="font-weight: 600;">${customerName}</div>
                            ${customerPhone ? `<div style="font-size: 12px; color: #7F8C8D;">📱 ${customerPhone}</div>` : ''}
                        </td>
                        <td>${sale.totalItems} items</td>
                        <td style="font-weight: 600; color: #27ae60;">₹${sale.totalAmount.toFixed(2)}</td>
                        <td style="font-weight: 600; color: #FF6B35;">₹${sale.totalProfit.toFixed(2)}</td>
                        <td>
                            <button class="btn-view" onclick="showBill('${sale.id}')" title="View Bill">🧾 Bill</button>
                            <button class="btn-view" onclick="viewSale('${sale.id}')" title="View Details">👁️ Details</button>
                            <button class="btn-delete" onclick="deleteSale('${sale.id}', '${sale.totalAmount.toFixed(2)}')" title="Delete">🗑️</button>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        function updateStats() {
            const totalSales = allSales.length;
            const totalRevenue = allSales.reduce((sum, s) => sum + s.totalAmount, 0);
            const totalProfit = allSales.reduce((sum, s) => sum + s.totalProfit, 0);
            const totalItems = allSales.reduce((sum, s) => sum + s.totalItems, 0);

            document.getElementById('totalSales').textContent = totalSales;
            document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
            document.getElementById('totalProfit').textContent = totalProfit.toFixed(2);
            document.getElementById('totalItems').textContent = totalItems;
        }

        function viewSale(id) {
            const sale = allSales.find(s => s.id === id);
            if (!sale) return;
            
            const date = sale.soldAt ? new Date(sale.soldAt.toDate()).toLocaleString('en-IN') : 'N/A';
            
            // Build detailed sale information
            let details = `━━━━━━━━━━━ SALE DETAILS ━━━━━━━━━━━\n\n`;
            details += `Receipt #: PP-${id.substring(0, 8).toUpperCase()}\n`;
            details += `Date: ${date}\n\n`;
            
            // Customer Information
            if (sale.customer) {
                details += `━━━━━━━━━ CUSTOMER INFO ━━━━━━━━━\n`;
                details += `Name: ${sale.customer.name || 'N/A'}\n`;
                if (sale.customer.whatsapp) {
                    details += `WhatsApp: ${sale.customer.whatsapp}\n`;
                }
                if (sale.customer.email) {
                    details += `Email: ${sale.customer.email}\n`;
                }
                details += `\n`;
            }
            
            // Items List
            details += `━━━━━━━━━━ ITEMS SOLD ━━━━━━━━━━\n\n`;
            sale.items.forEach((item, index) => {
                details += `${index + 1}. ${item.name}\n`;
                details += `   Brand: ${item.brand}\n`;
                details += `   Quantity: ${item.quantity}\n`;
                details += `   Price: ₹${item.price.toFixed(2)}\n`;
                details += `   Total: ₹${item.total.toFixed(2)}\n\n`;
            });
            
            // Summary
            details += `━━━━━━━━━━━ SUMMARY ━━━━━━━━━━━\n`;
            details += `Total Items: ${sale.totalItems}\n`;
            details += `Total Amount: ₹${sale.totalAmount.toFixed(2)}\n`;
            details += `Total Profit: ₹${sale.totalProfit.toFixed(2)}\n`;
            details += `━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━`;
            
            alert(details);
        }

        async function deleteSale(id, amount) {
            const sale = allSales.find(s => s.id === id);
            if (!sale) return;

            const confirmMessage = `Are you sure you want to delete this sale?\n\n` +
                `Amount: ₹${amount}\n` +
                `Items: ${sale.totalItems}\n\n` +
                `⚠️ Warning: This will NOT restore the inventory quantities.\n` +
                `This action cannot be undone!`;

            if (!confirm(confirmMessage)) {
                return;
            }

            try {
                // Delete from Firestore
                await firebaseDb.collection('sales').doc(id).delete();

                // Show success message
                const successMsg = document.createElement('div');
                successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #27ae60; color: white; padding: 15px 20px; border-radius: 8px; z-index: 9999; animation: slideIn 0.3s ease;';
                successMsg.textContent = '✅ Sale deleted successfully!';
                document.body.appendChild(successMsg);

                setTimeout(() => {
                    successMsg.remove();
                }, 3000);

                // Reload sales
                await loadSales();

            } catch (error) {
                console.error('Error deleting sale:', error);
                alert('❌ Error deleting sale: ' + error.message);
            }
        }

        // Global variable for current receipt
        let currentReceipt = null;

        // Show bill/receipt
        function showBill(id) {
            const sale = allSales.find(s => s.id === id);
            if (!sale) return;

            // Store receipt data
            currentReceipt = {
                receiptId: id,
                items: sale.items,
                total: sale.totalAmount,
                date: sale.soldAt ? sale.soldAt.toDate() : new Date(),
                customer: sale.customer || null
            };

            // Format receipt number
            const receiptNum = 'PP-' + id.substring(0, 8).toUpperCase();
            document.getElementById('receiptNumber').textContent = receiptNum;

            // Format date
            const date = sale.soldAt ? sale.soldAt.toDate() : new Date();
            const dateStr = date.toLocaleString('en-IN', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('receiptDate').textContent = dateStr;

            // Customer information
            if (sale.customer && sale.customer.name) {
                document.getElementById('customerInfoReceipt').style.display = 'block';
                document.getElementById('receiptCustomerName').textContent = sale.customer.name;
                
                if (sale.customer.whatsapp) {
                    document.getElementById('receiptWhatsappRow').style.display = 'flex';
                    document.getElementById('receiptCustomerWhatsapp').textContent = sale.customer.whatsapp;
                } else {
                    document.getElementById('receiptWhatsappRow').style.display = 'none';
                }
                
                if (sale.customer.email) {
                    document.getElementById('receiptEmailRow').style.display = 'flex';
                    document.getElementById('receiptCustomerEmail').textContent = sale.customer.email;
                } else {
                    document.getElementById('receiptEmailRow').style.display = 'none';
                }
            } else {
                document.getElementById('customerInfoReceipt').style.display = 'none';
            }

            // Items list
            let itemsHtml = '';
            sale.items.forEach(item => {
                itemsHtml += `
                    <div class="receipt-item">
                        <div class="receipt-item-name">${item.name}</div>
                        <div class="receipt-item-details">
                            <span>${item.quantity} × ₹${item.price.toFixed(2)}</span>
                            <span class="receipt-item-price">₹${item.total.toFixed(2)}</span>
                        </div>
                    </div>
                `;
            });
            document.getElementById('receiptItemsList').innerHTML = itemsHtml;

            // Totals
            document.getElementById('receiptSubtotal').textContent = sale.totalAmount.toFixed(2);
            document.getElementById('receiptTotal').textContent = sale.totalAmount.toFixed(2);

            // Show modal
            document.getElementById('receiptModal').classList.add('show');
        }

        // Close receipt
        function closeReceipt() {
            document.getElementById('receiptModal').classList.remove('show');
        }

        // Print receipt
        function printReceipt() {
            window.print();
        }


        // Load staff for filter
        async function loadStaffFilter() {
            try {
                const usersSnapshot = await firebaseDb.collection('users').where('userType', '==', 'staff').get();
                const staffFilter = document.getElementById('staffFilter');
                
                usersSnapshot.forEach(doc => {
                    const user = doc.data();
                    const option = document.createElement('option');
                    option.value = doc.id;
                    option.textContent = user.name;
                    staffFilter.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading staff:', error);
            }
        }

        // Search and Filter
        document.getElementById('searchBox').addEventListener('input', applyFilters);
        document.getElementById('staffFilter').addEventListener('change', applyFilters);
        document.getElementById('dateFilter').addEventListener('change', applyFilters);

        function applyFilters() {
            const searchTerm = document.getElementById('searchBox').value.toLowerCase();
            const staffId = document.getElementById('staffFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;

            filteredSales = allSales.filter(sale => {
                // Staff filter
                let matchesStaff = true;
                if (staffId) {
                    matchesStaff = sale.soldBy === staffId;
                }

                // Search filter - now includes customer name
                let matchesSearch = true;
                if (searchTerm) {
                    const customerMatch = sale.customer?.name?.toLowerCase().includes(searchTerm) || false;
                    const customerPhoneMatch = sale.customer?.whatsapp?.toLowerCase().includes(searchTerm) || false;
                    const productMatch = sale.items.some(item => 
                        item.name.toLowerCase().includes(searchTerm) ||
                        (item.brand && item.brand.toLowerCase().includes(searchTerm)) ||
                        (item.category && item.category.toLowerCase().includes(searchTerm))
                    );
                    
                    matchesSearch = customerMatch || customerPhoneMatch || productMatch;
                }

                // Date filter
                let matchesDate = true;
                if (dateFilter && sale.soldAt) {
                    const saleDate = sale.soldAt.toDate();
                    const now = new Date();
                    
                    switch(dateFilter) {
                        case 'today':
                            matchesDate = saleDate.toDateString() === now.toDateString();
                            break;
                        case 'week':
                            const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                            matchesDate = saleDate >= weekAgo;
                            break;
                        case 'month':
                            matchesDate = saleDate.getMonth() === now.getMonth() && 
                                         saleDate.getFullYear() === now.getFullYear();
                            break;
                    }
                }

                return matchesStaff && matchesSearch && matchesDate;
            });

            displaySales(filteredSales);
            updateStatsForFiltered(filteredSales);
        }

        function updateStatsForFiltered(sales) {
            const totalSales = sales.length;
            const totalRevenue = sales.reduce((sum, s) => sum + s.totalAmount, 0);
            const totalProfit = sales.reduce((sum, s) => sum + s.totalProfit, 0);
            const totalItems = sales.reduce((sum, s) => sum + s.totalItems, 0);

            document.getElementById('totalSales').textContent = totalSales;
            document.getElementById('totalRevenue').textContent = totalRevenue.toFixed(2);
            document.getElementById('totalProfit').textContent = totalProfit.toFixed(2);
            document.getElementById('totalItems').textContent = totalItems;
        }

        function clearFilters() {
            document.getElementById('searchBox').value = '';
            document.getElementById('staffFilter').value = '';
            document.getElementById('dateFilter').value = '';
            filteredSales = [...allSales];
            displaySales(filteredSales);
            updateStats();
        }

        // Add animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);

        loadSales();
        loadStaffFilter();
    </script>
</body>
</html>

