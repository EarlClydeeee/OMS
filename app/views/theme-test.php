<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMS - Theme Test</title>
    <link rel="stylesheet" href="../../public/assets/css/themes.css">
    <link rel="stylesheet" href="../../public/assets/css/base/base.css">
    <link rel="stylesheet" href="../../public/assets/css/components/cards.css">
    <link rel="stylesheet" href="../../public/assets/css/components/buttons.css">
    <link rel="stylesheet" href="../../public/assets/css/components/theme-toggle.css">
    <link rel="stylesheet" href="../../public/assets/css/dark-mode.css">
</head>
<body>
    <div class="container">
        <div class="main-content">
            <h1>Dark Mode Test Page</h1>
            <p>This page demonstrates the dark mode functionality across different components.</p>
            
            <div class="card">
                <div class="card-content">
                    <h2>Sample Card</h2>
                    <p>This is a sample card to test dark mode styling.</p>
                    <div class="button-group">
                        <button class="btn-primary">Primary Button</button>
                        <button class="btn-secondary">Secondary Button</button>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <h3>Form Elements</h3>
                    <div class="form-group">
                        <label class="form-label">Sample Input</label>
                        <input type="text" class="form-input" placeholder="Enter text here">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sample Textarea</label>
                        <textarea class="form-input" placeholder="Enter description here" rows="3"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <h3>Status Indicators</h3>
                    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                        <span class="status-badge good">Good Status</span>
                        <span class="status-badge warning">Warning Status</span>
                        <span class="status-badge critical">Critical Status</span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <h3>Progress Bars</h3>
                    <div class="progress-container">
                        <div class="progress-label">Good Progress</div>
                        <div class="progress-bar">
                            <div class="progress-fill good" style="width: 75%;"></div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-label">Warning Progress</div>
                        <div class="progress-bar">
                            <div class="progress-fill warning" style="width: 85%;"></div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-label">Critical Progress</div>
                        <div class="progress-bar">
                            <div class="progress-fill critical" style="width: 95%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../../public/assets/js/theme-manager.js"></script>
</body>
</html>
