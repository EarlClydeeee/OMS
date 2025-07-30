<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Bar</title>
    <link rel="stylesheet" href="../../public/assets/css/sideBar.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2 class="sidebar-title">SOMS</h2>
                <button class="toggle-btn" onclick="toggleSidebar()">
                    <i data-lucide="menu"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <button class="active" onclick="setActiveTab('dashboard')">
                            <i data-lucide="bar-chart-3"></i>
                            <span>Dashboard</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button onclick="setActiveTab('users')">
                            <i data-lucide="users"></i>
                            <span>Users</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button onclick="setActiveTab('users')">
                            <i data-lucide="users"></i>
                            <span>Add/Replace</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button onclick="setActiveTab('content')">
                            <i data-lucide="file-text"></i>
                            <span>Machine</span>
                        </button>
                    <li class="nav-item">
                        <button onclick="setActiveTab('content')">
                            <i data-lucide="file-text"></i>
                            <span>Applicator</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button onclick="setActiveTab('security')">
                            <i data-lucide="wrench"></i>
                            <span>Maintenance</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button onclick="setActiveTab('settings')">
                            <i data-lucide="file-text"></i>
                            <span>Logs</span>
                        </button>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="user-avatar">O</div>
                <div class="user-info">
                    <p>Operator</p>
                    <p class="user-email">operator@soms.com</p>
                </div>
            </div>
        </div>
    <script src="../../public/assets/js/sidebar.js"></script>
</body>
</html>