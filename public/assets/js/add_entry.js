// Global variables
        let currentTab = 'machines';
        let currentMode = 'create'; // 'create' or 'edit'
        let currentEditId = null;

        // Tab switching functionality
        function switchTab(tab) {
            currentTab = tab;
            
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Show/hide tables
            document.querySelectorAll('.entries-table-card').forEach(card => {
                card.classList.remove('active');
            });
            
            if (tab === 'machines') {
                document.getElementById('machines-table').classList.add('active');
            } else if (tab === 'applicators') {
                document.getElementById('applicators-table').classList.add('active');
            }
        }