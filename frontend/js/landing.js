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
for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('div');
    dot.className = 'dot';
    if (i === 0) dot.classList.add('active');
    dot.onclick = () => goToSlide(i);
    dotsContainer.appendChild(dot);
}

function showSlide(n) {
    slides.forEach(slide => slide.classList.remove('active'));
    const dots = document.querySelectorAll('.dot');
    dots.forEach(dot => dot.classList.remove('active'));

    currentSlide = (n + totalSlides) % totalSlides;
    
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
}

function changeSlide(direction) {
    showSlide(currentSlide + direction);
}

function goToSlide(n) {
    showSlide(n);
}

// Auto-advance slider
setInterval(() => {
    changeSlide(1);
}, 5000);

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
    try {
        const brandsSnapshot = await firebaseDb.collection('brands').orderBy('name').get();
        const brandsContainer = document.getElementById('brandsContainer');

        if (brandsSnapshot.empty) {
            brandsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px; grid-column: 1/-1;">
                    <div style="font-size: 48px; margin-bottom: 20px;">🏷️</div>
                    <p style="color: #7F8C8D;">No brands available yet</p>
                </div>
            `;
            return;
        }

        let html = '';
        const brandPromises = [];

        brandsSnapshot.forEach(doc => {
            brandPromises.push(getBrandProductCount(doc.id).then(count => ({
                id: doc.id,
                data: doc.data(),
                productCount: count
            })));
        });

        const brandsWithCounts = await Promise.all(brandPromises);

        brandsWithCounts.forEach(brand => {
            html += `
                <div class="brand-card fade-in" onclick="viewBrandProducts('${brand.id}', '${brand.data.name}')">
                    <div class="brand-logo">🏷️</div>
                    <div class="brand-name">${brand.data.name}</div>
                    ${brand.data.description ? `<p style="color: #7F8C8D; font-size: 14px; margin-bottom: 15px;">${brand.data.description}</p>` : ''}
                    <div class="brand-products-count">${brand.productCount} Products Available</div>
                    <button class="brand-view-btn">View Products</button>
                </div>
            `;
        });

        brandsContainer.innerHTML = html;

        // Trigger scroll animations
        observeElements();

    } catch (error) {
        console.error('Error loading brands:', error);
        
        let errorMessage = 'Error loading brands';
        if (error.code === 'permission-denied') {
            errorMessage = 'Please update Firestore security rules to allow public access to brands';
        }
        
        document.getElementById('brandsContainer').innerHTML = `
            <div style="text-align: center; padding: 40px; grid-column: 1/-1; background: white; border-radius: 12px;">
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
    try {
        const reviewsSnapshot = await firebaseDb.collection('reviews')
            .where('status', '==', 'pending')
            .orderBy('createdAt', 'desc')
            .get();
        
        const testimonialsContainer = document.getElementById('testimonialsContainer');

        if (reviewsSnapshot.empty) {
            testimonialsContainer.innerHTML = `
                <div style="text-align: center; padding: 40px; flex: 1;">
                    <div style="font-size: 48px; margin-bottom: 20px;">💬</div>
                    <p style="color: #7F8C8D;">No reviews yet. Be the first to share your experience!</p>
                </div>
            `;
            document.getElementById('testimonialPrevBtn').style.display = 'none';
            document.getElementById('testimonialNextBtn').style.display = 'none';
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
        document.getElementById('testimonialPrevBtn').style.display = showButtons ? 'block' : 'none';
        document.getElementById('testimonialNextBtn').style.display = showButtons ? 'block' : 'none';

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
        
        document.getElementById('testimonialsContainer').innerHTML = `
            <div style="text-align: center; padding: 40px; flex: 1; background: white; border-radius: 12px;">
                <div style="font-size: 48px; margin-bottom: 20px;">⚠️</div>
                <p style="color: #7F8C8D; margin-bottom: 20px;">${errorMessage}</p>
            </div>
        `;
        document.getElementById('testimonialPrevBtn').style.display = 'none';
        document.getElementById('testimonialNextBtn').style.display = 'none';
    }
}

// Update slider on window resize
window.addEventListener('resize', () => {
    const container = document.getElementById('testimonialsContainer');
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

