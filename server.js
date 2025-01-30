const express = require('express');
const app = express();
const port = 3000;

// Middleware to parse JSON bodies
app.use(express.json());
// Serve static files from current directory
app.use(express.static('./'));

// Handle POST requests to /sendemail.php
app.post('/sendemail.php', (req, res) => {
    // Mock response for testing
    console.log('Received test data:', req.body);
    res.json({
        success: true,
        message: 'Test email would have been sent'
    });
});

app.listen(port, () => {
    console.log(`Test server running at http://localhost:${port}`);
}); 