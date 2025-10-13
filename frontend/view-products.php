<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }
        .search-filter {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .search-box {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            min-width: 250px;
        }
        .search-box:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .filter-select {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .add-btn {
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        .products-table {
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
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-active { background: #d4edda; color: #155724; }
        .status-low { background: #fff3cd; color: #856404; }
        .status-expired { background: #f8d7da; color: #721c24; }
        .action-btns {
            display: flex;
            gap: 5px;
        }
        .btn-sm {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
        }
        .btn-view { background: #3498db; color: white; }
        .btn-edit { background: #f39c12; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7F8C8D;
        }
        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .products-table {
                font-size: 14px;
            }
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>

    <div class="container">
        <div class="page-header">
            <div>
                <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">📦 All Products</h1>
                <p style="color: #7F8C8D;">Manage your inventory</p>
            </div>
            <button class="add-btn" onclick="window.location.href='add-product.php'">
                ➕ Add New Product
            </button>
        </div>

        <div class="search-filter">
            <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search by name, brand, category...">
            <select class="filter-select" id="brandFilter">
                <option value="">All Brands</option>
            </select>
            <select class="filter-select" id="categoryFilter">
                <option value="">All Categories</option>
            </select>
            <select class="filter-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="low">Low Stock</option>
                <option value="expired">Expired</option>
            </select>
        </div>

        <div style="margin: 20px 0; padding: 15px; background: white; border-radius: 8px;">
            <strong>Total Products:</strong> <span id="totalProducts">0</span> | 
            <strong>Total Value:</strong> ₹<span id="totalValue">0.00</span> | 
            <strong>Low Stock:</strong> <span id="lowStock">0</span>
        </div>

        <div class="products-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Qty</th>
                        <th>Buy Price</th>
                        <th>Sell Price</th>
                        <th>Expiry</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px;">
                            <div class="empty-state-icon">🔄</div>
                            <p>Loading products...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>
    <script src="js/auth-check.js"></script>

    <script>
        let allProducts = [];

        // Load all products
        async function loadProducts() {
            try {
                const snapshot = await firebaseDb.collection('products').orderBy('createdAt', 'desc').get();
                allProducts = [];

                snapshot.forEach(doc => {
                    allProducts.push({ id: doc.id, ...doc.data() });
                });

                displayProducts(allProducts);
                updateStats();
                loadFilters();

            } catch (error) {
                console.error('Error loading products:', error);
                document.getElementById('productsTableBody').innerHTML = `
                    <tr><td colspan="9" style="text-align:center; color: #e74c3c;">Error loading products: ${error.message}</td></tr>
                `;
            }
        }

        // Display products in table
        function displayProducts(products) {
            const tbody = document.getElementById('productsTableBody');
            
            if (products.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-state-icon">📦</div>
                                <h3>No Products Found</h3>
                                <p>Add your first product to get started</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            products.forEach(product => {
                const status = getProductStatus(product);
                const expiryDate = product.expiryDate ? new Date(product.expiryDate.toDate()).toLocaleDateString() : 'N/A';
                
                html += `
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                ${product.imageUrl ? `
                                    <img src="${product.imageUrl}" alt="${product.name}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #e0e0e0;">
                                ` : ''}
                                <strong>${product.name}</strong>
                            </div>
                        </td>
                        <td>${product.brandName}</td>
                        <td>${product.categoryName}</td>
                        <td><strong>${product.availableQuantity}</strong></td>
                        <td>₹${product.buyingPrice.toFixed(2)}</td>
                        <td>₹${product.sellingPrice.toFixed(2)}</td>
                        <td>${expiryDate}</td>
                        <td><span class="status-badge status-${status.class}">${status.text}</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-sm btn-view" onclick="viewProduct('${product.id}')" title="View Details">👁️</button>
                                <button class="btn-sm btn-edit" onclick="editProduct('${product.id}')" title="Edit/Refill Stock">✏️</button>
                                <button class="btn-sm btn-delete" onclick="deleteProduct('${product.id}', '${product.name}')" title="Delete">🗑️</button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        // Get product status
        function getProductStatus(product) {
            const today = new Date();
            const expiryDate = product.expiryDate ? new Date(product.expiryDate.toDate()) : null;
            
            if (expiryDate && expiryDate < today) {
                return { class: 'expired', text: 'EXPIRED' };
            } else if (product.availableQuantity <= 5) {
                return { class: 'low', text: 'LOW STOCK' };
            } else {
                return { class: 'active', text: 'ACTIVE' };
            }
        }

        // Update statistics
        function updateStats() {
            const totalProducts = allProducts.length;
            const totalValue = allProducts.reduce((sum, p) => sum + (p.availableQuantity * p.buyingPrice), 0);
            const lowStock = allProducts.filter(p => p.availableQuantity <= 5).length;

            document.getElementById('totalProducts').textContent = totalProducts;
            document.getElementById('totalValue').textContent = totalValue.toFixed(2);
            document.getElementById('lowStock').textContent = lowStock;
        }

        // Load filter options
        async function loadFilters() {
            const brands = await firebaseDb.collection('brands').orderBy('name').get();
            const brandFilter = document.getElementById('brandFilter');
            brands.forEach(doc => {
                const option = document.createElement('option');
                option.value = doc.id;
                option.textContent = doc.data().name;
                brandFilter.appendChild(option);
            });

            const categories = await firebaseDb.collection('categories').orderBy('name').get();
            const categoryFilter = document.getElementById('categoryFilter');
            categories.forEach(doc => {
                const option = document.createElement('option');
                option.value = doc.id;
                option.textContent = doc.data().name;
                categoryFilter.appendChild(option);
            });
        }

        // Search and filter
        document.getElementById('searchBox').addEventListener('input', filterProducts);
        document.getElementById('brandFilter').addEventListener('change', filterProducts);
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);
        document.getElementById('statusFilter').addEventListener('change', filterProducts);

        function filterProducts() {
            const search = document.getElementById('searchBox').value.toLowerCase();
            const brandId = document.getElementById('brandFilter').value;
            const categoryId = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            let filtered = allProducts.filter(product => {
                const matchesSearch = product.name.toLowerCase().includes(search) || 
                                     product.brandName.toLowerCase().includes(search) ||
                                     product.categoryName.toLowerCase().includes(search);
                const matchesBrand = !brandId || product.brandId === brandId;
                const matchesCategory = !categoryId || product.categoryId === categoryId;
                const status = getProductStatus(product);
                const matchesStatus = !statusFilter || status.class === statusFilter;

                return matchesSearch && matchesBrand && matchesCategory && matchesStatus;
            });

            displayProducts(filtered);
        }

        // View product
        function viewProduct(id) {
            const product = allProducts.find(p => p.id === id);
            if (product) {
                const expiryDate = product.expiryDate ? new Date(product.expiryDate.toDate()).toLocaleDateString() : 'N/A';
                const purchaseDate = product.purchaseDate ? new Date(product.purchaseDate.toDate()).toLocaleDateString() : 'N/A';
                
                alert(`Product Details:\n\n` +
                    `Name: ${product.name}\n` +
                    `Brand: ${product.brandName}\n` +
                    `Category: ${product.categoryName}\n` +
                    `Available: ${product.availableQuantity}\n` +
                    `Sold: ${product.soldQuantity || 0}\n` +
                    `Buying Price: ₹${product.buyingPrice}\n` +
                    `Selling Price: ₹${product.sellingPrice}\n` +
                    `Profit/Unit: ₹${product.profitPerUnit}\n` +
                    `Purchased: ${purchaseDate}\n` +
                    `Expires: ${expiryDate}`
                );
            }
        }

        // Delete product
        async function deleteProduct(id, name) {
            if (!confirm(`Delete "${name}"?\n\nThis action cannot be undone.`)) {
                return;
            }

            try {
                await firebaseDb.collection('products').doc(id).delete();
                alert('✅ Product deleted successfully!');
                loadProducts();
            } catch (error) {
                alert('Error deleting product: ' + error.message);
            }
        }

        // Edit product function
        function editProduct(productId) {
            const product = allProducts.find(p => p.id === productId);
            if (!product) return;
            
            // Show edit modal
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('editProductId').value = productId;
            document.getElementById('editProductName').value = product.name;
            document.getElementById('editCurrentStock').textContent = product.availableQuantity;
            document.getElementById('editBuyingPrice').value = product.buyingPrice;
            document.getElementById('editSellingPrice').value = product.sellingPrice;
            document.getElementById('editExpiryDate').value = product.expiryDate ? 
                new Date(product.expiryDate.toDate()).toISOString().split('T')[0] : '';
        }
        
        // Close edit modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.getElementById('editForm').reset();
        }
        
        // Save edited product
        async function saveEditedProduct(event) {
            event.preventDefault();
            
            const productId = document.getElementById('editProductId').value;
            const addQuantity = parseInt(document.getElementById('editAddQuantity').value) || 0;
            const newBuyingPrice = parseFloat(document.getElementById('editBuyingPrice').value);
            const newSellingPrice = parseFloat(document.getElementById('editSellingPrice').value);
            const newExpiryDate = document.getElementById('editExpiryDate').value;
            const purchaseDate = document.getElementById('editPurchaseDate').value;
            
            if (addQuantity <= 0) {
                alert('Please enter a valid quantity to add');
                return;
            }
            
            try {
                const product = allProducts.find(p => p.id === productId);
                const newAvailableQty = (product.availableQuantity || 0) + addQuantity;
                const newTotalStock = (product.stockQuantity || 0) + addQuantity;
                
                // Update product
                await firebaseDb.collection('products').doc(productId).update({
                    availableQuantity: newAvailableQty,
                    stockQuantity: newTotalStock,
                    buyingPrice: newBuyingPrice,
                    sellingPrice: newSellingPrice,
                    profitPerUnit: newSellingPrice - newBuyingPrice,
                    expiryDate: firebase.firestore.Timestamp.fromDate(new Date(newExpiryDate)),
                    updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                });
                
                // Add to stock history
                await firebaseDb.collection('stockHistory').add({
                    productId: productId,
                    productName: product.name,
                    brandId: product.brandId,
                    brandName: product.brandName,
                    categoryId: product.categoryId,
                    categoryName: product.categoryName,
                    quantityAdded: addQuantity,
                    buyingPrice: newBuyingPrice,
                    sellingPrice: newSellingPrice,
                    totalBuyingCost: addQuantity * newBuyingPrice,
                    totalSellingValue: addQuantity * newSellingPrice,
                    expectedProfit: addQuantity * (newSellingPrice - newBuyingPrice),
                    purchaseDate: firebase.firestore.Timestamp.fromDate(new Date(purchaseDate)),
                    expiryDate: firebase.firestore.Timestamp.fromDate(new Date(newExpiryDate)),
                    refillDate: firebase.firestore.FieldValue.serverTimestamp(),
                    refillBy: firebase.auth().currentUser.uid,
                    refillByName: firebase.auth().currentUser.displayName || firebase.auth().currentUser.email,
                    previousStock: product.availableQuantity || 0,
                    newStock: newAvailableQty
                });
                
                alert('✅ Product updated and stock history recorded!');
                closeEditModal();
                loadProducts();
                
            } catch (error) {
                console.error('Error updating product:', error);
                alert('Error updating product: ' + error.message);
            }
        }

        // Load products on page load
        loadProducts();
    </script>
    
    <!-- Edit Product Modal -->
    <div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 16px; padding: 40px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 50px rgba(0,0,0,0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2 style="margin: 0; color: #2C3E50;">✏️ Edit Product / Refill Stock</h2>
                <button onclick="closeEditModal()" style="background: none; border: none; font-size: 28px; cursor: pointer; color: #7F8C8D;">&times;</button>
            </div>
            
            <form id="editForm" onsubmit="saveEditedProduct(event)">
                <input type="hidden" id="editProductId">
                
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <strong>Product:</strong> <span id="editProductName" style="color: #FF6B35;"></span><br>
                    <strong>Current Stock:</strong> <span id="editCurrentStock" style="color: #27AE60; font-size: 18px; font-weight: 600;"></span> units
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #2C3E50;">Add Quantity *</label>
                        <input type="number" id="editAddQuantity" min="1" required 
                               style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #2C3E50;">Purchase Date *</label>
                        <input type="date" id="editPurchaseDate" required 
                               style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #2C3E50;">Buying Price (₹) *</label>
                        <input type="number" id="editBuyingPrice" step="0.01" min="0" required 
                               style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #2C3E50;">Selling Price (₹) *</label>
                        <input type="number" id="editSellingPrice" step="0.01" min="0" required 
                               style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #2C3E50;">Expiry Date *</label>
                    <input type="date" id="editExpiryDate" required 
                           style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px;">
                </div>
                
                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" style="flex: 1; background: #27AE60; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s;">
                        💾 Save Changes
                    </button>
                    <button type="button" onclick="closeEditModal()" style="flex: 1; background: #7F8C8D; color: white; border: none; padding: 14px; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s;">
                        ❌ Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

