# 🔄 Applicator Progress Bar System

A comprehensive progress bar system for tracking applicator part lifespan progress based on HP model specifications. This system calculates percentage progress for each part relative to its min and max range values and displays the results in visually appealing HTML progress bars.

## 📋 Features

- **HP Model Specifications**: Complete database of HP model specifications with min-max ranges for each part
- **Real-time Calculations**: Dynamic percentage calculation based on current output values
- **Visual Progress Bars**: Color-coded progress bars with smooth animations
- **Responsive Design**: Mobile-friendly and accessible interface
- **Dual Implementation**: Both JavaScript and PHP versions available
- **Custom Parts Support**: Handles custom parts with flexible JSON storage
- **Error Handling**: Robust error handling and validation
- **API Integration**: RESTful API endpoints for data fetching

## 🏗️ Architecture

### Database Tables Used
- `applicators`: Contains HP model information
- `monitor_applicator`: Contains cumulative output data for each part
- `applicator_outputs`: Contains individual output records

### File Structure
```
├── public/
│   ├── assets/
│   │   ├── js/utils/
│   │   │   └── progress_bar.js          # JavaScript implementation
│   │   └── css/
│   │       └── progress_bar.css         # Progress bar styles
│   ├── ajax/
│   │   └── get_applicator_progress.php  # AJAX endpoint
│   └── progress_demo.php                # Demo page
├── app/
│   └── includes/
│       └── progress_bar_helper.php      # PHP implementation
└── PROGRESS_BAR_README.md               # This file
```

## 🚀 Quick Start

### 1. JavaScript Implementation

Include the JavaScript file:
```html
<script src="assets/js/utils/progress_bar.js"></script>
```

Load progress bars for an applicator:
```javascript
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
```

### 2. PHP Implementation

Include the PHP helper file:
```php
<?php
require_once 'app/includes/progress_bar_helper.php';
?>
```

Fetch and display progress bars:
```php
<?php
// Fetch progress bars for applicator ID 1
$progressHtml = fetchAndDisplayProgress($pdo, 1);
echo $progressHtml;
?>
```

## 📊 HP Model Specifications

The system includes specifications for all HP models with min-max ranges for each part:

| HP Model | Wire Crimper | Wire Anvil | Insulation Crimper | Insulation Anvil |
|----------|-------------|------------|-------------------|------------------|
| HP-1354  | 500K-1M     | 500K-1M    | 500K-1M           | 500K-1M          |
| HP-1511  | 300K-600K   | 300K-600K  | 500K-1M           | 500K-1M          |
| HP-486   | 150K-300K   | 150K-300K  | 500K-1M           | 500K-1M          |

*Complete specifications available in the code files*

## 🎨 Progress Bar Colors

Progress bars are color-coded based on percentage values:

- **🟢 Green (Success)**: 0-49% - Normal operation
- **🔵 Blue (Info)**: 50-74% - Moderate wear
- **🟠 Orange (Warning)**: 75-89% - High wear, consider maintenance
- **🔴 Red (Danger)**: 90-100% - Critical wear, immediate attention needed

## 🔧 API Reference

### JavaScript Functions

#### `calculateProgress(hpCode, partType, currentValue)`
Calculates percentage progress for a specific part.

**Parameters:**
- `hpCode` (string): HP model code (e.g., "HP-1354")
- `partType` (string): Part type code (e.g., "WC", "WA", "IC", "IA")
- `currentValue` (number): Current output value

**Returns:** `number` - Percentage value between 0-100

**Example:**
```javascript
const percentage = calculateProgress('HP-1354', 'WC', 750000);
console.log(`Wire Crimper progress: ${percentage}%`);
```

#### `createProgressBar(percentage, partName, elementId)`
Creates HTML for a progress bar element.

**Parameters:**
- `percentage` (number): Percentage value (0-100)
- `partName` (string): Display name for the part
- `elementId` (string): Unique ID for the progress bar element

**Returns:** `string` - HTML string for the progress bar

#### `processApplicatorProgress(applicatorData, containerId)`
Processes applicator data and creates progress bars.

**Parameters:**
- `applicatorData` (object): Data from applicator_outputs table
- `containerId` (string): ID of the container to append progress bars

#### `fetchAndDisplayProgress(applicatorId, containerId)`
Fetches applicator data and displays progress bars.

**Parameters:**
- `applicatorId` (number): ID of the applicator
- `containerId` (string): ID of the container to display progress bars

### PHP Functions

#### `calculateProgress($hpCode, $partType, $currentValue)`
Calculates percentage progress for a specific part.

**Parameters:**
- `$hpCode` (string): HP model code
- `$partType` (string): Part type code
- `$currentValue` (int): Current output value

**Returns:** `float` - Percentage value between 0-100

#### `createProgressBar($percentage, $partName, $elementId)`
Creates HTML for a progress bar element.

**Parameters:**
- `$percentage` (float): Percentage value
- `$partName` (string): Display name for the part
- `$elementId` (string): Unique ID for the progress bar element

**Returns:** `string` - HTML string for the progress bar

#### `fetchAndDisplayProgress($pdo, $applicatorId)`
Fetches applicator data from database and returns progress bars.

**Parameters:**
- `$pdo` (PDO): Database connection
- `$applicatorId` (int): ID of the applicator

**Returns:** `string` - HTML string containing progress bars

## 📱 Part Type Codes

| Code | Part Name | Database Column |
|------|-----------|-----------------|
| WC   | Wire Crimper | wire_crimper_output |
| WA   | Wire Anvil | wire_anvil_output |
| IC   | Insulation Crimper | insulation_crimper_output |
| IA   | Insulation Anvil | insulation_anvil_output |
| SC   | Slide Cutter | slide_cutter_output |
| CH   | Cutter Holder | cutter_holder_output |
| SB   | Shear Blade | shear_blade_output |
| CA   | Cutter A | cutter_a_output |
| CB   | Cutter B | cutter_b_output |

## 🔄 AJAX Endpoint

### GET `/ajax/get_applicator_progress.php`

Fetches applicator data for progress bar calculations.

**Parameters:**
- `applicator_id` (required): ID of the applicator

**Response:**
```json
{
    "success": true,
    "applicator": {
        "applicator_id": 1,
        "hp_no": "HP-1354",
        "wire_crimper_output": 750000,
        "wire_anvil_output": 800000,
        "insulation_crimper_output": 600000,
        "insulation_anvil_output": 650000,
        "custom_parts_output": "{\"special_guide_plate\": 450000}"
    }
}
```

## 🎯 Usage Examples

### Example 1: Display Progress Bars in a Dashboard

```html
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/progress_bar.css">
</head>
<body>
    <div id="applicator-progress"></div>
    
    <script src="assets/js/utils/progress_bar.js"></script>
    <script>
        // Load progress bars for applicator ID 1
        fetchAndDisplayProgress(1, 'applicator-progress');
    </script>
</body>
</html>
```

### Example 2: Calculate Individual Part Progress

```javascript
// Calculate progress for Wire Crimper
const hpCode = 'HP-1354';
const currentValue = 750000;
const percentage = calculateProgress(hpCode, 'WC', currentValue);

// Create progress bar
const progressBarHtml = createProgressBar(percentage, 'Wire Crimper', 'wc-progress');
document.getElementById('container').innerHTML = progressBarHtml;
```

### Example 3: PHP Integration in Existing Page

```php
<?php
require_once 'app/includes/progress_bar_helper.php';
require_once 'app/includes/db.php';

// Fetch progress bars for applicator ID 1
$progressHtml = fetchAndDisplayProgress($pdo, 1);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/progress_bar.css">
</head>
<body>
    <h1>Applicator Progress</h1>
    <?php echo $progressHtml; ?>
</body>
</html>
```

## 🎨 Customization

### Styling
The progress bars can be customized by modifying `public/assets/css/progress_bar.css`:

```css
/* Custom progress bar colors */
.progress-success {
    background: linear-gradient(90deg, #your-color-1, #your-color-2);
}

/* Custom progress bar height */
.progress-bar-container {
    height: 15px; /* Default is 12px */
}
```

### HP Specifications
Add new HP models or modify existing specifications in both JavaScript and PHP files:

```javascript
// In progress_bar.js
const hpSpecs = {
    "HP-NEW": { 
        WC: [400000, 800000], 
        WA: [400000, 800000], 
        IC: [400000, 800000], 
        IA: [400000, 800000] 
    }
};
```

## 🛠️ Installation

1. **Copy Files**: Copy all progress bar files to your project
2. **Include CSS**: Add the CSS file to your HTML pages
3. **Include JavaScript**: Add the JavaScript file to your HTML pages
4. **Database**: Ensure your database has the required tables and data
5. **Test**: Visit `/progress_demo.php` to test the system

## 🔍 Troubleshooting

### Common Issues

1. **Progress bars not loading**
   - Check browser console for JavaScript errors
   - Verify AJAX endpoint is accessible
   - Ensure applicator ID exists in database

2. **Incorrect percentages**
   - Verify HP model exists in specifications
   - Check that part type codes match
   - Ensure current values are numeric

3. **Styling issues**
   - Verify CSS file is loaded
   - Check for CSS conflicts
   - Ensure proper HTML structure

### Debug Mode

Enable debug logging in JavaScript:
```javascript
// Add to your page
console.log('HP Specs:', hpSpecs);
console.log('Calculated percentage:', calculateProgress('HP-1354', 'WC', 750000));
```

## 📈 Performance Considerations

- **Caching**: Consider caching HP specifications for better performance
- **Lazy Loading**: Load progress bars only when needed
- **Database Optimization**: Use indexed queries for large datasets
- **CDN**: Serve static assets from a CDN for faster loading

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 📞 Support

For support and questions:
- Create an issue in the repository
- Check the demo page at `/progress_demo.php`
- Review the API documentation above

---

**Happy Progress Tracking! 🎉**
