<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7fa;
        min-height: 100vh;
    }
    .header {
        background: linear-gradient(135deg, #004E89 0%, #FF6B35 100%);
        color: white;
        padding: 15px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .logo {
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
    }
    .nav-links {
        display: flex;
        gap: 20px;
        margin-left: 30px;
    }
    .nav-link {
        color: white;
        text-decoration: none;
        font-size: 14px;
        transition: opacity 0.3s;
    }
    .nav-link:hover { opacity: 0.8; }
    .user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .logout-btn {
        background: rgba(255,255,255,0.2);
        border: 2px solid white;
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
    }
    .logout-btn:hover {
        background: white;
        color: #004E89;
    }
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    @media (max-width: 768px) {
        .header { padding: 15px 20px; flex-direction: column; gap: 10px; }
        .nav-links { margin-left: 0; }
    }
</style>

<header class="header">
    <div class="header-left">
        <div class="logo" onclick="window.location.href='staff_dashboard.php'">🏋️ Protein Planet</div>
        <nav class="nav-links">
            <a href="staff_dashboard.php" class="nav-link">Dashboard</a>
            <a href="staff-products.php" class="nav-link">Products</a>
            <a href="staff-pos.php" class="nav-link">POS</a>
            <a href="staff-sales-history.php" class="nav-link">My Sales</a>
        </nav>
    </div>
    <div class="user-info">
        <span style="font-size: 14px;">👤 <span id="headerUserName">Staff</span></span>
        <button class="logout-btn" onclick="logoutUser()">Logout</button>
    </div>
</header>

<script>
    function logoutUser() {
        if (confirm('Are you sure you want to logout?')) {
            firebaseAuth.signOut().then(() => {
                window.location.href = 'login.php';
            });
        }
    }
</script>

