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
    <script src="js/all-products.js"></script>
</body>
</html>
