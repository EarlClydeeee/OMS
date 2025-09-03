<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicator Progress Bar Demo</title>
    <link rel="stylesheet" href="assets/css/progress_bar.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .demo-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .demo-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .demo-header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .demo-header p {
            color: #666;
            font-size: 1.1em;
        }
        
        .demo-section {
            margin-bottom: 40px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #fafafa;
        }
        
        .demo-section h2 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        
        .input-group input, .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .btn {
            background: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        
        .btn:hover {
            background: #0056b3;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #545b62;
        }
        
        .code-example {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-bottom: none;
            cursor: pointer;
            margin-right: 5px;
            border-radius: 6px 6px 0 0;
        }
        
        .tab.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="demo-container">
        <div class="demo-header">
            <h1>🔄 Applicator Progress Bar System</h1>
            <p>Track part lifespan progress based on HP model specifications</p>
        </div>

        <div class="tabs">
            <div class="tab active" onclick="switchTab('demo')">Demo</div>
            <div class="tab" onclick="switchTab('javascript')">JavaScript Usage</div>
            <div class="tab" onclick="switchTab('php')">PHP Usage</div>
            <div class="tab" onclick="switchTab('api')">API Reference</div>
        </div>

        <!-- Demo Tab -->
        <div id="demo" class="tab-content active">
            <div class="demo-section">
                <h2>🚀 Live Demo</h2>
                <p>Enter an applicator ID to see the progress bars in action:</p>
                
                <div class="input-group">
                    <label for="applicatorId">Applicator ID:</label>
                    <input type="number" id="applicatorId" placeholder="Enter applicator ID (e.g., 1, 2, 3...)" value="1">
                </div>
                
                <button class="btn" onclick="loadProgressBars()">Load Progress Bars</button>
                <button class="btn btn-secondary" onclick="loadSampleData()">Load Sample Data</button>
                
                <div id="progressDemoContainer"></div>
            </div>
        </div>

        <!-- JavaScript Usage Tab -->
        <div id="javascript" class="tab-content">
            <div class="demo-section">
                <h2>📜 JavaScript Implementation</h2>
                
                <h3>1. Include the JavaScript file:</h3>
                <div class="code-example">
&lt;script src="assets/js/utils/progress_bar.js"&gt;&lt;/script&gt;
                </div>
                
                <h3>2. Load progress bars for an applicator:</h3>
                <div class="code-example">
// Load progress bars for applicator ID 1
fetchAndDisplayProgress(1, 'progress-container');

// Or process data manually
const applicatorData = {
    applicator_id: 1,
    hp_no: 'HP-1354',
    wire_crimper_output: 750000,
    wire_anvil_output: 800000,
    insulation_crimper_output: 600000,
    insulation_anvil_output: 650000
};

processApplicatorProgress(applicatorData, 'progress-container');
                </div>
                
                <h3>3. Calculate individual part progress:</h3>
                <div class="code-example">
// Calculate progress for Wire Crimper
const percentage = calculateProgress('HP-1354', 'WC', 750000);
console.log(`Wire Crimper progress: ${percentage}%`);

// Create a single progress bar
const progressBarHtml = createProgressBar(percentage, 'Wire Crimper', 'wc-progress');
document.getElementById('container').innerHTML = progressBarHtml;
                </div>
            </div>
        </div>

        <!-- PHP Usage Tab -->
        <div id="php" class="tab-content">
            <div class="demo-section">
                <h2>🐘 PHP Implementation</h2>
                
                <h3>1. Include the PHP helper file:</h3>
                <div class="code-example">
&lt;?php
require_once 'app/includes/progress_bar_helper.php';
?&gt;
                </div>
                
                <h3>2. Fetch and display progress bars:</h3>
                <div class="code-example">
&lt;?php
// Fetch progress bars for applicator ID 1
$progressHtml = fetchAndDisplayProgress($pdo, 1);
echo $progressHtml;
?&gt;
                </div>
                
                <h3>3. Calculate individual part progress:</h3>
                <div class="code-example">
&lt;?php
// Calculate progress for Wire Crimper
$percentage = calculateProgress('HP-1354', 'WC', 750000);
echo "Wire Crimper progress: " . $percentage . "%";

// Create a single progress bar
$progressBarHtml = createProgressBar($percentage, 'Wire Crimper', 'wc-progress');
echo $progressBarHtml;
?&gt;
                </div>
                
                <h3>4. Process custom data:</h3>
                <div class="code-example">
&lt;?php
$applicatorData = [
    'applicator_id' => 1,
    'hp_no' => 'HP-1354',
    'wire_crimper_output' => 750000,
    'wire_anvil_output' => 800000,
    'insulation_crimper_output' => 600000,
    'insulation_anvil_output' => 650000,
    'custom_parts_output' => '{"special_guide_plate": 450000, "tension_spring": 350000}'
];

$progressHtml = processApplicatorProgress($applicatorData);
echo $progressHtml;
?&gt;
                </div>
            </div>
        </div>

        <!-- API Reference Tab -->
        <div id="api" class="tab-content">
            <div class="demo-section">
                <h2>📚 API Reference</h2>
                
                <h3>JavaScript Functions:</h3>
                <div class="code-example">
// Calculate progress percentage
calculateProgress(hpCode, partType, currentValue)
// Returns: number (0-100)

// Create progress bar HTML
createProgressBar(percentage, partName, elementId)
// Returns: string (HTML)

// Update existing progress bar
updateProgressBar(elementId, percentage)
// Returns: void

// Process applicator data
processApplicatorProgress(applicatorData, containerId)
// Returns: void

// Fetch and display progress
fetchAndDisplayProgress(applicatorId, containerId)
// Returns: Promise
                </div>
                
                <h3>PHP Functions:</h3>
                <div class="code-example">
// Calculate progress percentage
calculateProgress($hpCode, $partType, $currentValue)
// Returns: float (0-100)

// Create progress bar HTML
createProgressBar($percentage, $partName, $elementId)
// Returns: string (HTML)

// Calculate custom part progress
calculateCustomPartProgress($value)
// Returns: float (0-100)

// Process applicator data
processApplicatorProgress($applicatorData, $containerId)
// Returns: string (HTML)

// Fetch and display progress
fetchAndDisplayProgress($pdo, $applicatorId)
// Returns: string (HTML)
                </div>
                
                <h3>Part Type Codes:</h3>
                <div class="code-example">
WC = Wire Crimper
WA = Wire Anvil
IC = Insulation Crimper
IA = Insulation Anvil
SC = Slide Cutter
CH = Cutter Holder
SB = Shear Blade
CA = Cutter A
CB = Cutter B
                </div>
                
                <h3>Progress Bar Colors:</h3>
                <div class="code-example">
0-49%: Green (Success)
50-74%: Blue (Info)
75-89%: Orange (Warning)
90-100%: Red (Danger)
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/utils/progress_bar.js"></script>
    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }

        function loadProgressBars() {
            const applicatorId = document.getElementById('applicatorId').value;
            if (!applicatorId) {
                alert('Please enter an applicator ID');
                return;
            }
            
            const container = document.getElementById('progressDemoContainer');
            container.innerHTML = '<div class="loading">Loading...</div>';
            
            fetchAndDisplayProgress(parseInt(applicatorId), 'progressDemoContainer');
        }

        function loadSampleData() {
            const container = document.getElementById('progressDemoContainer');
            container.innerHTML = '<div class="loading">Loading sample data...</div>';
            
            // Simulate API call with sample data
            setTimeout(() => {
                const sampleData = {
                    applicator_id: 1,
                    hp_no: 'HP-1354',
                    wire_crimper_output: 750000,
                    wire_anvil_output: 800000,
                    insulation_crimper_output: 600000,
                    insulation_anvil_output: 650000,
                    slide_cutter_output: 450000,
                    cutter_holder_output: 500000,
                    shear_blade_output: 350000,
                    cutter_a_output: 400000,
                    cutter_b_output: 300000,
                    custom_parts_output: '{"special_guide_plate": 450000, "tension_spring": 350000}'
                };
                
                processApplicatorProgress(sampleData, 'progressDemoContainer');
            }, 1000);
        }

        // Load sample data on page load
        window.addEventListener('load', () => {
            loadSampleData();
        });
    </script>
</body>
</html>
