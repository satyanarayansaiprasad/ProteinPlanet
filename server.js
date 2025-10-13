const express = require('express');
const path = require('path');
const fs = require('fs');
const app = express();
const PORT = process.env.PORT || 3000;

// Function to process PHP file and return HTML content
function processPHPFile(filePath) {
    if (fs.existsSync(filePath)) {
        let content = fs.readFileSync(filePath, 'utf8');
        
        // Process PHP includes first
        content = processIncludes(content, path.dirname(filePath));
        
        // Remove remaining PHP tags and server-side code, keep only HTML/JS/CSS
        content = content.replace(/<\?php[\s\S]*?\?>/g, '');
        content = content.replace(/<\?=[\s\S]*?\?>/g, '');
        
        return content;
    }
    return null;
}

// Function to process PHP includes
function processIncludes(content, basePath) {
    // Find all PHP include statements
    const includeRegex = /<\?php\s*include\s*['"]([^'"]+)['"];\s*\?>/g;
    let match;
    
    while ((match = includeRegex.exec(content)) !== null) {
        const includePath = match[1];
        const fullPath = path.join(basePath, includePath);
        
        // Check if the include file exists
        if (fs.existsSync(fullPath)) {
            let includeContent = fs.readFileSync(fullPath, 'utf8');
            
            // Recursively process includes in the included file
            includeContent = processIncludes(includeContent, path.dirname(fullPath));
            
            // Remove PHP tags from included content
            includeContent = includeContent.replace(/<\?php[\s\S]*?\?>/g, '');
            includeContent = includeContent.replace(/<\?=[\s\S]*?\?>/g, '');
            
            // Replace the include statement with the actual content
            content = content.replace(match[0], includeContent);
            
            // Reset regex position to handle overlapping matches
            includeRegex.lastIndex = 0;
        } else {
            // If file doesn't exist, remove the include statement
            content = content.replace(match[0], '');
        }
    }
    
    return content;
}

// Serve static files from frontend directory (CSS, JS, images, etc.)
app.use('/css', express.static(path.join(__dirname, 'frontend', 'css')));
app.use('/js', express.static(path.join(__dirname, 'frontend', 'js')));
app.use('/img', express.static(path.join(__dirname, 'frontend', 'img')));
app.use('/includes', express.static(path.join(__dirname, 'frontend', 'includes')));

// Health check endpoint
app.get('/health', (req, res) => {
    res.json({ 
        status: 'OK', 
        message: 'Protein Planet Server is running!',
        timestamp: new Date().toISOString()
    });
});

// SEO endpoints
app.get('/sitemap.xml', (req, res) => {
    const sitemapPath = path.join(__dirname, 'frontend', 'sitemap.xml');
    if (fs.existsSync(sitemapPath)) {
        res.setHeader('Content-Type', 'application/xml');
        res.sendFile(sitemapPath);
    } else {
        res.status(404).send('Sitemap not found');
    }
});

app.get('/robots.txt', (req, res) => {
    const robotsPath = path.join(__dirname, 'frontend', 'robots.txt');
    if (fs.existsSync(robotsPath)) {
        res.setHeader('Content-Type', 'text/plain');
        res.sendFile(robotsPath);
    } else {
        res.status(404).send('Robots.txt not found');
    }
});

// Define all your routes explicitly
const routes = {
    '/': 'index.php',
    '/login': 'login.php',
    '/admin_dashboard': 'admin_dashboard.php',
    '/pos-sale': 'pos-sale.php',
    '/sales-history': 'sales-history.php',
    '/staff_dashboard': 'staff_dashboard.php',
    '/manage-brands': 'manage-brands.php',
    '/manage-categories': 'manage-categories.php',
    '/view-products': 'view-products.php',
    '/add-product': 'add-product.php',
    '/customer-purchases': 'customer-purchases.php',
    '/staff-pos': 'staff-pos.php',
    '/staff-sales-history': 'staff-sales-history.php',
    '/staff-products': 'staff-products.php',
    '/submit-review': 'submit-review.php',
    '/brand-products': 'brand-products.php',
    '/all-products': 'all-products.php',
    '/reset-password': 'reset-password.php'
};

// Handle all defined routes
Object.keys(routes).forEach(route => {
    app.get(route, (req, res) => {
        const phpFilePath = path.join(__dirname, 'frontend', routes[route]);
        const htmlContent = processPHPFile(phpFilePath);
        
        if (htmlContent) {
            res.setHeader('Content-Type', 'text/html; charset=utf-8');
            res.setHeader('Cache-Control', 'no-cache');
            res.send(htmlContent);
        } else {
            res.status(404).send(`
                <html>
                    <head><title>404 - Page Not Found</title></head>
                    <body>
                        <h1>404 - Page Not Found</h1>
                        <p>The requested page could not be found.</p>
                        <a href="/">Go to Home</a>
                    </body>
                </html>
            `);
        }
    });
});

// Handle direct PHP file requests
app.get('*.php', (req, res) => {
    const phpFilePath = path.join(__dirname, 'frontend', req.path);
    const htmlContent = processPHPFile(phpFilePath);
    
    if (htmlContent) {
        res.setHeader('Content-Type', 'text/html; charset=utf-8');
        res.setHeader('Cache-Control', 'no-cache');
        res.send(htmlContent);
    } else {
        res.status(404).send(`
            <html>
                <head><title>404 - File Not Found</title></head>
                <body>
                    <h1>404 - File Not Found</h1>
                    <p>The requested PHP file could not be found.</p>
                    <a href="/">Go to Home</a>
                </body>
            </html>
        `);
    }
});

// Catch-all route for any other requests
app.get('*', (req, res) => {
    // Try to find a PHP file for this route
    let phpFilePath = path.join(__dirname, 'frontend', req.path + '.php');
    
    if (!fs.existsSync(phpFilePath)) {
        phpFilePath = path.join(__dirname, 'frontend', req.path, 'index.php');
    }
    
    const htmlContent = processPHPFile(phpFilePath);
    
    if (htmlContent) {
        res.setHeader('Content-Type', 'text/html; charset=utf-8');
        res.setHeader('Cache-Control', 'no-cache');
        res.send(htmlContent);
    } else {
        // Fallback to index.php
        const indexPath = path.join(__dirname, 'frontend', 'index.php');
        const indexContent = processPHPFile(indexPath);
        
        if (indexContent) {
            res.setHeader('Content-Type', 'text/html; charset=utf-8');
            res.setHeader('Cache-Control', 'no-cache');
            res.send(indexContent);
        } else {
            res.status(404).send(`
                <html>
                    <head><title>404 - Page Not Found</title></head>
                    <body>
                        <h1>404 - Page Not Found</h1>
                        <p>The requested page could not be found.</p>
                        <a href="/">Go to Home</a>
                    </body>
                </html>
            `);
        }
    }
});

app.listen(PORT, () => {
    console.log(`🏋️ Protein Planet Server running on port ${PORT}`);
    console.log(`🌐 Visit: http://localhost:${PORT}`);
    console.log(`📱 Health check: http://localhost:${PORT}/health`);
});
