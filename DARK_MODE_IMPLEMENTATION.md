# Dark Mode Implementation for OMS

## Overview
This document outlines the comprehensive dark mode implementation for the OMS (Output Monitoring System) application. The implementation uses CSS custom properties (variables) and JavaScript to provide a seamless theme switching experience.

## Files Created/Modified

### Core Theme System
- `public/assets/css/themes.css` - CSS custom properties for light and dark themes
- `public/assets/js/theme-manager.js` - JavaScript theme management system
- `public/assets/css/components/theme-toggle.css` - Theme toggle button styles
- `public/assets/css/dark-mode.css` - Dark mode specific overrides

### Updated Files
- `public/assets/css/base/base.css` - Updated to use theme variables
- `public/assets/css/components/sidebar.css` - Updated to use theme variables
- `public/assets/css/components/cards.css` - Updated to use theme variables
- `public/assets/css/components/buttons.css` - Updated to use theme variables
- `public/assets/css/home.css` - Updated to use theme variables
- `public/assets/css/login.css` - Updated to use theme variables
- `app/views/home.php` - Added theme system includes
- `app/views/login.php` - Added theme system includes

### Test Files
- `app/views/theme-test.php` - Test page to demonstrate dark mode functionality

## How It Works

### 1. CSS Custom Properties
The theme system uses CSS custom properties defined in `themes.css`:
- Light theme variables are defined in `:root`
- Dark theme variables are defined in `[data-theme="dark"]`
- All components use these variables instead of hardcoded colors

### 2. JavaScript Theme Manager
The `ThemeManager` class handles:
- Theme detection (system preference or stored preference)
- Theme switching
- Theme persistence in localStorage
- Automatic theme toggle button creation
- System theme change detection

### 3. Theme Toggle Button
- Automatically created by the theme manager
- Positioned in header, sidebar, or as fallback fixed position
- Shows current theme with appropriate icon
- Smooth animations and hover effects

## Usage

### Basic Implementation
To add dark mode to any page, include these files in the correct order:

```html
<link rel="stylesheet" href="../../public/assets/css/themes.css">
<link rel="stylesheet" href="../../public/assets/css/base/base.css">
<!-- Your other CSS files -->
<link rel="stylesheet" href="../../public/assets/css/components/theme-toggle.css">
<link rel="stylesheet" href="../../public/assets/css/dark-mode.css">

<script src="../../public/assets/js/theme-manager.js"></script>
```

### JavaScript API
```javascript
// Get current theme
const currentTheme = window.themeManager.getCurrentTheme();

// Set theme programmatically
window.themeManager.setTheme('dark');
window.themeManager.setTheme('light');

// Toggle theme
window.themeManager.toggleTheme();

// Check if dark mode is active
const isDark = window.themeManager.isDarkMode();
```

## Theme Variables

### Color Variables
- `--primary-color` - Main brand color
- `--secondary-color` - Secondary brand color
- `--background-primary` - Main background color
- `--background-secondary` - Secondary background color
- `--background-card` - Card/component background
- `--text-primary` - Primary text color
- `--text-secondary` - Secondary text color
- `--border-primary` - Primary border color

### Shadow Variables
- `--shadow-sm` - Small shadow
- `--shadow-md` - Medium shadow
- `--shadow-lg` - Large shadow
- `--shadow-xl` - Extra large shadow
- `--shadow-2xl` - 2X large shadow

### Gradient Variables
- `--gradient-primary` - Primary gradient
- `--gradient-secondary` - Secondary gradient
- `--gradient-background` - Background gradient
- `--gradient-card` - Card gradient

### Border Radius Variables
- `--radius-sm` - Small radius (4px)
- `--radius-md` - Medium radius (8px)
- `--radius-lg` - Large radius (12px)
- `--radius-xl` - Extra large radius (16px)
- `--radius-2xl` - 2X large radius (20px)
- `--radius-3xl` - 3X large radius (24px)

### Transition Variables
- `--transition-fast` - Fast transition (0.15s)
- `--transition-normal` - Normal transition (0.3s)
- `--transition-slow` - Slow transition (0.5s)
- `--transition-bounce` - Bounce transition (cubic-bezier)

## Features

### Automatic Theme Detection
- Detects system preference on first visit
- Remembers user's choice in localStorage
- Responds to system theme changes (if no manual preference set)

### Smooth Transitions
- All theme changes are animated
- CSS transitions for color, background, and shadow changes
- Smooth theme toggle button animations

### Accessibility
- High contrast mode support
- Focus indicators for keyboard navigation
- Proper ARIA labels for screen readers

### Responsive Design
- Theme toggle adapts to different screen sizes
- Mobile-optimized toggle button
- Responsive theme variables

## Browser Support
- Modern browsers with CSS custom properties support
- IE11+ with polyfill (if needed)
- Mobile browsers (iOS Safari, Chrome Mobile, etc.)

## Testing
Use the test page at `app/views/theme-test.php` to verify:
- Theme switching functionality
- Component styling in both themes
- Form elements appearance
- Button states and interactions
- Card layouts and shadows
- Progress bars and status indicators

## Customization
To add new theme variables:
1. Add to both light and dark theme sections in `themes.css`
2. Use the variable in your CSS files
3. Update `dark-mode.css` if specific dark mode overrides are needed

## Troubleshooting
- Ensure CSS files are loaded in the correct order
- Check that `theme-manager.js` is loaded after DOM is ready
- Verify that CSS custom properties are supported in target browsers
- Check browser console for JavaScript errors

## Future Enhancements
- Additional theme options (high contrast, custom themes)
- Theme preview functionality
- User preference sync across devices
- Theme-specific animations and effects
