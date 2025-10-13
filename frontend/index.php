<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protein Planet - Your Fitness Partner</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/landing.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <span class="logo-icon">🏋️</span>
                <span class="logo-text">Protein Planet</span>
            </div>
            <div class="nav-menu" id="navMenu">
                <a href="#home" class="nav-link active">Home</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#brands" class="nav-link">Brands</a>
                <a href="#testimonials" class="nav-link">Testimonials</a>
                <a href="#certificates" class="nav-link">Certificates</a>
                <a href="submit-review.php" class="nav-link" style="color: #FF6B35; font-weight: 600;">📝 Review</a>
                <a href="login.php" class="nav-login-btn">Login</a>
            </div>
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Slider -->
    <section id="home" class="hero-section">
        <div class="slider-container">
            <div class="slide active" style="background-image: url('img/slider/1.jpeg');">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="slide-title">Fuel Your Fitness Journey</h1>
                        <p class="slide-subtitle">Premium Quality Supplements for Maximum Results</p>
                        <button class="cta-button" onclick="window.location.href='#brands'">Explore Products</button>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('img/slider/2.jpeg');">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1 class="slide-title">Trusted by Athletes</h1>
                        <p class="slide-subtitle">100% Authentic Products, Best Prices Guaranteed</p>
                        <button class="cta-button" onclick="window.location.href='#brands'">Shop Now</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-controls">
            <button class="slider-btn prev" onclick="changeSlide(-1)">‹</button>
            <div class="slider-dots" id="sliderDots"></div>
            <button class="slider-btn next" onclick="changeSlide(1)">›</button>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">About Protein Planet</h2>
                <p class="section-subtitle">Your Trusted Partner in Fitness Excellence</p>
            </div>
            <div class="about-content">
                <div class="about-card">
                    <div class="about-icon">💪</div>
                    <h3>Premium Quality</h3>
                    <p>We offer only 100% authentic supplements from world-renowned brands. Every product is verified for quality and authenticity.</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">🏆</div>
                    <h3>Expert Guidance</h3>
                    <p>Our knowledgeable staff helps you choose the right supplements for your specific fitness goals and nutrition needs.</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">💯</div>
                    <h3>Best Prices</h3>
                    <p>Competitive pricing with regular offers and discounts. Get premium supplements without breaking the bank.</p>
                </div>
                <div class="about-card">
                    <div class="about-icon">🚀</div>
                    <h3>Fast Delivery</h3>
                    <p>Quick and reliable service. Visit our store or get your supplements delivered to your doorstep.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands Section (Dynamic) -->
    <section id="brands" class="brands-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Available Brands</h2>
                <p class="section-subtitle">Premium Supplement Brands We Carry</p>
            </div>
            <div id="brandsContainer" class="brands-grid">
                <div style="text-align: center; padding: 40px; grid-column: 1/-1;">
                    <div style="font-size: 48px; margin-bottom: 20px;">🔄</div>
                    <p style="color: #7F8C8D;">Loading brands...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section (Dynamic Slider) -->
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-subtitle">Real Reviews from Real Athletes</p>
            </div>
            <div class="testimonials-slider-wrapper">
                <button class="testimonial-slider-btn prev" onclick="slideTestimonials(-1)" id="testimonialPrevBtn">‹</button>
                <div id="testimonialsContainer" class="testimonials-grid">
                    <div style="text-align: center; padding: 40px; flex: 1;">
                        <div style="font-size: 48px; margin-bottom: 20px;">🔄</div>
                        <p style="color: #7F8C8D;">Loading reviews...</p>
                    </div>
                </div>
                <button class="testimonial-slider-btn next" onclick="slideTestimonials(1)" id="testimonialNextBtn">›</button>
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="submit-review.php" class="cta-button" style="display: inline-block; text-decoration: none;">
                    📝 Share Your Experience
                </a>
            </div>
        </div>
    </section>

    <!-- Certificates Section -->
    <section id="certificates" class="certificates-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Certifications</h2>
                <p class="section-subtitle">Trusted & Certified Quality</p>
            </div>
            <div class="certificates-grid">
                <div class="certificate-card">
                    <div class="cert-icon">🏅</div>
                    <h3>ISO Certified</h3>
                    <p>ISO 9001:2015 certified for quality management</p>
                </div>
                <div class="certificate-card">
                    <div class="cert-icon">✅</div>
                    <h3>FDA Approved</h3>
                    <p>All products meet FDA safety standards</p>
                </div>
                <div class="certificate-card">
                    <div class="cert-icon">🔬</div>
                    <h3>Lab Tested</h3>
                    <p>Third-party laboratory tested for purity</p>
                </div>
                <div class="certificate-card">
                    <div class="cert-icon">🌟</div>
                    <h3>GMP Certified</h3>
                    <p>Good Manufacturing Practice certified</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>🏋️ Protein Planet</h3>
                    <p>Your trusted partner in achieving fitness excellence. Premium supplements, expert guidance.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <a href="#home">Home</a>
                    <a href="#about">About</a>
                    <a href="#brands">Brands</a>
                    <a href="login.php">Staff Login</a>
                </div>
                <div class="footer-section">
                    <h4>Contact Us</h4>
                    <p>📱 +91 7008362528</p>
                    <p>📍 Shop number 107, RCMS complex,<br>Civil Township, Rourkela,<br>Odisha 769012</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Protein Planet. All rights reserved. | Built with ❤️ for fitness enthusiasts</p>
            </div>
        </div>
    </footer>

    <!-- Firebase SDK (for loading brands) -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config-public.js"></script>
    <script src="js/landing.js"></script>
</body>
</html>
