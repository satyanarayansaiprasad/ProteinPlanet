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
        // Global variables
        let allProducts = [];
        let allBrands = [];
        let allCategories = [];
        
        // Contact function
        function contactForProduct(productName, brandName, price) {
            const message = `Hi! I'm interested in ${productName} from ${brandName} (₹${price}). Could you please provide more details?`;
            const whatsappUrl = `https://wa.me/917008362528?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }
        
        // Search function
        function searchProducts() {
            filterAndRenderProducts();
        }
        
        // Filter function
        function filterProducts() {
            filterAndRenderProducts();
        }
        
        // Sort function
        function sortProducts() {
            filterAndRenderProducts();
        }
        
        // Filter and render products
        function filterAndRenderProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const brandFilter = document.getElementById('brandFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            const sortBy = document.getElementById('sortBy').value;
            
            let filtered = [...allProducts];
            
            // Apply search
            if (searchTerm) {
                filtered = filtered.filter(p => 
                    (p.name || '').toLowerCase().includes(searchTerm) ||
                    (p.brandName || '').toLowerCase().includes(searchTerm)
                );
            }
            
            // Apply brand filter
            if (brandFilter) {
                filtered = filtered.filter(p => p.brandId === brandFilter);
            }
            
            // Apply category filter
            if (categoryFilter) {
                filtered = filtered.filter(p => p.categoryId === categoryFilter);
            }
            
            // Apply sorting
            if (sortBy === 'price-low') {
                filtered.sort((a, b) => (a.sellingPrice || a.price || 0) - (b.sellingPrice || b.price || 0));
            } else if (sortBy === 'price-high') {
                filtered.sort((a, b) => (b.sellingPrice || b.price || 0) - (a.sellingPrice || a.price || 0));
            } else {
                filtered.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
            }
            
            // Render filtered products
            renderProducts(filtered);
        }
        
        // Render products
        function renderProducts(products) {
            const container = document.getElementById('productsGrid');
            
            if (products.length === 0) {
                container.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;"><h2>No products found</h2><p>Try adjusting your search or filters</p></div>';
                return;
            }
            
            let html = '';
            products.forEach(p => {
                const availableQty = p.availableQuantity || p.stockQuantity || 0;
                const stockStatus = availableQty <= 0 ? 'Out of Stock' : availableQty <= 10 ? 'Low Stock' : 'In Stock';
                const stockColor = availableQty <= 0 ? '#E74C3C' : availableQty <= 10 ? '#F39C12' : '#27AE60';
                const stockBg = availableQty <= 0 ? '#FADBD8' : availableQty <= 10 ? '#FCF3CF' : '#D5F4E6';
                
                html += `
                    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #f0f0f0;"
                         onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.08)'">
                        
                        <div style="background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%); height: 180px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <div style="font-size: 72px; filter: brightness(0) invert(1); opacity: 0.9;">💊</div>
                            <div style="position: absolute; top: 15px; right: 15px; background: ${stockBg}; color: ${stockColor}; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; backdrop-filter: blur(10px);">
                                ${stockStatus}
                            </div>
                        </div>
                        
                        <div style="padding: 25px;">
                            <div style="background: #FFF4ED; color: #FF6B35; padding: 6px 12px; border-radius: 6px; display: inline-block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                                ${p.brandName || p.brandId || 'Unknown Brand'}
                            </div>
                            
                            <h3 style="color: #2C3E50; margin: 0 0 15px 0; font-size: 1.2rem; font-weight: 700; line-height: 1.4; min-height: 50px;">
                                ${p.name || 'Product Name'}
                            </h3>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding: 15px; background: #F8F9FA; border-radius: 10px;">
                                <div>
                                    <div style="font-size: 12px; color: #7F8C8D; margin-bottom: 4px;">Price</div>
                                    <div style="font-size: 24px; font-weight: 700; color: #27AE60;">₹${p.sellingPrice || p.price || 'N/A'}</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 12px; color: #7F8C8D; margin-bottom: 4px;">Available</div>
                                    <div style="font-size: 18px; font-weight: 600; color: ${stockColor};">${availableQty} units</div>
                                </div>
                            </div>
                            
                            <button onclick="contactForProduct('${(p.name || '').replace(/'/g, "\\'")}', '${(p.brandName || 'Unknown').replace(/'/g, "\\'")}', '${p.sellingPrice || p.price || 'N/A'}')" 
                                    onmouseover="this.style.background='#E55A2B'; this.style.boxShadow='0 8px 20px rgba(255,107,53,0.4)'" 
                                    onmouseout="this.style.background='#FF6B35'; this.style.boxShadow='0 4px 15px rgba(255,107,53,0.3)'"
                                    style="width: 100%; background: #FF6B35; color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 15px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255,107,53,0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <span style="font-size: 18px;">💬</span>
                                <span>Contact to Purchase</span>
                            </button>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
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
                        
                        // Load active products
                        const activeSnapshot = await window.firebaseDb.collection('products').where('status', '==', 'active').get();
                        console.log('✅ ACTIVE PRODUCTS:', activeSnapshot.size);
                        
                        // Store products globally for filtering
                        allProducts = [];
                        activeSnapshot.forEach(doc => {
                            allProducts.push({
                                id: doc.id,
                                ...doc.data()
                            });
                        });
                        
                        // Load brands and categories for filters
                        const brandsSnapshot = await window.firebaseDb.collection('brands').get();
                        const categoriesSnapshot = await window.firebaseDb.collection('categories').get();
                        
                        // Populate brand filter
                        const brandFilter = document.getElementById('brandFilter');
                        brandsSnapshot.forEach(doc => {
                            const brand = doc.data();
                            const option = document.createElement('option');
                            option.value = doc.id;
                            option.textContent = brand.name;
                            brandFilter.appendChild(option);
                        });
                        
                        // Populate category filter
                        const categoryFilter = document.getElementById('categoryFilter');
                        categoriesSnapshot.forEach(doc => {
                            const category = doc.data();
                            const option = document.createElement('option');
                            option.value = doc.id;
                            option.textContent = category.name;
                            categoryFilter.appendChild(option);
                        });
                        
                        // Add search listener
                        document.getElementById('searchInput').addEventListener('input', filterAndRenderProducts);
                        
                        // Render products
                        if (activeSnapshot.size > 0) {
                            renderProducts(allProducts);
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
