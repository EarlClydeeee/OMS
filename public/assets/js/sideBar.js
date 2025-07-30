// Initialize Lucide icons
        lucide.createIcons();

        // Global state
        let sidebarOpen = true;
        let activeTab = 'dashboard';

        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebarOpen = !sidebarOpen;
            
            if (sidebarOpen) {
                sidebar.classList.remove('collapsed');
            } else {
                sidebar.classList.add('collapsed');
            }
        }

        // Tab switching
        function setActiveTab(tabName) {
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.add('hidden'));
            
            // Show selected tab
            const selectedTab = document.getElementById(tabName + '-tab');
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }
            
            // Update navigation
            const navButtons = document.querySelectorAll('.nav-item button');
            navButtons.forEach(btn => btn.classList.remove('active'));
            
            const activeButton = document.querySelector(`[onclick="setActiveTab('${tabName}')"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }
            
            activeTab = tabName;
        }

        // Initialize the interface
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize icons
            lucide.createIcons();
            
            // Set initial state
            setActiveTab('dashboard');
            
            // Simulate real-time updates
            setInterval(updateStats, 30000); // Update every 30 seconds
        });

        // Simulate real-time stat updates
        function updateStats() {
            const cutOps = document.querySelector('.stat-card:nth-child(2) .stat-value');
            const stripOps = document.querySelector('.stat-card:nth-child(3) .stat-value');
            const totalOps = document.querySelector('.stat-card:nth-child(1) .stat-value');
            
            if (cutOps && stripOps && totalOps) {
                const currentCut = parseInt(cutOps.textContent.replace(',', ''));
                const currentStrip = parseInt(stripOps.textContent.replace(',', ''));
                
                // Add random increments (simulating ongoing operations)
                const cutIncrement = Math.floor(Math.random() * 5) + 1;
                const stripIncrement = Math.floor(Math.random() * 4) + 1;
                
                const newCut = currentCut + cutIncrement;
                const newStrip = currentStrip + stripIncrement;
                const newTotal = newCut + newStrip;
                
                cutOps.textContent = newCut.toLocaleString();
                stripOps.textContent = newStrip.toLocaleString();
                totalOps.textContent = newTotal.toLocaleString();
            }
        }