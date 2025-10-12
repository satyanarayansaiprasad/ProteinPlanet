<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Purchases - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .search-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .search-box {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .search-box:focus {
            outline: none;
            border-color: #004E89;
        }
        .customer-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .customer-item {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background 0.3s;
        }
        .customer-item:hover {
            background: #f8f9fa;
        }
        .customer-item:last-child {
            border-bottom: none;
        }
        .customer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .customer-name {
            font-size: 18px;
            font-weight: 600;
            color: #2C3E50;
        }
        .customer-stats {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: #7F8C8D;
        }
        .customer-stat-value {
            font-weight: 600;
            color: #27ae60;
        }
        .customer-contact {
            font-size: 13px;
            color: #7F8C8D;
            margin-bottom: 10px;
        }
        .customer-purchases {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }
        .customer-purchases.show {
            display: block;
        }
        .purchase-item {
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .purchase-item:last-child {
            border-bottom: none;
        }
        .purchase-date {
            font-size: 12px;
            color: #7F8C8D;
            margin-bottom: 8px;
        }
        .product-line {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 14px;
        }
        .product-name {
            font-weight: 500;
            color: #2C3E50;
        }
        .product-meta {
            font-size: 12px;
            color: #7F8C8D;
        }
        .product-price {
            font-weight: 600;
            color: #27ae60;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7F8C8D;
        }
    </style>
</head>
<body>
    <?php include 'includes/staff-header.php'; ?>

    <div class="container">
        <div style="margin-bottom: 30px;">
            <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">👥 Customer Purchase History</h1>
            <p style="color: #7F8C8D;">View purchase history for each customer</p>
        </div>

        <!-- Search -->
        <div class="search-bar">
            <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search by customer name or phone number...">
        </div>

        <div id="customersContainer">
            <div class="empty-state">
                <div style="font-size: 64px;">🔄</div>
                <p>Loading customer data...</p>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>
    <script src="js/staff-auth-check.js"></script>

    <script>
        let customersData = new Map();

        async function loadCustomerPurchases() {
            try {
                const salesSnapshot = await firebaseDb.collection('sales').orderBy('soldAt', 'desc').get();

                // Group sales by customer
                salesSnapshot.forEach(doc => {
                    const sale = { id: doc.id, ...doc.data() };
                    
                    if (sale.customer && sale.customer.name) {
                        const customerKey = sale.customer.name.toLowerCase();
                        
                        if (!customersData.has(customerKey)) {
                            customersData.set(customerKey, {
                                name: sale.customer.name,
                                whatsapp: sale.customer.whatsapp || '',
                                email: sale.customer.email || '',
                                purchases: [],
                                totalSpent: 0,
                                totalPurchases: 0
                            });
                        }
                        
                        const customer = customersData.get(customerKey);
                        customer.purchases.push(sale);
                        customer.totalSpent += sale.totalAmount;
                        customer.totalPurchases += 1;
                    }
                });

                displayCustomers(Array.from(customersData.values()));

            } catch (error) {
                console.error('Error loading customer purchases:', error);
                document.getElementById('customersContainer').innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 64px;">❌</div>
                        <p>Error loading data</p>
                    </div>
                `;
            }
        }

        function displayCustomers(customers) {
            const container = document.getElementById('customersContainer');
            
            if (customers.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 64px;">👥</div>
                        <h3>No Customers Found</h3>
                        <p>Customer purchases will appear here</p>
                    </div>
                `;
                return;
            }

            // Sort by total spent (highest first)
            customers.sort((a, b) => b.totalSpent - a.totalSpent);

            let html = '<div class="customer-list">';
            customers.forEach((customer, index) => {
                html += `
                    <div class="customer-item" onclick="togglePurchases(${index})">
                        <div class="customer-header">
                            <div>
                                <div class="customer-name">${customer.name}</div>
                                <div class="customer-contact">
                                    ${customer.whatsapp ? `📱 ${customer.whatsapp}` : ''}
                                </div>
                            </div>
                            <div class="customer-stats">
                                <div>
                                    <div style="font-size: 12px;">Total Spent</div>
                                    <div class="customer-stat-value">₹${customer.totalSpent.toFixed(2)}</div>
                                </div>
                                <div>
                                    <div style="font-size: 12px;">Purchases</div>
                                    <div class="customer-stat-value">${customer.totalPurchases}</div>
                                </div>
                            </div>
                        </div>
                        <div class="customer-purchases" id="purchases-${index}">
                            <div style="font-weight: 600; margin-bottom: 10px; color: #2C3E50;">Purchase History:</div>
                            ${customer.purchases.map(purchase => {
                                const date = purchase.soldAt ? new Date(purchase.soldAt.toDate()).toLocaleString('en-IN', { 
                                    month: 'short', 
                                    day: 'numeric', 
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }) : 'N/A';
                                
                                const productsHtml = purchase.items.map(item => `
                                    <div class="product-line">
                                        <div>
                                            <div class="product-name">${item.name}</div>
                                            <div class="product-meta">${item.brand} - ${item.category}</div>
                                        </div>
                                        <div class="product-price">₹${item.price.toFixed(2)} × ${item.quantity}</div>
                                    </div>
                                `).join('');
                                
                                return `
                                    <div class="purchase-item">
                                        <div class="purchase-date">📅 ${date}</div>
                                        ${productsHtml}
                                        <div style="font-weight: 600; color: #27ae60; margin-top: 8px; text-align: right;">
                                            Total: ₹${purchase.totalAmount.toFixed(2)}
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            
            container.innerHTML = html;
        }

        function togglePurchases(index) {
            const element = document.getElementById(`purchases-${index}`);
            if (element) {
                element.classList.toggle('show');
            }
        }

        // Search functionality
        document.getElementById('searchBox').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const allCustomers = Array.from(customersData.values());
            
            const filtered = allCustomers.filter(customer => 
                customer.name.toLowerCase().includes(searchTerm) ||
                (customer.whatsapp && customer.whatsapp.includes(searchTerm)) ||
                (customer.email && customer.email.toLowerCase().includes(searchTerm))
            );
            
            displayCustomers(filtered);
        });

        loadCustomerPurchases();
    </script>
</body>
</html>

