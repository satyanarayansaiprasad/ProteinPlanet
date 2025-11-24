<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Protein Planet</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .search-bar {
            margin-bottom: 25px;
        }
        .search-bar input {
            width: 100%;
            max-width: 400px;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
        }
        .search-bar input:focus {
            outline: none;
            border-color: #FF6B35;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        .category-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
        }
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-color: #FF6B35;
        }
        .category-name {
            font-size: 22px;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .category-meta {
            font-size: 13px;
            color: #7F8C8D;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .category-description {
            color: #5A6C7D;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            flex-grow: 1;
        }
        .category-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
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
                <h1 style="color: #2C3E50; font-size: 32px; margin-bottom: 5px;">📂 Manage Categories</h1>
                <p style="color: #7F8C8D;">Add and manage product categories (Whey Protein, EAA, Creatine, etc.)</p>
            </div>
            <button class="add-btn" onclick="openAddModal()">
                ➕ Add New Category
            </button>
        </div>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="🔍 Search categories by name or description...">
        </div>

        <div id="categoriesContainer">
            <div class="empty-state">
                <div class="empty-state-icon">🔄</div>
                <p>Loading categories...</p>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" id="modalTitle">Add New Category</div>
            <form id="categoryForm">
                <input type="hidden" id="categoryId">
                <div class="form-group">
                    <label for="categoryName">Category Name *</label>
                    <input type="text" id="categoryName" placeholder="e.g., Whey Protein" required>
                </div>
                <div class="form-group">
                    <label for="categoryDescription">Description (Optional)</label>
                    <textarea id="categoryDescription" rows="3" placeholder="Brief description about this category"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-save">💾 Save Category</button>
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
        let editingCategoryId = null;

        let allCategories = [];

        // Load all categories
        async function loadCategories() {
            try {
                const snapshot = await firebaseDb.collection('categories').get();
                const container = document.getElementById('categoriesContainer');

                if (snapshot.empty) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">📂</div>
                            <h3>No Categories Added Yet</h3>
                            <p>Click "Add New Category" to get started</p>
                        </div>
                    `;
                    allCategories = [];
                    return;
                }

                // Convert to array and sort alphabetically (case-insensitive)
                allCategories = [];
                snapshot.forEach(doc => {
                    allCategories.push({
                        id: doc.id,
                        ...doc.data()
                    });
                });

                // Sort alphabetically by name (case-insensitive)
                allCategories.sort((a, b) => {
                    const nameA = (a.name || '').toLowerCase();
                    const nameB = (b.name || '').toLowerCase();
                    return nameA.localeCompare(nameB);
                });

                renderCategories(allCategories);

            } catch (error) {
                console.error('Error loading categories:', error);
                showMessage('Error loading categories: ' + error.message, 'error');
            }
        }

        // Render categories
        function renderCategories(categories) {
            const container = document.getElementById('categoriesContainer');
            
            if (categories.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">🔍</div>
                        <h3>No Categories Found</h3>
                        <p>Try adjusting your search</p>
                    </div>
                `;
                return;
            }

            let html = '<div class="categories-grid">';
            categories.forEach(category => {
                const createdDate = category.createdAt ? new Date(category.createdAt.toDate()).toLocaleDateString() : 'N/A';
                const escapedName = (category.name || '').replace(/'/g, "\\'");
                const escapedDesc = (category.description || '').replace(/'/g, "\\'").replace(/\n/g, ' ');
                html += `
                    <div class="category-card">
                        <div class="category-name">${category.name || 'Unnamed Category'}</div>
                        <div class="category-meta">📅 Added: ${createdDate}</div>
                        ${category.description ? `<div class="category-description">${category.description}</div>` : '<div class="category-description" style="color: #BDC3C7; font-style: italic;">No description</div>'}
                        <div class="category-actions">
                            <button class="btn-edit" onclick="editCategory('${category.id}', '${escapedName}', '${escapedDesc}')">
                                ✏️ Edit
                            </button>
                            <button class="btn-delete" onclick="deleteCategory('${category.id}', '${escapedName}')">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }

        // Search functionality
        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const searchTerm = e.target.value.toLowerCase().trim();
                    if (searchTerm === '') {
                        renderCategories(allCategories);
                    } else {
                        const filtered = allCategories.filter(category => 
                            (category.name || '').toLowerCase().includes(searchTerm) ||
                            (category.description || '').toLowerCase().includes(searchTerm)
                        );
                        renderCategories(filtered);
                    }
                });
            }
        }

            } catch (error) {
                console.error('Error loading categories:', error);
                showMessage('Error loading categories: ' + error.message, 'error');
            }
        }

        // Open add modal
        function openAddModal() {
            editingCategoryId = null;
            document.getElementById('modalTitle').textContent = 'Add New Category';
            document.getElementById('categoryForm').reset();
            document.getElementById('categoryId').value = '';
            document.getElementById('categoryModal').classList.add('show');
        }

        // Edit category
        function editCategory(id, name, description) {
            editingCategoryId = id;
            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('categoryId').value = id;
            document.getElementById('categoryName').value = name;
            document.getElementById('categoryDescription').value = description;
            document.getElementById('categoryModal').classList.add('show');
        }

        // Close modal
        function closeModal() {
            document.getElementById('categoryModal').classList.remove('show');
            document.getElementById('categoryForm').reset();
            editingCategoryId = null;
        }

        // Save category
        document.getElementById('categoryForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('categoryName').value.trim();
            const description = document.getElementById('categoryDescription').value.trim();

            if (!name) {
                showMessage('Please enter a category name', 'error');
                return;
            }

            try {
                const categoryData = {
                    name: name,
                    description: description,
                    updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                };

                if (editingCategoryId) {
                    // Update existing category
                    await firebaseDb.collection('categories').doc(editingCategoryId).update(categoryData);
                    showMessage('✅ Category updated successfully!', 'success');
                } else {
                    // Add new category
                    categoryData.createdAt = firebase.firestore.FieldValue.serverTimestamp();
                    await firebaseDb.collection('categories').add(categoryData);
                    showMessage('✅ Category added successfully!', 'success');
                }

                closeModal();
                loadCategories();

            } catch (error) {
                console.error('Error saving category:', error);
                showMessage('Error saving category: ' + error.message, 'error');
            }
        });

        // Delete category
        async function deleteCategory(id, name) {
            if (!confirm(`Are you sure you want to delete "${name}"?\n\nThis action cannot be undone.`)) {
                return;
            }

            try {
                await firebaseDb.collection('categories').doc(id).delete();
                showMessage('✅ Category deleted successfully!', 'success');
                loadCategories();
            } catch (error) {
                console.error('Error deleting category:', error);
                showMessage('Error deleting category: ' + error.message, 'error');
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
        document.getElementById('categoryModal').addEventListener('click', (e) => {
            if (e.target.id === 'categoryModal') {
                closeModal();
            }
        });

        // Load categories on page load
        loadCategories();
        
        // Setup search after categories are loaded
        setTimeout(() => {
            setupSearch();
        }, 500);
    </script>
</body>
</html>

