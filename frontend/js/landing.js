/**
 * Landing Page JavaScript
 * Handles slider, navigation, and dynamic content loading
 */

// Slider functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

// Create dots
const dotsContainer = document.getElementById('sliderDots');
if (dotsContainer && totalSlides > 0) {
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('div');
        dot.className = 'dot';
        if (i === 0) dot.classList.add('active');
        dot.onclick = () => goToSlide(i);
        dotsContainer.appendChild(dot);
    }
}

function showSlide(n) {
    if (slides.length === 0) return;
    
    slides.forEach(slide => slide.classList.remove('active'));
    const dots = document.querySelectorAll('.dot');
    dots.forEach(dot => dot.classList.remove('active'));

    currentSlide = (n + totalSlides) % totalSlides;
    
    if (slides[currentSlide]) slides[currentSlide].classList.add('active');
    if (dots[currentSlide]) dots[currentSlide].classList.add('active');
}

function changeSlide(direction) {
    showSlide(currentSlide + direction);
}

function goToSlide(n) {
    showSlide(n);
}

// Auto-advance slider (only if slides exist)
if (totalSlides > 0) {
    setInterval(() => {
        changeSlide(1);
    }, 5000);
}

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Mobile menu toggle
const navToggle = document.getElementById('navToggle');
const navMenu = document.getElementById('navMenu');

navToggle.addEventListener('click', () => {
    navToggle.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Close mobile menu when clicking a link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        navToggle.classList.remove('active');
        navMenu.classList.remove('active');
    });
});

// Active nav link on scroll
const sections = document.querySelectorAll('section[id]');

window.addEventListener('scroll', () => {
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (window.scrollY >= (sectionTop - 100)) {
            current = section.getAttribute('id');
        }
    });

    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});

// Load brands dynamically from Firebase
async function loadBrands() {
    const brandsContainer = document.getElementById('brandsContainer');
    
    // Only run if brands container exists (i.e., we're on the landing page)
    if (!brandsContainer) return;
    
    try {
        const brandsSnapshot = await firebaseDb.collection('brands').orderBy('name').get();

        if (brandsSnapshot.empty) {
            brandsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px; flex: 1;">
                    <div style="font-size: 48px; margin-bottom: 20px;">🏷️</div>
                    <p style="color: #7F8C8D;">No brands available yet</p>
                </div>
            `;
            return;
        }

        brandsData = [];
        const brandPromises = [];

        brandsSnapshot.forEach(doc => {
            brandPromises.push(getBrandProductCount(doc.id).then(count => ({
                id: doc.id,
                name: doc.data().name,
                description: doc.data().description || 'Premium supplement brand',
                productCount: count
            })));
        });

        brandsData = await Promise.all(brandPromises);
        totalBrands = brandsData.length;
        
        renderBrands();
        updateBrandsPerView();
        
        // Show/hide navigation buttons
        const showButtons = totalBrands > 1;
        const prevBtn = document.getElementById('brandsPrevBtn');
        const nextBtn = document.getElementById('brandsNextBtn');
        if (prevBtn) prevBtn.style.display = showButtons ? 'flex' : 'none';
        if (nextBtn) nextBtn.style.display = showButtons ? 'flex' : 'none';
        
        // Start auto-slide if more than 1 brand
        if (totalBrands > 1) {
            startBrandsAutoSlide();
        }

        // Trigger scroll animations
        observeElements();

    } catch (error) {
        console.error('Error loading brands:', error);
        
        let errorMessage = 'Error loading brands';
        if (error.code === 'permission-denied') {
            errorMessage = 'Please update Firestore security rules to allow public access to brands';
        }
        
        brandsContainer.innerHTML = `
            <div style="text-align: center; padding: 40px; flex: 1; background: white; border-radius: 12px;">
                <div style="font-size: 48px; margin-bottom: 20px;">⚠️</div>
                <h3 style="color: #2C3E50; margin-bottom: 15px;">Firestore Rules Update Required</h3>
                <p style="color: #7F8C8D; margin-bottom: 20px;">${errorMessage}</p>
                <div style="background: #fff3cd; padding: 20px; border-radius: 8px; text-align: left; max-width: 600px; margin: 0 auto;">
                    <p style="color: #856404; margin-bottom: 10px;"><strong>To fix this:</strong></p>
                    <ol style="color: #856404; padding-left: 20px; line-height: 1.8;">
                        <li>Go to <a href="https://console.firebase.google.com/" target="_blank" style="color: #FF6B35;">Firebase Console</a></li>
                        <li>Select project: <strong>protein-planet-9cd02</strong></li>
                        <li>Click <strong>Firestore Database</strong> → <strong>Rules</strong></li>
                        <li>Open file: <strong>FIRESTORE_RULES_UPDATE.md</strong></li>
                        <li>Copy and paste the rules</li>
                        <li>Click <strong>"Publish"</strong></li>
                        <li>Refresh this page</li>
                    </ol>
                </div>
            </div>
        `;
    }
}

// Render brands for slider
function renderBrands() {
    const brandsContainer = document.getElementById('brandsContainer');
    if (!brandsContainer) return;
    
    let html = '';
    
    // Create HTML for original brands
    brandsData.forEach(brand => {
        html += createBrandCard(brand);
    });
    
    // Clone first 3 brands for infinite loop effect
    const cloneCount = Math.min(3, brandsData.length);
    for (let i = 0; i < cloneCount; i++) {
        const brand = brandsData[i];
        html += createBrandCard(brand);
    }
    
    brandsContainer.innerHTML = html;
    
    // Reset slider position
    currentBrandIndex = 0;
    brandsContainer.style.transform = 'translateX(0px)';
}

// Create brand card HTML
function createBrandCard(brand) {
    return `
        <div class="brand-card fade-in" onclick="viewBrandProducts('${brand.id}', '${brand.name}')" title="Click to view ${brand.name} products">
            <div class="brand-logo">🏷️</div>
            <div class="brand-name">${brand.name}</div>
            <p class="brand-description">${brand.description}</p>
            <div class="product-count">${brand.productCount} Products Available</div>
            <div style="margin-top: 15px; color: #FF6B35; font-weight: 600; position: relative; z-index: 1;">
                View Products →
            </div>
        </div>
    `;
}

// Get product count for a brand
async function getBrandProductCount(brandId) {
    try {
        const productsSnapshot = await firebaseDb.collection('products')
            .where('brandId', '==', brandId)
            .where('status', '==', 'active')
            .get();
        return productsSnapshot.size;
    } catch (error) {
        console.error('Error getting product count:', error);
        return 0;
    }
}

// View products by brand
function viewBrandProducts(brandId, brandName) {
    window.location.href = `brand-products.php?brand=${brandId}&name=${encodeURIComponent(brandName)}`;
}

// Scroll animation observer
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

// Testimonials slider variables
let currentTestimonialIndex = 0;
let totalTestimonials = 0;
let testimonialsPerView = 3;
let isTransitioning = false;
let autoSlideInterval = null;

// Update testimonials per view based on screen size
function updateTestimonialsPerView() {
    if (window.innerWidth <= 576) {
        testimonialsPerView = 1;
    } else if (window.innerWidth <= 968) {
        testimonialsPerView = 2;
    } else {
        testimonialsPerView = 3;
    }
}

// Slide testimonials with infinite loop
function slideTestimonials(direction) {
    if (isTransitioning) return;
    
    const container = document.getElementById('testimonialsContainer');
    const cards = container.querySelectorAll('.testimonial-card');
    
    if (cards.length === 0) return;
    
    isTransitioning = true;
    currentTestimonialIndex += direction;
    
    // Calculate the translate value
    const cardWidth = cards[0].offsetWidth + 30; // card width + gap
    const translateX = -(currentTestimonialIndex * cardWidth);
    
    container.style.transition = 'transform 0.5s ease-in-out';
    container.style.transform = `translateX(${translateX}px)`;
    
    // Handle infinite loop
    setTimeout(() => {
        // If we've moved past the original cards, reset to the beginning
        if (currentTestimonialIndex >= totalTestimonials) {
            container.style.transition = 'none';
            currentTestimonialIndex = 0;
            container.style.transform = `translateX(0px)`;
        }
        // If we've moved before the first card, jump to the end
        else if (currentTestimonialIndex < 0) {
            container.style.transition = 'none';
            currentTestimonialIndex = totalTestimonials - 1;
            const resetTranslate = -(currentTestimonialIndex * cardWidth);
            container.style.transform = `translateX(${resetTranslate}px)`;
        }
        
        isTransitioning = false;
    }, 500);
}

// Load reviews dynamically from Firebase
async function loadReviews() {
    const testimonialsContainer = document.getElementById('testimonialsContainer');
    
    // Only run if testimonials container exists (i.e., we're on the landing page)
    if (!testimonialsContainer) return;
    
    try {
        const reviewsSnapshot = await firebaseDb.collection('reviews')
            .where('status', '==', 'pending')
            .orderBy('createdAt', 'desc')
            .get();

        if (reviewsSnapshot.empty) {
            testimonialsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px; flex: 1;">
                    <div style="font-size: 48px; margin-bottom: 20px;">💬</div>
                    <p style="color: #7F8C8D;">No reviews yet. Be the first to share your experience!</p>
                </div>
            `;
            const prevBtn = document.getElementById('testimonialPrevBtn');
            const nextBtn = document.getElementById('testimonialNextBtn');
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }

        totalTestimonials = reviewsSnapshot.size;
        let reviewsArray = [];
        
        reviewsSnapshot.forEach(doc => {
            const review = doc.data();
            const stars = '⭐'.repeat(review.rating);
            const initials = review.customerName
                .split(' ')
                .map(n => n[0])
                .join('')
                .toUpperCase()
                .substring(0, 2);

            reviewsArray.push({
                stars,
                text: review.reviewText,
                name: review.customerName,
                initials
            });
        });

        // Create HTML for original reviews
        let html = '';
        reviewsArray.forEach(review => {
            html += `
                <div class="testimonial-card fade-in">
                    <div class="stars">${review.stars}</div>
                    <p class="testimonial-text">"${review.text}"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">${review.initials}</div>
                        <div>
                            <div class="author-name">${review.name}</div>
                            <div class="author-title">Customer</div>
                        </div>
                    </div>
                </div>
            `;
        });

        // Clone first 3 reviews for infinite loop effect
        const cloneCount = Math.min(3, reviewsArray.length);
        for (let i = 0; i < cloneCount; i++) {
            const review = reviewsArray[i];
            html += `
                <div class="testimonial-card fade-in">
                    <div class="stars">${review.stars}</div>
                    <p class="testimonial-text">"${review.text}"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">${review.initials}</div>
                        <div>
                            <div class="author-name">${review.name}</div>
                            <div class="author-title">Customer</div>
                        </div>
                    </div>
                </div>
            `;
        }

        testimonialsContainer.innerHTML = html;

        // Update slider settings
        updateTestimonialsPerView();
        currentTestimonialIndex = 0;
        testimonialsContainer.style.transform = 'translateX(0px)';

        // Show/hide navigation buttons
        const showButtons = totalTestimonials > 1;
        const prevBtn = document.getElementById('testimonialPrevBtn');
        const nextBtn = document.getElementById('testimonialNextBtn');
        if (prevBtn) prevBtn.style.display = showButtons ? 'block' : 'none';
        if (nextBtn) nextBtn.style.display = showButtons ? 'block' : 'none';

        // Trigger scroll animations
        observeElements();

        // Clear existing interval if any
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }

        // Auto-slide every 4 seconds (only if more than 1 review)
        if (totalTestimonials > 1) {
            autoSlideInterval = setInterval(() => {
                slideTestimonials(1);
            }, 4000);
        }

    } catch (error) {
        console.error('Error loading reviews:', error);
        
        let errorMessage = 'Error loading reviews';
        if (error.code === 'permission-denied') {
            errorMessage = 'Please update Firestore security rules to allow public access to reviews';
        }
        
        if (testimonialsContainer) {
            testimonialsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px; flex: 1; background: white; border-radius: 12px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">⚠️</div>
                    <p style="color: #7F8C8D; margin-bottom: 20px;">${errorMessage}</p>
                </div>
            `;
        }
        const prevBtn = document.getElementById('testimonialPrevBtn');
        const nextBtn = document.getElementById('testimonialNextBtn');
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
    }
}

// Update slider on window resize
window.addEventListener('resize', () => {
    const container = document.getElementById('testimonialsContainer');
    if (!container) return;
    
    const cards = container.querySelectorAll('.testimonial-card');
    
    if (cards.length > 0) {
        updateTestimonialsPerView();
        // Recalculate current position
        const cardWidth = cards[0].offsetWidth + 30;
        const translateX = -(currentTestimonialIndex * cardWidth);
        container.style.transition = 'none';
        container.style.transform = `translateX(${translateX}px)`;
        
        // Re-enable transition after a brief moment
        setTimeout(() => {
            container.style.transition = 'transform 0.5s ease-in-out';
        }, 50);
    }
});

// Load brands and reviews on page load
window.addEventListener('load', () => {
    loadBrands();
    loadReviews();
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

console.log('🎨 Landing page loaded!');



// Brands slider variables
let currentBrandIndex = 0;
let brandsPerView = 3;
let brandsData = [];
let brandsInterval;

// Brands slider variables
let totalBrands = 0;
let isBrandsTransitioning = false;
let brandsAutoSlideInterval = null;

// Update brands per view based on screen size
function updateBrandsPerView() {
    if (window.innerWidth <= 576) {
        brandsPerView = 1;
    } else if (window.innerWidth <= 968) {
        brandsPerView = 2;
    } else {
        brandsPerView = 3;
    }
}

// Slide brands with infinite loop
function slideBrands(direction) {
    if (isBrandsTransitioning) return;
    
    const container = document.getElementById('brandsContainer');
    const cards = container.querySelectorAll('.brand-card');
    
    if (cards.length === 0) return;
    
    isBrandsTransitioning = true;
    currentBrandIndex += direction;
    
    // Calculate the translate value
    const cardWidth = cards[0].offsetWidth + 30; // card width + gap
    const translateX = -(currentBrandIndex * cardWidth);
    
    container.style.transition = 'transform 0.5s ease-in-out';
    container.style.transform = `translateX(${translateX}px)`;
    
    // Handle infinite loop
    setTimeout(() => {
        // If we've moved past the original cards, reset to the beginning
        if (currentBrandIndex >= totalBrands) {
            container.style.transition = 'none';
            currentBrandIndex = 0;
            container.style.transform = `translateX(0px)`;
        }
        // If we've moved before the first card, jump to the end
        else if (currentBrandIndex < 0) {
            container.style.transition = 'none';
            currentBrandIndex = totalBrands - 1;
            const resetTranslate = -(currentBrandIndex * cardWidth);
            container.style.transform = `translateX(${resetTranslate}px)`;
        }
        
        isBrandsTransitioning = false;
    }, 500);
}

// Start auto-slide for brands
function startBrandsAutoSlide() {
    if (brandsAutoSlideInterval) {
        clearInterval(brandsAutoSlideInterval);
    }
    
    if (totalBrands > 1) {
        brandsAutoSlideInterval = setInterval(() => {
            slideBrands(1);
        }, 5000);
    }
}

// Update brands slider on window resize
window.addEventListener('resize', () => {
    const container = document.getElementById('brandsContainer');
    if (!container) return;
    
    const cards = container.querySelectorAll('.brand-card');
    
    if (cards.length > 0) {
        updateBrandsPerView();
        // Recalculate current position
        const cardWidth = cards[0].offsetWidth + 30;
        const translateX = -(currentBrandIndex * cardWidth);
        container.style.transition = 'none';
        container.style.transform = `translateX(${translateX}px)`;
        
        // Re-enable transition after a brief moment
        setTimeout(() => {
            container.style.transition = 'transform 0.5s ease-in-out';
        }, 50);
    }
});
