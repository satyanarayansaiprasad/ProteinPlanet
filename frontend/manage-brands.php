<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Brands - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard-common.css">
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .add-btn {
            background: linear-gradient(135deg, #FF6B35 0%, #004E89 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,107,53,0.3);
        }
        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .brand-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .brand-name {
            font-size: 20px;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 10px;
        }
        .brand-meta {
            font-size: 12px;
            color: #7F8C8D;
            margin-bottom: 15px;
        }
        .brand-actions {
            display: flex;
            gap: 10px;
        }
        .btn-edit, .btn-delete {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-edit {
            background: #3498db;
            color: white;
        }
        .btn-edit:hover { background: #2980b9; }
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        .btn-delete:hover { background: #c0392b; }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.show { display: flex; }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            font-size: 24px;
            font-weight: 600;
            color: #2C3E50;
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
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-save, .btn-cancel {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        .btn-save {
            background: #27ae60;
            color: white;
        }
        .btn-save:hover { background: #229954; }
        .btn-cancel {
            background: #7f8c8d;
            color: white;
        }
        .btn-cancel:hover { background: #6c7a7b; }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7F8C8D;
        }
        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        .message {
            padding: 12px 20px;
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
    </style>
</head>
<body>
    <?php include 'includes/admin-header.php'; ?>

    <div class="container">
        <div id="messageContainer"></div>

        <div class="page-header">
            <div>
                <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">🏷️ Manage Brands</h1>
                <p style="color: #7F8C8D;">Add and manage supplement brands</p>
            </div>
            <button class="add-btn" onclick="openAddModal()">
                ➕ Add New Brand
            </button>
        </div>

        <div id="brandsContainer">
            <div class="empty-state">
                <div class="empty-state-icon">🔄</div>
                <p>Loading brands...</p>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="brandModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modalTitle">Add New Brand</div>
            <form id="brandForm">
                <input type="hidden" id="brandId">
                <div class="form-group">
                    <label for="brandName">Brand Name *</label>
                    <input type="text" id="brandName" placeholder="e.g., Optimum Nutrition" required>
                </div>
                <div class="form-group">
                    <label for="brandDescription">Description (Optional)</label>
                    <textarea id="brandDescription" rows="3" placeholder="Brief description about the brand"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-save">💾 Save Brand</button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">❌ Cancel</button>
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
        let editingBrandId = null;

        // Load all brands
        async function loadBrands() {
            try {
                const snapshot = await firebaseDb.collection('brands').orderBy('name').get();
                const container = document.getElementById('brandsContainer');

                if (snapshot.empty) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">🏷️</div>
                            <h3>No Brands Added Yet</h3>
                            <p>Click "Add New Brand" to get started</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="brands-grid">';
                snapshot.forEach(doc => {
                    const brand = doc.data();
                    const createdDate = brand.createdAt ? new Date(brand.createdAt.toDate()).toLocaleDateString() : 'N/A';
                    html += `
                        <div class="brand-card">
                            <div class="brand-name">${brand.name}</div>
                            <div class="brand-meta">Added: ${createdDate}</div>
                            ${brand.description ? `<p style="color: #7F8C8D; font-size: 14px; margin-bottom: 15px;">${brand.description}</p>` : ''}
                            <div class="brand-actions">
                                <button class="btn-edit" onclick="editBrand('${doc.id}', '${brand.name}', '${brand.description || ''}')">
                                    ✏️ Edit
                                </button>
                                <button class="btn-delete" onclick="deleteBrand('${doc.id}', '${brand.name}')">
                                    🗑️ Delete
                                </button>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;

            } catch (error) {
                console.error('Error loading brands:', error);
                showMessage('Error loading brands: ' + error.message, 'error');
            }
        }

        // Open add modal
        function openAddModal() {
            editingBrandId = null;
            document.getElementById('modalTitle').textContent = 'Add New Brand';
            document.getElementById('brandForm').reset();
            document.getElementById('brandId').value = '';
            document.getElementById('brandModal').classList.add('show');
        }

        // Edit brand
        function editBrand(id, name, description) {
            editingBrandId = id;
            document.getElementById('modalTitle').textContent = 'Edit Brand';
            document.getElementById('brandId').value = id;
            document.getElementById('brandName').value = name;
            document.getElementById('brandDescription').value = description;
            document.getElementById('brandModal').classList.add('show');
        }

        // Close modal
        function closeModal() {
            document.getElementById('brandModal').classList.remove('show');
            document.getElementById('brandForm').reset();
            editingBrandId = null;
        }

        // Save brand
        document.getElementById('brandForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('brandName').value.trim();
            const description = document.getElementById('brandDescription').value.trim();

            if (!name) {
                showMessage('Please enter a brand name', 'error');
                return;
            }

            try {
                const brandData = {
                    name: name,
                    description: description,
                    updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                };

                if (editingBrandId) {
                    // Update existing brand
                    await firebaseDb.collection('brands').doc(editingBrandId).update(brandData);
                    showMessage('✅ Brand updated successfully!', 'success');
                } else {
                    // Add new brand
                    brandData.createdAt = firebase.firestore.FieldValue.serverTimestamp();
                    await firebaseDb.collection('brands').add(brandData);
                    showMessage('✅ Brand added successfully!', 'success');
                }

                closeModal();
                loadBrands();

            } catch (error) {
                console.error('Error saving brand:', error);
                showMessage('Error saving brand: ' + error.message, 'error');
            }
        });

        // Delete brand
        async function deleteBrand(id, name) {
            if (!confirm(`Are you sure you want to delete "${name}"?\n\nThis action cannot be undone.`)) {
                return;
            }

            try {
                await firebaseDb.collection('brands').doc(id).delete();
                showMessage('✅ Brand deleted successfully!', 'success');
                loadBrands();
            } catch (error) {
                console.error('Error deleting brand:', error);
                showMessage('Error deleting brand: ' + error.message, 'error');
            }
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

        // Close modal on outside click
        document.getElementById('brandModal').addEventListener('click', (e) => {
            if (e.target.id === 'brandModal') {
                closeModal();
            }
        });

        // Load brands on page load
        loadBrands();
    </script>
</body>
</html>

