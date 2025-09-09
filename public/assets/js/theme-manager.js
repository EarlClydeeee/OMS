/**
 * Theme Manager - Centralized dark mode management
 * Handles theme switching, persistence, and system preference detection
 */

class ThemeManager {
  constructor() {
    this.theme = this.getStoredTheme() || this.getSystemTheme();
    this.init();
  }

  init() {
    this.applyTheme(this.theme);
    this.createThemeToggle();
    this.setupSystemThemeListener();
  }

  getSystemTheme() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  getStoredTheme() {
    return localStorage.getItem('oms-theme');
  }

  setStoredTheme(theme) {
    localStorage.setItem('oms-theme', theme);
  }

  applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    this.theme = theme;
    this.setStoredTheme(theme);
    this.updateThemeToggle(theme);
    this.updateMetaThemeColor(theme);
  }

  toggleTheme() {
    const newTheme = this.theme === 'light' ? 'dark' : 'light';
    this.applyTheme(newTheme);
    this.animateThemeTransition();
  }

  animateThemeTransition() {
    // Add a temporary class for smooth transition
    document.body.classList.add('theme-transitioning');
    setTimeout(() => {
      document.body.classList.remove('theme-transitioning');
    }, 300);
  }

  updateThemeToggle(theme) {
    const toggle = document.getElementById('theme-toggle');
    if (toggle) {
      toggle.classList.toggle('active', theme === 'dark');
      const icon = toggle.querySelector('.theme-icon');
      if (icon) {
        icon.textContent = theme === 'dark' ? '☀️' : '🌙';
      }
    }
  }

  updateMetaThemeColor(theme) {
    let metaThemeColor = document.querySelector('meta[name="theme-color"]');
    if (!metaThemeColor) {
      metaThemeColor = document.createElement('meta');
      metaThemeColor.name = 'theme-color';
      document.head.appendChild(metaThemeColor);
    }
    metaThemeColor.content = theme === 'dark' ? '#0A0A0A' : '#FFFFFF';
  }

  createThemeToggle() {
    // Check if toggle already exists
    if (document.getElementById('theme-toggle')) return;

    const toggle = document.createElement('button');
    toggle.id = 'theme-toggle';
    toggle.className = 'theme-toggle';
    toggle.innerHTML = `
      <span class="theme-icon">${this.theme === 'dark' ? '☀️' : '🌙'}</span>
      <span class="theme-label">${this.theme === 'dark' ? 'Light' : 'Dark'}</span>
    `;
    toggle.setAttribute('aria-label', 'Toggle theme');
    toggle.setAttribute('title', `Switch to ${this.theme === 'dark' ? 'light' : 'dark'} mode`);

    // Add click event
    toggle.addEventListener('click', () => this.toggleTheme());

    // Try to add to header first, then sidebar, then body
    const header = document.querySelector('.header, .sidebar-header, header');
    const sidebar = document.querySelector('.sidebar');
    
    if (header) {
      header.appendChild(toggle);
    } else if (sidebar) {
      sidebar.appendChild(toggle);
    } else {
      // Fallback: add to body with fixed positioning
      toggle.style.position = 'fixed';
      toggle.style.top = '20px';
      toggle.style.right = '20px';
      toggle.style.zIndex = '9999';
      document.body.appendChild(toggle);
    }
  }

  setupSystemThemeListener() {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', (e) => {
      // Only auto-switch if user hasn't manually set a preference
      if (!this.getStoredTheme()) {
        this.applyTheme(e.matches ? 'dark' : 'light');
      }
    });
  }

  // Public API
  setTheme(theme) {
    if (theme === 'light' || theme === 'dark') {
      this.applyTheme(theme);
    }
  }

  getCurrentTheme() {
    return this.theme;
  }

  // Utility method to check if dark mode is active
  isDarkMode() {
    return this.theme === 'dark';
  }
}

// Initialize theme manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  window.themeManager = new ThemeManager();
});

// Export for use in other scripts
window.ThemeManager = ThemeManager;
