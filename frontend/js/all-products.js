/**
 * All Products Page JavaScript
 * Handles product loading, filtering, and search functionality
 */

// Global variables
let allProducts = [];
let filteredProducts = [];
let currentPage = 1;
let productsPerPage = 12;
let isLoading = false;

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    loadFilters();
    
    // Add event listeners
    document.getElementById('searchInput').addEventListener('input', debounce(searchProducts, 300));
    
    // Add scroll listener for infinite loading
    window.addEventListener('scroll', handleScroll);
    
    // Mobile menu toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
    
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
});

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Load all products from Firebase
async function loadProducts() {
    try {
        isLoading = true;
        showLoadingSpinner();
        
        console.log('Loading products from Firebase...');
        
        // Try with ordering first, fallback to simple query if index doesn't exist
        let productsSnapshot;
        try {
            productsSnapshot = await firebaseDb.collection('products')
                .where('status', '==', 'active')
                .orderBy('name')
                .get();
        } catch (indexError) {
            console.log('Index not available, loading without ordering:', indexError);
            productsSnapshot = await firebaseDb.collection('products')
                .where('status', '==', 'active')
                .get();
        }
        
        console.log('Products snapshot size:', productsSnapshot.size);
        
        allProducts = [];
        productsSnapshot.forEach(doc => {
            const product = doc.data();
            allProducts.push({
                id: doc.id,
                ...product
            });
        });
        
        console.log('All products loaded:', allProducts.length);
        
        // Get brand and category names
        await enrichProductsWithNames();
        
        filteredProducts = [...allProducts];
        
        console.log('Rendering products...');
        renderProducts();
        updateStats();
        
        // Show/hide load more button
        updateLoadMoreButton();
        
    } catch (error) {
        console.error('Error loading products:', error);
        showError(`Failed to load products: ${error.message}`);
    } finally {
        isLoading = false;
    }
}

// Enrich products with brand and category names
async function enrichProductsWithNames() {
    try {
        // Get all unique brand IDs and category IDs
        const brandIds = [...new Set(allProducts.map(p => p.brandId).filter(Boolean))];
        const categoryIds = [...new Set(allProducts.map(p => p.categoryId).filter(Boolean))];
        
        // Fetch brand names
        const brandPromises = brandIds.map(id => 
            firebaseDb.collection('brands').doc(id).get().then(doc => ({
                id,
                name: doc.exists ? doc.data().name : 'Unknown Brand'
            }))
        );
        
        // Fetch category names
        const categoryPromises = categoryIds.map(id => 
            firebaseDb.collection('categories').doc(id).get().then(doc => ({
                id,
                name: doc.exists ? doc.data().name : 'Unknown Category'
            }))
        );
        
        const brands = await Promise.all(brandPromises);
        const categories = await Promise.all(categoryPromises);
        
        // Create lookup objects
        const brandLookup = {};
        const categoryLookup = {};
        
        brands.forEach(brand => {
            brandLookup[brand.id] = brand.name;
        });
        
        categories.forEach(category => {
            categoryLookup[category.id] = category.name;
        });
        
        // Enrich products
        allProducts.forEach(product => {
            product.brandName = product.brandId ? brandLookup[product.brandId] : 'Unknown Brand';
            product.categoryName = product.categoryId ? categoryLookup[product.categoryId] : 'Unknown Category';
        });
        
    } catch (error) {
        console.error('Error enriching products:', error);
        // Set fallback names
        allProducts.forEach(product => {
            product.brandName = product.brandName || 'Unknown Brand';
            product.categoryName = product.categoryName || 'Unknown Category';
        });
    }
}

// Load filter options
async function loadFilters() {
    try {
        // Load brands
        const brandsSnapshot = await firebaseDb.collection('brands').orderBy('name').get();
        const brandFilter = document.getElementById('brandFilter');
        
        brandsSnapshot.forEach(doc => {
            const brand = doc.data();
            const option = document.createElement('option');
            option.value = doc.id;
            option.textContent = brand.name;
            brandFilter.appendChild(option);
        });
        
        // Load categories
        const categoriesSnapshot = await firebaseDb.collection('categories').orderBy('name').get();
        const categoryFilter = document.getElementById('categoryFilter');
        
        categoriesSnapshot.forEach(doc => {
            const category = doc.data();
            const option = document.createElement('option');
            option.value = doc.id;
            option.textContent = category.name;
            categoryFilter.appendChild(option);
        });
        
    } catch (error) {
        console.error('Error loading filters:', error);
    }
}

// Render products
function renderProducts() {
    const container = document.getElementById('productsGrid');
    const startIndex = 0;
    const endIndex = currentPage * productsPerPage;
    const productsToShow = filteredProducts.slice(startIndex, endIndex);
    
    if (productsToShow.length === 0) {
        showNoResults();
        return;
    }
    
    let html = '';
    productsToShow.forEach(product => {
        html += createProductCard(product);
    });
    
    container.innerHTML = html;
}

// Create product card HTML
function createProductCard(product) {
    const stockStatus = getStockStatus(product.stockQuantity);
    const stockClass = getStockClass(product.stockQuantity);
    const price = product.sellingPrice || product.price || 0;
    const brandName = product.brandName || 'Unknown Brand';
    const categoryName = product.categoryName || 'Uncategorized';
    
    return `
        <div class="product-card fade-in" data-product-id="${product.id}">
            <div class="product-image">
                <span>💊</span>
            </div>
            <div class="product-info">
                <div class="product-brand">${brandName}</div>
                <div class="product-name">${product.name || 'Unnamed Product'}</div>
                <div class="product-category">📦 ${categoryName}</div>
                <div class="product-price">₹${price}</div>
                <div class="product-stock ${stockClass}">
                    📊 ${stockStatus} (${product.stockQuantity || 0} units)
                </div>
                <div class="product-actions">
                    <button class="btn-primary" onclick="contactForProduct('${product.name}', '${brandName}')">
                        💬 Contact to Buy
                    </button>
                </div>
            </div>
        </div>
    `;
}

// Get stock status text
function getStockStatus(quantity) {
    if (!quantity || quantity <= 0) return 'Out of Stock';
    if (quantity <= 10) return 'Low Stock';
    if (quantity <= 50) return 'Medium Stock';
    return 'In Stock';
}

// Get stock status class
function getStockClass(quantity) {
    if (!quantity || quantity <= 0) return 'stock-low';
    if (quantity <= 10) return 'stock-low';
    if (quantity <= 50) return 'stock-medium';
    return 'stock-high';
}

// Search products
function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    
    if (!searchTerm) {
        filteredProducts = [...allProducts];
    } else {
        filteredProducts = allProducts.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.brandName.toLowerCase().includes(searchTerm) ||
            product.categoryName.toLowerCase().includes(searchTerm) ||
            (product.description && product.description.toLowerCase().includes(searchTerm))
        );
    }
    
    currentPage = 1;
    renderProducts();
    updateStats();
    updateLoadMoreButton();
}

// Filter products
function filterProducts() {
    const brandFilter = document.getElementById('brandFilter').value;
    const categoryFilter = document.getElementById('categoryFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    
    filteredProducts = allProducts.filter(product => {
        let matches = true;
        
        if (brandFilter && product.brandId !== brandFilter) {
            matches = false;
        }
        
        if (categoryFilter && product.categoryId !== categoryFilter) {
            matches = false;
        }
        
        if (searchTerm && !(
            product.name.toLowerCase().includes(searchTerm) ||
            product.brandName.toLowerCase().includes(searchTerm) ||
            product.categoryName.toLowerCase().includes(searchTerm) ||
            (product.description && product.description.toLowerCase().includes(searchTerm))
        )) {
            matches = false;
        }
        
        return matches;
    });
    
    currentPage = 1;
    renderProducts();
    updateStats();
    updateLoadMoreButton();
}

// Sort products
function sortProducts() {
    const sortBy = document.getElementById('sortBy').value;
    
    switch (sortBy) {
        case 'name':
            filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'price-low':
            filteredProducts.sort((a, b) => (a.sellingPrice || a.price || 0) - (b.sellingPrice || b.price || 0));
            break;
        case 'price-high':
            filteredProducts.sort((a, b) => (b.sellingPrice || b.price || 0) - (a.sellingPrice || a.price || 0));
            break;
    }
    
    currentPage = 1;
    renderProducts();
    updateLoadMoreButton();
}

// Load more products
function loadMoreProducts() {
    if (isLoading) return;
    
    const startIndex = currentPage * productsPerPage;
    const endIndex = (currentPage + 1) * productsPerPage;
    
    if (endIndex >= filteredProducts.length) {
        document.getElementById('loadMoreBtn').style.display = 'none';
        return;
    }
    
    currentPage++;
    
    const container = document.getElementById('productsGrid');
    const productsToShow = filteredProducts.slice(startIndex, endIndex);
    
    let html = '';
    productsToShow.forEach(product => {
        html += createProductCard(product);
    });
    
    container.insertAdjacentHTML('beforeend', html);
    updateStats();
    updateLoadMoreButton();
}

// Handle scroll for infinite loading
function handleScroll() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1000) {
        loadMoreProducts();
    }
}

// Update statistics
function updateStats() {
    document.getElementById('totalProducts').textContent = allProducts.length;
    document.getElementById('displayedProducts').textContent = Math.min(currentPage * productsPerPage, filteredProducts.length);
}

// Update load more button visibility
function updateLoadMoreButton() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const hasMore = (currentPage * productsPerPage) < filteredProducts.length;
    loadMoreBtn.style.display = hasMore ? 'block' : 'none';
}

// Show loading spinner
function showLoadingSpinner() {
    const container = document.getElementById('productsGrid');
    container.innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Loading products...</p>
        </div>
    `;
}

// Hide loading spinner
function hideLoadingSpinner() {
    // Spinner will be replaced by renderProducts()
}

// Show no results
function showNoResults() {
    const container = document.getElementById('productsGrid');
    container.innerHTML = `
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h3>No Products Found</h3>
            <p>Try adjusting your search criteria or filters.</p>
            <button class="btn-primary" onclick="clearFilters()">Clear Filters</button>
        </div>
    `;
}

// Show error message
function showError(message) {
    const container = document.getElementById('productsGrid');
    container.innerHTML = `
        <div class="no-results">
            <div class="no-results-icon">❌</div>
            <h3>Error</h3>
            <p>${message}</p>
            <button class="btn-primary" onclick="loadProducts()">Try Again</button>
        </div>
    `;
}

// Clear all filters
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('brandFilter').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('sortBy').value = 'name';
    
    filteredProducts = [...allProducts];
    currentPage = 1;
    renderProducts();
    updateStats();
    updateLoadMoreButton();
}

// Contact for specific product
function contactForProduct(productName, brandName) {
    const message = `Hi! I'm interested in ${productName} from ${brandName}. Could you please provide more details?`;
    const whatsappUrl = `https://wa.me/917008362528?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// Initialize scroll animations
function observeElements() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
}

// Initialize on page load
window.addEventListener('load', () => {
    observeElements();
});

console.log('🛍️ All Products page loaded!');
