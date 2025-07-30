// Initialize Lucide icons
        lucide.createIcons();

        // Global state
        let sidebarOpen = true;
        let activeTab = 'dashboard';
        let selectedUsers = [];
        let allUsers = [
            { id: 1, name: 'John Doe', email: 'john@example.com', role: 'Admin', status: 'Active', lastLogin: '2 mins ago' },
            { id: 2, name: 'Sarah Wilson', email: 'sarah@example.com', role: 'Editor', status: 'Active', lastLogin: '1 hour ago' },
            { id: 3, name: 'Mike Johnson', email: 'mike@example.com', role: 'User', status: 'Inactive', lastLogin: '2 days ago' },
            { id: 4, name: 'Emma Brown', email: 'emma@example.com', role: 'Moderator', status: 'Active', lastLogin: '5 mins ago' },
            { id: 5, name: 'David Lee', email: 'david@example.com', role: 'User', status: 'Pending', lastLogin: 'Never' }
        ];

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

        // User filtering
        function filterUsers() {
            const searchTerm = document.getElementById('userSearch').value.toLowerCase();
            const tableBody = document.getElementById('usersTableBody');
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                const userName = row.querySelector('.user-name').textContent.toLowerCase();
                const userEmail = row.querySelector('.user-email').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Select all users
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            if (selectAllCheckbox.checked) {
                selectedUsers = allUsers.map(user => user.id);
            } else {
                selectedUsers = [];
            }
        }

        // Handle individual user selection
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('user-checkbox')) {
                const userId = parseInt(e.target.dataset.userId);
                
                if (e.target.checked) {
                    if (!selectedUsers.includes(userId)) {
                        selectedUsers.push(userId);
                    }
                } else {
                    selectedUsers = selectedUsers.filter(id => id !== userId);
                }
                
                // Update select all checkbox
                const selectAllCheckbox = document.getElementById('selectAll');
                const userCheckboxes = document.querySelectorAll('.user-checkbox');
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                
                selectAllCheckbox.checked = checkedBoxes.length === userCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < userCheckboxes.length;
            }
        });

        // Action button handlers
        document.addEventListener('click', function(e) {
            if (e.target.closest('.action-btn')) {
                const button = e.target.closest('.action-btn');
                const row = button.closest('tr');
                const userName = row.querySelector('.user-name').textContent;
                
                if (button.classList.contains('view')) {
                    alert(`View user: ${userName}`);
                } else if (button.classList.contains('edit')) {
                    alert(`Edit user: ${userName}`);
                } else if (button.classList.contains('delete')) {
                    if (confirm(`Delete user: ${userName}?`)) {
                        row.remove();
                    }
                }
            }
        });

        // Initialize the interface
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize icons
            lucide.createIcons();
            
            // Set initial state
            setActiveTab('dashboard');
        });