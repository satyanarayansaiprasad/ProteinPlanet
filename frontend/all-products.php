<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Protein Planet | Premium Supplements Store in Rourkela</title>
    <meta name="description" content="Browse all premium protein supplements, vitamins, and fitness products at Protein Planet. Quality brands, competitive prices, expert guidance in Rourkela, Odisha.">
    <meta name="keywords" content="protein supplements, whey protein, fitness products, vitamins, Rourkela, Odisha, protein planet, all products">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="All Products - Protein Planet | Premium Supplements Store">
    <meta property="og:description" content="Browse all premium protein supplements, vitamins, and fitness products at Protein Planet. Quality brands, competitive prices, expert guidance.">
    <meta property="og:image" content="https://proteinplanet.onrender.com/img/logo.png">
    <meta property="og:url" content="https://proteinplanet.onrender.com/all-products.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Protein Planet">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="All Products - Protein Planet | Premium Supplements Store">
    <meta name="twitter:description" content="Browse all premium protein supplements, vitamins, and fitness products at Protein Planet. Quality brands, competitive prices, expert guidance.">
    <meta name="twitter:image" content="https://proteinplanet.onrender.com/img/logo.png">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="css/all-products.css">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "CollectionPage",
        "name": "All Products - Protein Planet",
        "description": "Browse all premium protein supplements, vitamins, and fitness products at Protein Planet",
        "url": "https://proteinplanet.onrender.com/all-products.php",
        "mainEntity": {
            "@type": "ItemList",
            "name": "Protein Planet Products"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Protein Planet",
            "url": "https://proteinplanet.onrender.com"
        }
    }
    </script>
</head>
<body>
    <?php include 'includes/public-header.php'; ?>

    <!-- Header Section -->
    <section class="products-header">
        <div class="container">
            <div class="header-content">
                <h1 class="page-title">All Products</h1>
                <p class="page-subtitle">Discover our complete range of premium supplements</p>
                
                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="Search products...">
                        <button onclick="searchProducts()">🔍</button>
                    </div>
                    
                    <div class="filter-dropdowns">
                        <select id="brandFilter" onchange="filterProducts()">
                            <option value="">All Brands</option>
                        </select>
                        
                        <select id="categoryFilter" onchange="filterProducts()">
                            <option value="">All Categories</option>
                        </select>
                        
                        <select id="sortBy" onchange="sortProducts()">
                            <option value="name">Sort by Name</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <div class="container">
            <div class="products-stats">
                <div class="stat-item">
                    <span class="stat-number" id="totalProducts">0</span>
                    <span class="stat-label">Total Products</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" id="displayedProducts">0</span>
                    <span class="stat-label">Showing</span>
                </div>
            </div>
            
            <div id="productsGrid" class="products-grid">
                <!-- Loading spinner -->
                <div class="loading-spinner">
                    <div class="spinner"></div>
                    <p>Loading products...</p>
                    <button onclick="window.loadProducts()" style="margin-top: 20px; padding: 10px 20px; background: #FF6B35; color: white; border: none; border-radius: 8px; cursor: pointer;">
                        🔄 Retry Loading
                    </button>
                </div>
            </div>
            
            <!-- Load More Button -->
            <div class="load-more-container">
                <button id="loadMoreBtn" class="load-more-btn" onclick="loadMoreProducts()" style="display: none;">
                    Load More Products
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <h2>Need Help Choosing?</h2>
                <p>Our experts are here to help you find the perfect supplements for your fitness goals.</p>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon">📞</span>
                        <span>+91 7008362528</span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <span>Shop number 107, RCMS complex, Civil Township, Rourkela, Odisha 769012</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/public-footer.php'; ?>

    <!-- Firebase Configuration -->
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config-public.js"></script>
    
    <!-- JavaScript -->
    <script>
        // Contact function
        function contactForProduct(productName, brandName, price) {
            const message = `Hi! I'm interested in ${productName} from ${brandName} (₹${price}). Could you please provide more details?`;
            const whatsappUrl = `https://wa.me/917008362528?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }
        
        // Immediate test - bypass everything
        console.log('=== DIRECT TEST ===');
        console.log('Page loaded at:', new Date());
        console.log('Firebase:', typeof firebase !== 'undefined' ? 'Loaded' : 'NOT LOADED');
        console.log('firebaseDb:', typeof window.firebaseDb !== 'undefined' ? 'Available' : 'NOT AVAILABLE');
        
        // Direct Firebase test
        setTimeout(async () => {
            console.log('=== STARTING DIRECT FIREBASE TEST ===');
            try {
                if (window.firebaseDb) {
                    const snapshot = await window.firebaseDb.collection('products').get();
                    console.log('✅ TOTAL PRODUCTS IN DATABASE:', snapshot.size);
                    
                    if (snapshot.size > 0) {
                        console.log('📦 PRODUCTS:');
                        snapshot.forEach(doc => {
                            const data = doc.data();
                            console.log(`- ${doc.id}:`, data.name, `(status: ${data.status})`);
                        });
                        
                        // Now try with status filter
                        const activeSnapshot = await window.firebaseDb.collection('products').where('status', '==', 'active').get();
                        console.log('✅ ACTIVE PRODUCTS:', activeSnapshot.size);
                        
                        // Render test
                        const container = document.getElementById('productsGrid');
                        if (activeSnapshot.size > 0) {
                            let html = '';
                            activeSnapshot.forEach(doc => {
                                const p = doc.data();
                                const availableQty = p.availableQuantity || p.stockQuantity || 0;
                                const stockStatus = availableQty <= 0 ? 'Out of Stock' : availableQty <= 10 ? 'Low Stock' : 'In Stock';
                                const stockColor = availableQty <= 0 ? '#E74C3C' : availableQty <= 10 ? '#F39C12' : '#27AE60';
                                
                                html += `
                                    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <h3 style="color: #FF6B35; margin: 0 0 10px 0;">${p.name || 'No name'}</h3>
                                        <p style="margin: 5px 0; color: #666;">📦 ${p.brandName || p.brandId || 'Unknown'}</p>
                                        <p style="margin: 5px 0; font-size: 18px; font-weight: 600; color: #27AE60;">₹${p.sellingPrice || p.price || 'N/A'}</p>
                                        <p style="margin: 5px 0; color: ${stockColor}; font-weight: 500;">
                                            📊 ${stockStatus} (${availableQty} units available)
                                        </p>
                                        <button onclick="contactForProduct('${(p.name || '').replace(/'/g, "\\'")}', '${(p.brandName || 'Unknown').replace(/'/g, "\\'")}', '${p.sellingPrice || p.price || 'N/A'}')" 
                                                onmouseover="this.style.background='#E55A2B'; this.style.transform='translateY(-2px)'" 
                                                onmouseout="this.style.background='#FF6B35'; this.style.transform='translateY(0)'"
                                                style="margin-top: 15px; width: 100%; background: #FF6B35; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; transition: all 0.3s ease;">
                                            💬 Contact to Purchase
                                        </button>
                                    </div>
                                `;
                            });
                            container.innerHTML = html;
                            console.log('✅ RENDERED PRODUCTS TO DOM');
                        } else {
                            container.innerHTML = '<div style="text-align: center; padding: 40px;"><h2>No active products found</h2></div>';
                        }
                    } else {
                        document.getElementById('productsGrid').innerHTML = '<div style="text-align: center; padding: 40px;"><h2>⚠️ Database is empty!</h2><p>No products found in Firestore</p></div>';
                    }
                } else {
                    console.error('❌ firebaseDb NOT AVAILABLE');
                    document.getElementById('productsGrid').innerHTML = '<div style="text-align: center; padding: 40px;"><h2>❌ Firebase Error</h2><p>firebaseDb is not initialized</p></div>';
                }
            } catch (error) {
                console.error('❌ ERROR:', error);
                document.getElementById('productsGrid').innerHTML = `<div style="text-align: center; padding: 40px;"><h2>❌ Error</h2><p>${error.message}</p></div>`;
            }
        }, 1000);
    </script>
    <script src="js/all-products.js"></script>
</body>
</html>
