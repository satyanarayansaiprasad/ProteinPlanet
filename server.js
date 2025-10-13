const express = require('express');
const path = require('path');
const fs = require('fs');
const app = express();
const PORT = process.env.PORT || 3000;

// Serve static files from frontend directory
app.use(express.static(path.join(__dirname, 'frontend')));

// Handle PHP files by converting them to HTML responses
app.get('*.php', (req, res) => {
    const phpFilePath = path.join(__dirname, 'frontend', req.path);
    
    // Check if PHP file exists
    if (fs.existsSync(phpFilePath)) {
        // Read the PHP file content
        let content = fs.readFileSync(phpFilePath, 'utf8');
        
        // Remove PHP tags and server-side code, keep only HTML/JS/CSS
        content = content.replace(/<\?php[\s\S]*?\?>/g, '');
        content = content.replace(/<\?=[\s\S]*?\?>/g, '');
        
        // Set content type to HTML
        res.setHeader('Content-Type', 'text/html; charset=utf-8');
        res.send(content);
    } else {
        res.status(404).send('File not found');
    }
});

// Handle root and other routes
app.get('*', (req, res) => {
    const filePath = path.join(__dirname, 'frontend', req.path);
    
    // If it's not a PHP file, try to serve it normally
    if (!req.path.endsWith('.php')) {
        res.sendFile(filePath, (err) => {
            if (err) {
                // If file not found, serve index.php as HTML
                const indexPath = path.join(__dirname, 'frontend', 'index.php');
                if (fs.existsSync(indexPath)) {
                    let content = fs.readFileSync(indexPath, 'utf8');
                    content = content.replace(/<\?php[\s\S]*?\?>/g, '');
                    content = content.replace(/<\?=[\s\S]*?\?>/g, '');
                    res.setHeader('Content-Type', 'text/html; charset=utf-8');
                    res.send(content);
                } else {
                    res.status(404).send('Page not found');
                }
            }
        });
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
