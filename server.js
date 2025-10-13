const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;

// Serve static files from frontend directory
app.use(express.static(path.join(__dirname, 'frontend')));

// Route all PHP files to be served as static HTML
// Since Firebase handles the backend, we can serve PHP files as static content
app.get('*', (req, res) => {
    const filePath = path.join(__dirname, 'frontend', req.path);
    
    // If it's a PHP file, serve it as static content
    if (req.path.endsWith('.php')) {
        res.sendFile(filePath);
    } else {
        // For all other requests, try to serve the file
        res.sendFile(filePath, (err) => {
            if (err) {
                // If file not found, serve index.php (for SPA-like behavior)
                res.sendFile(path.join(__dirname, 'frontend', 'index.php'));
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
