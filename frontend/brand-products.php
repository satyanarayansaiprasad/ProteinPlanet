<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Products - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        /* Simple Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 700;
            color: #FF6B35;
            cursor: pointer;
        }

        .back-btn {
            background: #7f8c8d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .back-btn:hover {
            background: #6c7a7b;
        }

        /* Page Content */
        .page-header {
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .page-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 18px;
            opacity: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .product-name {
            font-size: 20px;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 10px;
        }

        .product-category {
            font-size: 13px;
            color: #7F8C8D;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 32px;
            font-weight: 700;
            color: #27ae60;
            margin-bottom: 15px;
        }

        .product-stock {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .stock-available {
            background: #d4edda;
            color: #155724;
        }

        .stock-low {
            background: #fff3cd;
            color: #856404;
        }

        .stock-out {
            background: #f8d7da;
            color: #721c24;
        }

        .product-description {
            color: #7F8C8D;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .contact-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            grid-column: 1/-1;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 32px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo" onclick="window.location.href='index.php'">
                <span style="font-size: 32px;">🏋️</span>
                <span>Protein Planet</span>
            </div>
            <a href="index.php" class="back-btn">← Back to Home</a>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title" id="brandName">Loading...</h1>
        <p class="page-subtitle" id="productCount">Explore our products</p>
    </div>

    <!-- Products Container -->
    <div class="container">
        <div id="productsContainer" class="products-grid">
            <div class="empty-state">
                <div style="font-size: 64px; margin-bottom: 20px;">🔄</div>
                <p style="color: #7F8C8D; font-size: 18px;">Loading products...</p>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config-public.js"></script>

    <script>
        // Get brand ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const brandId = urlParams.get('brand');
        const brandName = urlParams.get('name');

        // Set brand name
        if (brandName) {
            document.getElementById('brandName').textContent = brandName;
        }

        // Load products for this brand
        async function loadBrandProducts() {
            if (!brandId) {
                window.location.href = 'index.php#brands';
                return;
            }

            try {
                const productsSnapshot = await firebaseDb.collection('products')
                    .where('brandId', '==', brandId)
                    .where('status', '==', 'active')
                    .get();

                const container = document.getElementById('productsContainer');

                if (productsSnapshot.empty) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <div style="font-size: 64px; margin-bottom: 20px;">📦</div>
                            <h3 style="color: #2C3E50; margin-bottom: 10px;">No Products Available</h3>
                            <p style="color: #7F8C8D;">This brand currently has no products in stock</p>
                            <button onclick="window.location.href='index.php#brands'" 
                                    style="margin-top: 20px; padding: 12px 24px; background: #FF6B35; color: white; border: none; border-radius: 25px; cursor: pointer; font-weight: 600;">
                                Browse Other Brands
                            </button>
                        </div>
                    `;
                    return;
                }

                // Update product count
                document.getElementById('productCount').textContent = `${productsSnapshot.size} Products Available`;

                let html = '';
                productsSnapshot.forEach(doc => {
                    const product = doc.data();
                    const stockStatus = getStockStatus(product.availableQuantity);
                    
                    html += `
                        <div class="product-card">
                            <div class="product-name">${product.name}</div>
                            <div class="product-category">${product.categoryName}</div>
                            <div class="product-price">₹${product.sellingPrice.toFixed(2)}</div>
                            <div class="product-stock stock-${stockStatus.class}">${stockStatus.text}</div>
                            ${product.description ? `<p class="product-description">${product.description}</p>` : ''}
                            <button class="contact-btn" onclick="contactForProduct('${product.name}', '${product.sellingPrice}')">
                                Contact to Buy
                            </button>
                        </div>
                    `;
                });

                container.innerHTML = html;

            } catch (error) {
                console.error('Error loading products:', error);
                document.getElementById('productsContainer').innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 64px; margin-bottom: 20px;">❌</div>
                        <p style="color: #e74c3c;">Error loading products</p>
                    </div>
                `;
            }
        }

        function getStockStatus(quantity) {
            if (quantity === 0) return { class: 'out', text: 'Out of Stock' };
            if (quantity <= 5) return { class: 'low', text: 'Low Stock - Hurry!' };
            return { class: 'available', text: 'In Stock' };
        }

        function contactForProduct(productName, price) {
            const message = `Hi! I'm interested in ${productName} (₹${price}). Is it available?`;
            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/917008362528?text=${encodedMessage}`;
            window.open(whatsappUrl, '_blank');
        }

        // Load products on page load
        loadBrandProducts();
    </script>
</body>
</html>

