<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products & Prices - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .page-header {
            margin-bottom: 30px;
        }
        .search-filter {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
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
            border-color: #004E89;
        }
        .filter-select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 8px;
        }
        .product-meta {
            font-size: 13px;
            color: #7F8C8D;
            margin-bottom: 15px;
        }
        .product-price {
            font-size: 28px;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 10px;
        }
        .product-stock {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .stock-good { background: #d4edda; color: #155724; }
        .stock-low { background: #fff3cd; color: #856404; }
        .stock-out { background: #f8d7da; color: #721c24; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7F8C8D;
            background: white;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <?php include 'includes/staff-header.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">📦 Products & Prices</h1>
            <p style="color: #7F8C8D;">View all products and their selling prices</p>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter">
            <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search products...">
            <select class="filter-select" id="brandFilter">
                <option value="">All Brands</option>
            </select>
            <select class="filter-select" id="categoryFilter">
                <option value="">All Categories</option>
            </select>
            <select class="filter-select" id="stockFilter">
                <option value="">All Stock</option>
                <option value="available">Available</option>
                <option value="low">Low Stock</option>
            </select>
        </div>

        <div id="productsContainer" class="products-grid">
            <div class="empty-state">
                <div style="font-size: 64px;">🔄</div>
                <p>Loading products...</p>
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
        let allProducts = [];

        async function loadProducts() {
            try {
                const snapshot = await firebaseDb.collection('products').where('status', '==', 'active').get();
                allProducts = [];

                snapshot.forEach(doc => {
                    allProducts.push({ id: doc.id, ...doc.data() });
                });

                displayProducts(allProducts);
                loadFilters();

            } catch (error) {
                console.error('Error loading products:', error);
                document.getElementById('productsContainer').innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 64px;">❌</div>
                        <p>Error loading products</p>
                    </div>
                `;
            }
        }

        function displayProducts(products) {
            const container = document.getElementById('productsContainer');
            
            if (products.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 64px;">📦</div>
                        <h3>No Products Found</h3>
                        <p>No products match your search criteria</p>
                    </div>
                `;
                return;
            }

            let html = '';
            products.forEach(product => {
                const stockStatus = getStockStatus(product.availableQuantity);
                const expiryDate = product.expiryDate ? new Date(product.expiryDate.toDate()).toLocaleDateString() : 'N/A';
                
                html += `
                    <div class="product-card">
                        <div class="product-name">${product.name}</div>
                        <div class="product-meta">${product.brandName} | ${product.categoryName}</div>
                        <div class="product-price">₹${product.sellingPrice.toFixed(2)}</div>
                        <div style="margin-bottom: 10px;">
                            <span class="product-stock stock-${stockStatus.class}">
                                Stock: ${product.availableQuantity}
                            </span>
                        </div>
                        <div style="font-size: 13px; color: #7F8C8D;">
                            <div>Expires: ${expiryDate}</div>
                            ${product.barcode ? `<div>SKU: ${product.barcode}</div>` : ''}
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function getStockStatus(quantity) {
            if (quantity === 0) return { class: 'out', text: 'Out of Stock' };
            if (quantity <= 5) return { class: 'low', text: 'Low Stock' };
            return { class: 'good', text: 'In Stock' };
        }

        async function loadFilters() {
            // Load brands
            const brands = await firebaseDb.collection('brands').orderBy('name').get();
            const brandFilter = document.getElementById('brandFilter');
            brands.forEach(doc => {
                const option = document.createElement('option');
                option.value = doc.id;
                option.textContent = doc.data().name;
                brandFilter.appendChild(option);
            });

            // Load categories
            const categories = await firebaseDb.collection('categories').orderBy('name').get();
            const categoryFilter = document.getElementById('categoryFilter');
            categories.forEach(doc => {
                const option = document.createElement('option');
                option.value = doc.id;
                option.textContent = doc.data().name;
                categoryFilter.appendChild(option);
            });
        }

        // Filter functionality
        document.getElementById('searchBox').addEventListener('input', applyFilters);
        document.getElementById('brandFilter').addEventListener('change', applyFilters);
        document.getElementById('categoryFilter').addEventListener('change', applyFilters);
        document.getElementById('stockFilter').addEventListener('change', applyFilters);

        function applyFilters() {
            const search = document.getElementById('searchBox').value.toLowerCase();
            const brandId = document.getElementById('brandFilter').value;
            const categoryId = document.getElementById('categoryFilter').value;
            const stockFilter = document.getElementById('stockFilter').value;

            const filtered = allProducts.filter(product => {
                const matchesSearch = product.name.toLowerCase().includes(search) || 
                                     product.brandName.toLowerCase().includes(search) ||
                                     product.categoryName.toLowerCase().includes(search);
                const matchesBrand = !brandId || product.brandId === brandId;
                const matchesCategory = !categoryId || product.categoryId === categoryId;
                
                let matchesStock = true;
                if (stockFilter === 'available') {
                    matchesStock = product.availableQuantity > 5;
                } else if (stockFilter === 'low') {
                    matchesStock = product.availableQuantity > 0 && product.availableQuantity <= 5;
                }

                return matchesSearch && matchesBrand && matchesCategory && matchesStock;
            });

            displayProducts(filtered);
        }

        loadProducts();
    </script>
</body>
</html>

