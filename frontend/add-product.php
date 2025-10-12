<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product/Stock - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .page-title {
            font-size: 32px;
            color: #2C3E50;
            margin-bottom: 10px;
        }
        .page-subtitle {
            color: #7F8C8D;
            margin-bottom: 30px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            color: #2C3E50;
            margin-bottom: 8px;
        }
        .form-group label .required {
            color: #e74c3c;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        .alert-box.show { display: block; animation: slideDown 0.3s; }
        .alert-box.warning {
            background: #fff8e1;
            border-left: 4px solid #FFB627;
            color: #856404;
        }
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }
        .btn-submit {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        }
        .btn-cancel {
            background: #7f8c8d;
            color: white;
        }
        .btn-cancel:hover { background: #6c7a7b; }
        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        .message.show { display: block; animation: slideDown 0.3s; }
        .message.success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .info-card {
            background: #e8f4f8;
            border-left: 4px solid #3498db;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-card strong {
            color: #2C3E50;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>

    <div class="container">
        <div class="form-container">
            <h1 class="page-title">➕ Add New Product/Stock</h1>
            <p class="page-subtitle">Add product details to your inventory</p>

            <div id="messageContainer"></div>

            <div id="alertBox" class="alert-box warning">
                ⚠️ Make sure you have added <strong>Brands</strong> and <strong>Categories</strong> before adding products.
                <div style="margin-top: 10px;">
                    <a href="manage-brands.php" style="color: #FF6B35; text-decoration: none; font-weight: 600;">→ Manage Brands</a> | 
                    <a href="manage-categories.php" style="color: #FF6B35; text-decoration: none; font-weight: 600;">→ Manage Categories</a>
                </div>
            </div>

            <form id="productForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="brand">Brand <span class="required">*</span></label>
                        <select id="brand" required>
                            <option value="">Select Brand</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category">Category <span class="required">*</span></label>
                        <select id="category" required>
                            <option value="">Select Category</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="productName">Product Name <span class="required">*</span></label>
                    <input type="text" id="productName" placeholder="e.g., Gold Standard Whey Protein 2lbs" required>
                </div>

                <div class="form-group">
                    <label for="productDescription">Description (Optional)</label>
                    <textarea id="productDescription" placeholder="Product description, flavor, etc."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="purchaseDate">Purchase Date <span class="required">*</span></label>
                        <input type="date" id="purchaseDate" required>
                    </div>

                    <div class="form-group">
                        <label for="expiryDate">Expiry Date <span class="required">*</span></label>
                        <input type="date" id="expiryDate" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="buyingPrice">Buying Price (₹) <span class="required">*</span></label>
                        <input type="number" id="buyingPrice" placeholder="0.00" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity <span class="required">*</span></label>
                        <input type="number" id="quantity" placeholder="0" min="1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sellingPrice">Selling Price (₹) <span class="required">*</span></label>
                        <input type="number" id="sellingPrice" placeholder="0.00" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="barcode">Barcode/SKU (Optional)</label>
                        <input type="text" id="barcode" placeholder="Product barcode or SKU">
                    </div>
                </div>

                <div class="info-card" id="profitInfo" style="display:none;">
                    <strong>💰 Profit Margin:</strong> <span id="profitMargin">0%</span><br>
                    <strong>💵 Profit Per Unit:</strong> ₹<span id="profitPerUnit">0.00</span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">💾 Add Product to Inventory</button>
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='view-products.php'">❌ Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>
    <script src="js/auth-check.js"></script>

    <script>
        // Set today's date as default for purchase date
        document.getElementById('purchaseDate').valueAsDate = new Date();

        // Load brands and categories
        async function loadBrandsAndCategories() {
            try {
                // Load brands
                const brandsSnapshot = await firebaseDb.collection('brands').orderBy('name').get();
                const brandSelect = document.getElementById('brand');
                
                if (brandsSnapshot.empty) {
                    document.getElementById('alertBox').classList.add('show');
                } else {
                    brandsSnapshot.forEach(doc => {
                        const option = document.createElement('option');
                        option.value = doc.id;
                        option.textContent = doc.data().name;
                        brandSelect.appendChild(option);
                    });
                }

                // Load categories
                const categoriesSnapshot = await firebaseDb.collection('categories').orderBy('name').get();
                const categorySelect = document.getElementById('category');
                
                if (categoriesSnapshot.empty) {
                    document.getElementById('alertBox').classList.add('show');
                } else {
                    categoriesSnapshot.forEach(doc => {
                        const option = document.createElement('option');
                        option.value = doc.id;
                        option.textContent = doc.data().name;
                        categorySelect.appendChild(option);
                    });
                }

            } catch (error) {
                console.error('Error loading data:', error);
                showMessage('Error loading brands/categories: ' + error.message, 'error');
            }
        }

        // Calculate profit when prices change
        document.getElementById('buyingPrice').addEventListener('input', calculateProfit);
        document.getElementById('sellingPrice').addEventListener('input', calculateProfit);

        function calculateProfit() {
            const buyingPrice = parseFloat(document.getElementById('buyingPrice').value) || 0;
            const sellingPrice = parseFloat(document.getElementById('sellingPrice').value) || 0;

            if (buyingPrice > 0 && sellingPrice > 0) {
                const profit = sellingPrice - buyingPrice;
                const profitMargin = ((profit / buyingPrice) * 100).toFixed(2);
                
                document.getElementById('profitPerUnit').textContent = profit.toFixed(2);
                document.getElementById('profitMargin').textContent = profitMargin + '%';
                document.getElementById('profitInfo').style.display = 'block';
            } else {
                document.getElementById('profitInfo').style.display = 'none';
            }
        }

        // Validate expiry date is after purchase date
        document.getElementById('expiryDate').addEventListener('change', function() {
            const purchaseDate = new Date(document.getElementById('purchaseDate').value);
            const expiryDate = new Date(this.value);

            if (expiryDate <= purchaseDate) {
                showMessage('⚠️ Expiry date must be after purchase date', 'error');
                this.value = '';
            }
        });

        // Submit form
        document.getElementById('productForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const brandId = document.getElementById('brand').value;
            const categoryId = document.getElementById('category').value;
            const productName = document.getElementById('productName').value.trim();
            const description = document.getElementById('productDescription').value.trim();
            const purchaseDate = document.getElementById('purchaseDate').value;
            const expiryDate = document.getElementById('expiryDate').value;
            const buyingPrice = parseFloat(document.getElementById('buyingPrice').value);
            const quantity = parseInt(document.getElementById('quantity').value);
            const sellingPrice = parseFloat(document.getElementById('sellingPrice').value);
            const barcode = document.getElementById('barcode').value.trim();

            if (!brandId || !categoryId) {
                showMessage('Please select both brand and category', 'error');
                return;
            }

            try {
                // Get brand and category names
                const brandDoc = await firebaseDb.collection('brands').doc(brandId).get();
                const categoryDoc = await firebaseDb.collection('categories').doc(categoryId).get();

                const productData = {
                    brandId: brandId,
                    brandName: brandDoc.data().name,
                    categoryId: categoryId,
                    categoryName: categoryDoc.data().name,
                    name: productName,
                    description: description,
                    purchaseDate: firebase.firestore.Timestamp.fromDate(new Date(purchaseDate)),
                    expiryDate: firebase.firestore.Timestamp.fromDate(new Date(expiryDate)),
                    buyingPrice: buyingPrice,
                    sellingPrice: sellingPrice,
                    quantity: quantity,
                    availableQuantity: quantity,
                    soldQuantity: 0,
                    barcode: barcode,
                    profitPerUnit: sellingPrice - buyingPrice,
                    profitMargin: ((sellingPrice - buyingPrice) / buyingPrice * 100).toFixed(2),
                    status: 'active',
                    createdAt: firebase.firestore.FieldValue.serverTimestamp(),
                    updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                };

                await firebaseDb.collection('products').add(productData);
                
                showMessage('✅ Product added to inventory successfully!', 'success');
                
                // Reset form after 2 seconds
                setTimeout(() => {
                    document.getElementById('productForm').reset();
                    document.getElementById('purchaseDate').valueAsDate = new Date();
                    document.getElementById('profitInfo').style.display = 'none';
                }, 2000);

            } catch (error) {
                console.error('Error adding product:', error);
                showMessage('Error adding product: ' + error.message, 'error');
            }
        });

        // Show message
        function showMessage(message, type) {
            const container = document.getElementById('messageContainer');
            container.innerHTML = `<div class="message ${type} show">${message}</div>`;
            setTimeout(() => {
                const msg = container.querySelector('.message');
                if (msg) msg.classList.remove('show');
            }, 5000);
        }

        // Load data on page load
        loadBrandsAndCategories();
    </script>
</body>
</html>

