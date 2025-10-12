<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review - Protein Planet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .review-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .review-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .review-header h1 {
            color: #2C3E50;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .review-header .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .review-header p {
            color: #7F8C8D;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #2C3E50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #E0E0E0;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .rating-group {
            margin-bottom: 25px;
        }

        .rating-group label {
            display: block;
            color: #2C3E50;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .stars {
            display: flex;
            gap: 10px;
            justify-content: center;
            font-size: 40px;
            cursor: pointer;
        }

        .star {
            color: #ddd;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .star:hover,
        .star.active {
            color: #FFD700;
            transform: scale(1.2);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: #764ba2;
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .review-container {
                padding: 30px 20px;
            }

            .review-header h1 {
                font-size: 26px;
            }

            .stars {
                font-size: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="review-container">
        <div class="review-header">
            <div class="icon">⭐</div>
            <h1>Share Your Experience</h1>
            <p>We'd love to hear about your experience at Protein Planet</p>
        </div>

        <div id="alertBox" class="alert"></div>

        <form id="reviewForm">
            <div class="form-group">
                <label for="customerName">Your Name *</label>
                <input type="text" id="customerName" required placeholder="Enter your name">
            </div>

            <div class="rating-group">
                <label>Rate Your Experience *</label>
                <div class="stars" id="starsContainer">
                    <span class="star" data-rating="1">★</span>
                    <span class="star" data-rating="2">★</span>
                    <span class="star" data-rating="3">★</span>
                    <span class="star" data-rating="4">★</span>
                    <span class="star" data-rating="5">★</span>
                </div>
                <input type="hidden" id="rating" required>
            </div>

            <div class="form-group">
                <label for="reviewText">Your Review *</label>
                <textarea id="reviewText" required placeholder="Tell us about your experience with our products and staff..."></textarea>
            </div>

            <div class="form-group">
                <label for="customerEmail">Email (Optional)</label>
                <input type="email" id="customerEmail" placeholder="your@email.com">
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                Submit Review
            </button>
        </form>

        <div class="back-link">
            <a href="index.php">← Back to Home</a>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script type="module">
        import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js';
        import { getFirestore, collection, addDoc, serverTimestamp } from 'https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js';

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBu8FOKjbsy9lD8pl98Dq9y-d-2UCjEQx0",
            authDomain: "protein-planet-9cd02.firebaseapp.com",
            projectId: "protein-planet-9cd02",
            storageBucket: "protein-planet-9cd02.firebasestorage.app",
            messagingSenderId: "622242532283",
            appId: "1:622242532283:web:c4510d72f147c25b36129e",
            measurementId: "G-6V0X1M3RKS"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);

        // Rating system
        let selectedRating = 0;
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = selectedRating;
                updateStars();
            });

            star.addEventListener('mouseenter', function() {
                const hoverRating = parseInt(this.getAttribute('data-rating'));
                updateStars(hoverRating);
            });
        });

        document.getElementById('starsContainer').addEventListener('mouseleave', function() {
            updateStars();
        });

        function updateStars(hoverRating = null) {
            const rating = hoverRating || selectedRating;
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const alertBox = document.getElementById('alertBox');

            // Validate rating
            if (selectedRating === 0) {
                showAlert('Please select a rating', 'error');
                return;
            }

            // Get form values
            const customerName = document.getElementById('customerName').value.trim();
            const reviewText = document.getElementById('reviewText').value.trim();
            const customerEmail = document.getElementById('customerEmail').value.trim();

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';

            try {
                // Add review to Firestore
                await addDoc(collection(db, 'reviews'), {
                    customerName: customerName,
                    rating: selectedRating,
                    reviewText: reviewText,
                    customerEmail: customerEmail || null,
                    createdAt: serverTimestamp(),
                    status: 'pending' // Can be used for admin approval if needed
                });

                showAlert('Thank you for your review! 🎉', 'success');
                document.getElementById('reviewForm').reset();
                selectedRating = 0;
                updateStars();

                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);

            } catch (error) {
                console.error('Error submitting review:', error);
                showAlert('Failed to submit review. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Review';
            }
        });

        function showAlert(message, type) {
            const alertBox = document.getElementById('alertBox');
            alertBox.textContent = message;
            alertBox.className = `alert ${type}`;
            alertBox.style.display = 'block';

            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>

