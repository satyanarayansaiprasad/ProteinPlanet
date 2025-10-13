const express = require('express');
const path = require('path');
const fs = require('fs');
const app = express();
const PORT = process.env.PORT || 3000;

// Function to process PHP file and return HTML content
function processPHPFile(filePath) {
    if (fs.existsSync(filePath)) {
        let content = fs.readFileSync(filePath, 'utf8');
        
        // Remove PHP tags and server-side code, keep only HTML/JS/CSS
        content = content.replace(/<\?php[\s\S]*?\?>/g, '');
        content = content.replace(/<\?=[\s\S]*?\?>/g, '');
        
        return content;
    }
    return null;
}

// Serve static files from frontend directory (CSS, JS, images, etc.)
app.use(express.static(path.join(__dirname, 'frontend')));

// Handle all routes - this catches everything
app.get('*', (req, res) => {
    const requestedPath = req.path;
    
    // If it's a static file (CSS, JS, images), let Express handle it
    if (requestedPath.includes('.') && !requestedPath.endsWith('.php')) {
        const staticFilePath = path.join(__dirname, 'frontend', requestedPath);
        
        // If static file exists, serve it normally
        if (fs.existsSync(staticFilePath)) {
            return res.sendFile(staticFilePath);
        }
    }
    
    // Try to find the requested PHP file
    let phpFilePath;
    
    // If path ends with .php, use it directly
    if (requestedPath.endsWith('.php')) {
        phpFilePath = path.join(__dirname, 'frontend', requestedPath);
    } else {
        // Try adding .php extension
        phpFilePath = path.join(__dirname, 'frontend', requestedPath + '.php');
        
        // If that doesn't exist, try with /index.php
        if (!fs.existsSync(phpFilePath)) {
            phpFilePath = path.join(__dirname, 'frontend', requestedPath, 'index.php');
        }
    }
    
    // Process the PHP file
    const htmlContent = processPHPFile(phpFilePath);
    
    if (htmlContent) {
        // Set proper content type for HTML
        res.setHeader('Content-Type', 'text/html; charset=utf-8');
        res.send(htmlContent);
    } else {
        // If no PHP file found, try to serve index.php as fallback
        const indexPath = path.join(__dirname, 'frontend', 'index.php');
        const indexContent = processPHPFile(indexPath);
        
        if (indexContent) {
            res.setHeader('Content-Type', 'text/html; charset=utf-8');
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

// Health check endpoint
app.get('/health', (req, res) => {
    res.json({ 
        status: 'OK', 
        message: 'Protein Planet Server is running!',
        timestamp: new Date().toISOString()
    });
});

app.listen(PORT, () => {
    console.log(`🏋️ Protein Planet Server running on port ${PORT}`);
    console.log(`🌐 Visit: http://localhost:${PORT}`);
    console.log(`📱 Health check: http://localhost:${PORT}/health`);
});
