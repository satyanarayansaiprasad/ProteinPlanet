<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff POS - Make Sale - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .pos-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }
        .pos-left {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .pos-right {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .page-title {
            font-size: 32px;
            color: #2C3E50;
            margin-bottom: 10px;
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
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .product-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        .product-info.show {
            display: block;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .btn-add {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39,174,96,0.4);
        }
        .cart-header {
            font-size: 24px;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 20px;
        }
        .cart-items {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .cart-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .cart-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .cart-item-info {
            flex: 1;
        }
        .cart-item-name {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 5px;
        }
        .cart-item-brand {
            font-size: 12px;
            color: #7F8C8D;
        }
        .cart-item-controls {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            align-items: center;
        }
        .cart-input-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .cart-input-label {
            font-size: 11px;
            color: #7F8C8D;
            font-weight: 500;
        }
        .cart-input {
            padding: 8px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            width: 100%;
        }
        .cart-input:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .cart-item-total {
            font-weight: 700;
            color: #27ae60;
            font-size: 18px;
            text-align: center;
        }
        .btn-remove {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }
        .btn-remove:hover {
            background: #c0392b;
        }
        .cart-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .summary-row.total {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60;
            padding-top: 15px;
            border-top: 2px solid #ddd;
        }
        .btn-checkout {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,107,53,0.4);
        }
        .btn-clear {
            width: 100%;
            padding: 12px;
            background: #7f8c8d;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            margin-top: 10px;
        }
        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #7F8C8D;
        }
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
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 1024px) {
            .pos-container {
                grid-template-columns: 1fr;
            }
        }

        /* Receipt Modal */
        .receipt-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .receipt-modal.show { display: flex; }
        
        .receipt-container {
            background: white;
            max-width: 500px;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        
        .receipt-content {
            padding: 30px;
            overflow-y: auto;
            flex: 1;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .receipt-logo {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .receipt-title {
            font-size: 28px;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 5px;
        }
        
        .receipt-subtitle {
            color: #7F8C8D;
            font-size: 14px;
        }
        
        .receipt-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .receipt-info-label {
            color: #7F8C8D;
        }
        
        .receipt-info-value {
            font-weight: 600;
            color: #2C3E50;
        }
        
        .receipt-items {
            margin-bottom: 20px;
        }
        
        .receipt-items-title {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .receipt-item {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .receipt-item:last-child {
            border-bottom: none;
        }
        
        .receipt-item-name {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 4px;
        }
        
        .receipt-item-details {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #7F8C8D;
        }
        
        .receipt-item-price {
            font-weight: 600;
            color: #27ae60;
        }
        
        .receipt-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .receipt-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 15px;
        }
        
        .receipt-total {
            font-size: 24px;
            font-weight: 700;
            color: #27ae60;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            margin-top: 10px;
        }
        
        .receipt-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            color: #7F8C8D;
            font-size: 13px;
        }
        
        .receipt-actions {
            padding: 20px;
            background: #f8f9fa;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .receipt-btn {
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .receipt-btn-whatsapp {
            background: #25D366;
            color: white;
        }
        
        .receipt-btn-email {
            background: #3498db;
            color: white;
        }
        
        .receipt-btn-print {
            background: #34495e;
            color: white;
            grid-column: 1 / -1;
        }
        
        .receipt-btn-close {
            background: #7f8c8d;
            color: white;
            grid-column: 1 / -1;
        }
        
        .receipt-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        @media print {
            .header, .container, .pos-container {
                display: none !important;
            }
            .receipt-modal {
                display: block !important;
                position: static;
                background: white;
            }
            .receipt-container {
                max-width: 100%;
                box-shadow: none;
            }
            .receipt-actions {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/staff-header.php'; ?>

    <div class="container">
        <div id="messageContainer"></div>
        
        <div class="pos-container">
            <!-- Left: Add Products -->
            <div class="pos-left">
                <h1 class="page-title">💰 Point of Sale</h1>
                <p style="color: #7F8C8D; margin-bottom: 30px;">Select products and process sales</p>

                <div class="form-group">
                    <label for="productSelect">Select Product</label>
                    <select id="productSelect">
                        <option value="">Choose a product...</option>
                    </select>
                </div>

                <div id="productInfo" class="product-info">
                    <div class="info-row">
                        <span style="color: #7F8C8D;">Available Stock:</span>
                        <span style="font-weight: 600;" id="availableStock">0</span>
                    </div>
                    <div class="info-row">
                        <span style="color: #7F8C8D;">Price per Unit:</span>
                        <span style="font-weight: 600; color: #27ae60;">₹<span id="unitPrice">0.00</span></span>
                    </div>
                    <div class="info-row">
                        <span style="color: #7F8C8D;">Brand:</span>
                        <span style="font-weight: 600;" id="productBrand">-</span>
                    </div>
                    <div class="info-row">
                        <span style="color: #7F8C8D;">Category:</span>
                        <span style="font-weight: 600;" id="productCategory">-</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity to Sell</label>
                    <input type="number" id="quantity" min="1" placeholder="Enter quantity">
                </div>

                <div class="form-group">
                    <label for="customPrice">Custom Price (Optional)</label>
                    <input type="number" id="customPrice" step="0.01" placeholder="Leave empty to use default price">
                </div>

                <button class="btn-add" onclick="addToCart()">➕ Add to Cart</button>
            </div>

            <!-- Right: Cart & Checkout -->
            <div class="pos-right">
                <div class="cart-header">🛒 Cart</div>

                <!-- Customer Information -->
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                    <div style="font-weight: 600; color: #2C3E50; margin-bottom: 10px;">Customer Information</div>
                    <div class="form-group" style="margin-bottom: 10px;">
                        <input type="text" id="customerName" placeholder="Customer Name" style="width: 100%; padding: 8px; border: 2px solid #e0e0e0; border-radius: 6px; font-family: 'Poppins', sans-serif;">
                    </div>
                    <div class="form-group">
                        <input type="tel" id="customerWhatsapp" placeholder="WhatsApp Number (e.g., +917008362528)" style="width: 100%; padding: 8px; border: 2px solid #e0e0e0; border-radius: 6px; font-family: 'Poppins', sans-serif;">
                    </div>
                </div>

                <div class="cart-items" id="cartItems">
                    <div class="empty-cart">
                        <div style="font-size: 64px;">🛒</div>
                        <p>Cart is empty</p>
                        <p style="font-size: 14px;">Add products to start selling</p>
                    </div>
                </div>

                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Items:</span>
                        <span id="totalItems">0</span>
                    </div>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>₹<span id="subtotal">0.00</span></span>
                    </div>
                    <div class="summary-row total">
                        <span>TOTAL:</span>
                        <span>₹<span id="grandTotal">0.00</span></span>
                    </div>
                </div>

                <button class="btn-checkout" onclick="processCheckout()" id="checkoutBtn" disabled>
                    💳 Process Checkout
                </button>
                <button class="btn-clear" onclick="clearCart()">🗑️ Clear Cart</button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="receipt-modal">
        <div class="receipt-container">
            <div class="receipt-content">
                <div class="receipt-header">
                    <div class="receipt-logo">🏋️</div>
                    <div class="receipt-title">Protein Planet</div>
                    <div class="receipt-subtitle">Your Fitness Partner</div>
                </div>

                <div class="receipt-info">
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Receipt #</span>
                        <span class="receipt-info-value" id="receiptNumber">-</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Date & Time</span>
                        <span class="receipt-info-value" id="receiptDate">-</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Cashier</span>
                        <span class="receipt-info-value" id="receiptCashier">-</span>
                    </div>
                </div>

                <!-- Customer Information on Receipt -->
                <div id="customerInfoReceipt" style="display: none; background: #e8f4f8; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #3498db;">
                    <div style="font-weight: 600; color: #2C3E50; margin-bottom: 10px;">Customer Details</div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Name</span>
                        <span class="receipt-info-value" id="receiptCustomerName">-</span>
                    </div>
                    <div class="receipt-info-row" id="receiptWhatsappRow" style="display: none;">
                        <span class="receipt-info-label">WhatsApp</span>
                        <span class="receipt-info-value" id="receiptCustomerWhatsapp">-</span>
                    </div>
                    <div class="receipt-info-row" id="receiptEmailRow" style="display: none;">
                        <span class="receipt-info-label">Email</span>
                        <span class="receipt-info-value" id="receiptCustomerEmail">-</span>
                    </div>
                </div>

                <div class="receipt-items">
                    <div class="receipt-items-title">Items Purchased</div>
                    <div id="receiptItemsList"></div>
                </div>

                <div class="receipt-summary">
                    <div class="receipt-summary-row">
                        <span>Subtotal:</span>
                        <span>₹<span id="receiptSubtotal">0.00</span></span>
                    </div>
                    <div class="receipt-summary-row receipt-total">
                        <span>TOTAL:</span>
                        <span>₹<span id="receiptTotal">0.00</span></span>
                    </div>
                </div>

                <div class="receipt-footer">
                    <p><strong>Thank you for your purchase!</strong></p>
                    <p>Keep pushing your limits! 💪</p>
                    <p style="margin-top: 10px;">📱 +91 7008362528</p>
                    <p style="font-size: 11px; margin-top: 5px;">Shop 107, RCMS Complex, Civil Township, Rourkela, Odisha 769012</p>
                </div>
            </div>

            <div class="receipt-actions">
                <button class="receipt-btn receipt-btn-print" onclick="printReceipt()">
                    🖨️ Print Receipt
                </button>
                <button class="receipt-btn receipt-btn-close" onclick="closeReceipt()">
                    ✖️ Close
                </button>
            </div>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script src="js/firebase-config.js"></script>
    <script src="js/staff-auth-check.js"></script>

    <script>
        let products = [];
        let cart = [];
        let selectedProduct = null;

        // Load products
        async function loadProducts() {
            try {
                // Get all products (no compound queries to avoid index requirement)
                const snapshot = await firebaseDb.collection('products').get();

                const select = document.getElementById('productSelect');
                select.innerHTML = '<option value="">Choose a product...</option>';

                // Collect, filter, and sort products
                const productsList = [];
                snapshot.forEach(doc => {
                    const product = { id: doc.id, ...doc.data() };
                    
                    // Filter: only active products with available quantity
                    if (product.status === 'active' && product.availableQuantity > 0) {
                        products.push(product);
                        productsList.push({ id: doc.id, product });
                    }
                });

                // Sort products by name alphabetically
                productsList.sort((a, b) => a.product.name.localeCompare(b.product.name));

                // Add sorted products to dropdown
                productsList.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.product.name} - ${item.product.brandName} (Stock: ${item.product.availableQuantity})`;
                    select.appendChild(option);
                });

            } catch (error) {
                console.error('Error loading products:', error);
                showMessage('Error loading products: ' + error.message, 'error');
            }
        }

        // Product selection
        document.getElementById('productSelect').addEventListener('change', function() {
            const productId = this.value;
            if (!productId) {
                document.getElementById('productInfo').classList.remove('show');
                selectedProduct = null;
                return;
            }

            selectedProduct = products.find(p => p.id === productId);
            if (selectedProduct) {
                document.getElementById('availableStock').textContent = selectedProduct.availableQuantity;
                document.getElementById('unitPrice').textContent = selectedProduct.sellingPrice.toFixed(2);
                document.getElementById('productBrand').textContent = selectedProduct.brandName;
                document.getElementById('productCategory').textContent = selectedProduct.categoryName;
                document.getElementById('productInfo').classList.add('show');
                document.getElementById('quantity').max = selectedProduct.availableQuantity;
            }
        });

        // Add to cart
        function addToCart() {
            if (!selectedProduct) {
                showMessage('Please select a product', 'error');
                return;
            }

            const quantity = parseInt(document.getElementById('quantity').value);
            if (!quantity || quantity <= 0) {
                showMessage('Please enter a valid quantity', 'error');
                return;
            }

            if (quantity > selectedProduct.availableQuantity) {
                showMessage(`Only ${selectedProduct.availableQuantity} units available`, 'error');
                return;
            }

            const customPrice = parseFloat(document.getElementById('customPrice').value);
            const price = customPrice || selectedProduct.sellingPrice;

            cart.push({
                productId: selectedProduct.id,
                name: selectedProduct.name,
                brand: selectedProduct.brandName,
                category: selectedProduct.categoryName,
                quantity: quantity,
                price: price,
                total: price * quantity
            });

            updateCart();
            document.getElementById('quantity').value = '';
            document.getElementById('customPrice').value = '';
            document.getElementById('productSelect').value = '';
            document.getElementById('productInfo').classList.remove('show');
            selectedProduct = null;

            showMessage('✅ Product added to cart', 'success');
        }

        // Update cart display
        function updateCart() {
            const cartItemsDiv = document.getElementById('cartItems');
            
            if (cart.length === 0) {
                cartItemsDiv.innerHTML = `
                    <div class="empty-cart">
                        <div style="font-size: 64px;">🛒</div>
                        <p>Cart is empty</p>
                    </div>
                `;
                document.getElementById('checkoutBtn').disabled = true;
            } else {
                let html = '';
                cart.forEach((item, index) => {
                    html += `
                        <div class="cart-item">
                            <div class="cart-item-header">
                                <div class="cart-item-info">
                                    <div class="cart-item-name">${item.name}</div>
                                    <div class="cart-item-brand">${item.brand} - ${item.category}</div>
                                </div>
                                <button class="btn-remove" onclick="removeFromCart(${index})">🗑️ Remove</button>
                            </div>
                            <div class="cart-item-controls">
                                <div class="cart-input-group">
                                    <label class="cart-input-label">Quantity</label>
                                    <input type="number" class="cart-input" value="${item.quantity}" min="1" 
                                           onchange="updateCartItem(${index}, 'quantity', this.value)">
                                </div>
                                <div class="cart-input-group">
                                    <label class="cart-input-label">Price (₹)</label>
                                    <input type="number" class="cart-input" value="${item.price.toFixed(2)}" step="0.01" min="0" 
                                           onchange="updateCartItem(${index}, 'price', this.value)">
                                </div>
                                <div class="cart-input-group">
                                    <label class="cart-input-label">Total</label>
                                    <div class="cart-item-total">₹${item.total.toFixed(2)}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                cartItemsDiv.innerHTML = html;
                document.getElementById('checkoutBtn').disabled = false;
            }

            // Update summary
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = cart.reduce((sum, item) => sum + item.total, 0);

            document.getElementById('totalItems').textContent = totalItems;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('grandTotal').textContent = subtotal.toFixed(2);
        }

        // Update cart item (quantity or price)
        function updateCartItem(index, field, value) {
            if (field === 'quantity') {
                const newQty = parseInt(value);
                if (newQty < 1) {
                    showMessage('Quantity must be at least 1', 'error');
                    updateCart();
                    return;
                }
                
                // Check if product has enough stock
                const product = products.find(p => p.id === cart[index].productId);
                if (product && newQty > product.availableQuantity) {
                    showMessage(`Only ${product.availableQuantity} units available`, 'error');
                    updateCart();
                    return;
                }
                
                cart[index].quantity = newQty;
            } else if (field === 'price') {
                const newPrice = parseFloat(value);
                if (newPrice < 0) {
                    showMessage('Price cannot be negative', 'error');
                    updateCart();
                    return;
                }
                cart[index].price = newPrice;
            }
            
            // Recalculate total for this item
            cart[index].total = cart[index].quantity * cart[index].price;
            
            // Update display
            updateCart();
        }

        // Remove from cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        // Clear cart
        function clearCart() {
            if (cart.length === 0) return;
            if (confirm('Clear all items from cart?')) {
                cart = [];
                updateCart();
            }
        }

        // Global receipt data
        let currentReceipt = null;

        // Process checkout
        async function processCheckout() {
            if (cart.length === 0) return;

            // Get customer information
            const customerName = document.getElementById('customerName').value.trim();
            const customerWhatsapp = document.getElementById('customerWhatsapp').value.trim();

            // Validate customer name is provided
            if (!customerName) {
                showMessage('⚠️ Please enter customer name', 'error');
                document.getElementById('customerName').focus();
                return;
            }

            if (!confirm('Process this sale?')) return;

            try {
                const total = cart.reduce((sum, item) => sum + item.total, 0);
                const totalProfit = cart.reduce((sum, item) => {
                    const product = products.find(p => p.id === item.productId);
                    return sum + ((item.price - product.buyingPrice) * item.quantity);
                }, 0);

                // Save sale with customer information
                const saleData = {
                    items: cart,
                    totalAmount: total,
                    totalProfit: totalProfit,
                    totalItems: cart.reduce((sum, item) => sum + item.quantity, 0),
                    soldBy: firebaseAuth.currentUser.uid,
                    soldAt: firebase.firestore.FieldValue.serverTimestamp(),
                    status: 'completed',
                    customer: {
                        name: customerName,
                        whatsapp: customerWhatsapp
                    }
                };

                const saleDoc = await firebaseDb.collection('sales').add(saleData);

                // Update product quantities
                const batch = firebaseDb.batch();
                cart.forEach(item => {
                    const productRef = firebaseDb.collection('products').doc(item.productId);
                    const product = products.find(p => p.id === item.productId);
                    batch.update(productRef, {
                        availableQuantity: product.availableQuantity - item.quantity,
                        soldQuantity: (product.soldQuantity || 0) + item.quantity,
                        updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                    });
                });
                await batch.commit();

                // Get user data for cashier name
                const userDoc = await firebaseDb.collection('users').doc(firebaseAuth.currentUser.uid).get();
                const cashierName = userDoc.exists ? userDoc.data().name : 'Staff';

                // Show receipt
                showReceipt({
                    receiptId: saleDoc.id,
                    items: cart,
                    total: total,
                    date: new Date(),
                    cashier: cashierName,
                    customer: {
                        name: customerName,
                        whatsapp: customerWhatsapp
                    }
                });

                showMessage(`✅ Sale completed! Total: ₹${total.toFixed(2)}`, 'success');
                
                // Clear cart and customer info
                cart = [];
                document.getElementById('customerName').value = '';
                document.getElementById('customerWhatsapp').value = '';
                updateCart();
                loadProducts(); // Reload to update available quantities

            } catch (error) {
                console.error('Error processing sale:', error);
                showMessage('Error processing sale: ' + error.message, 'error');
            }
        }

        // Show receipt modal
        function showReceipt(receiptData) {
            currentReceipt = receiptData;

            // Format receipt number
            const receiptNum = 'PP-' + receiptData.receiptId.substring(0, 8).toUpperCase();
            document.getElementById('receiptNumber').textContent = receiptNum;

            // Format date
            const dateStr = receiptData.date.toLocaleString('en-IN', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('receiptDate').textContent = dateStr;

            // Cashier name
            document.getElementById('receiptCashier').textContent = receiptData.cashier;

            // Customer information
            if (receiptData.customer && receiptData.customer.name) {
                document.getElementById('customerInfoReceipt').style.display = 'block';
                document.getElementById('receiptCustomerName').textContent = receiptData.customer.name;
                
                if (receiptData.customer.whatsapp) {
                    document.getElementById('receiptWhatsappRow').style.display = 'flex';
                    document.getElementById('receiptCustomerWhatsapp').textContent = receiptData.customer.whatsapp;
                } else {
                    document.getElementById('receiptWhatsappRow').style.display = 'none';
                }
                
                document.getElementById('receiptEmailRow').style.display = 'none';
            } else {
                document.getElementById('customerInfoReceipt').style.display = 'none';
            }

            // Items list
            let itemsHtml = '';
            receiptData.items.forEach(item => {
                itemsHtml += `
                    <div class="receipt-item">
                        <div class="receipt-item-name">${item.name}</div>
                        <div class="receipt-item-details">
                            <span>${item.quantity} × ₹${item.price.toFixed(2)}</span>
                            <span class="receipt-item-price">₹${item.total.toFixed(2)}</span>
                        </div>
                    </div>
                `;
            });
            document.getElementById('receiptItemsList').innerHTML = itemsHtml;

            // Totals
            document.getElementById('receiptSubtotal').textContent = receiptData.total.toFixed(2);
            document.getElementById('receiptTotal').textContent = receiptData.total.toFixed(2);

            // Show modal
            document.getElementById('receiptModal').classList.add('show');
        }

        // Close receipt
        function closeReceipt() {
            document.getElementById('receiptModal').classList.remove('show');
            currentReceipt = null;
        }

        // Print receipt
        function printReceipt() {
            window.print();
        }


        // Show message
        function showMessage(message, type) {
            const container = document.getElementById('messageContainer');
            container.innerHTML = `<div class="message ${type} show">${message}</div>`;
            setTimeout(() => {
                const msg = container.querySelector('.message');
                if (msg) msg.classList.remove('show');
            }, 5000);
        }

        // Load products on page load
        loadProducts();
    </script>
</body>
</html>

